"""Kiểm thử HTTP thực tế; tự tạo và xóa database riêng, không dùng dữ liệu bài học."""
import http.cookiejar
import os
from pathlib import Path
import socket
import subprocess
import tempfile
import time
import unittest
import urllib.error
import urllib.parse
import urllib.request
import uuid


ROOT = Path(__file__).resolve().parents[1]
PHP = os.environ.get('PHP_BIN', 'php')


class NoRedirect(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        return None


class AppTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        cls.env = os.environ.copy()
        cls.env['DB_NAME'] = 'shopping_cart_test_' + uuid.uuid4().hex[:12]
        cls.temp = tempfile.TemporaryDirectory()
        cls.log = open(Path(cls.temp.name) / 'php.log', 'w+', encoding='utf-8')
        with socket.socket() as sock:
            sock.bind(('127.0.0.1', 0))
            cls.port = sock.getsockname()[1]
        cls.base = f'http://127.0.0.1:{cls.port}/'
        cls.server = subprocess.Popen([
            PHP, '-d', 'extension=pdo_mysql', '-d', 'extension=mbstring',
            '-d', 'session.save_path=' + cls.temp.name,
            '-S', f'127.0.0.1:{cls.port}', '-t', str(ROOT / 'app')
        ], env=cls.env, stdout=cls.log, stderr=cls.log,
            creationflags=getattr(subprocess, 'CREATE_NO_WINDOW', 0))
        for _ in range(100):
            try:
                with socket.create_connection(('127.0.0.1', cls.port), timeout=.2):
                    break
            except OSError:
                if cls.server.poll() is not None:
                    raise RuntimeError('PHP server could not start')
                time.sleep(.1)

    @classmethod
    def sql(cls, query):
        code = '''$db = new PDO('mysql:host=' . (getenv('DB_HOST') ?: '127.0.0.1')
            . ';port=' . (getenv('DB_PORT') ?: '3306') . ';charset=utf8mb4',
            getenv('DB_USER') === false ? 'root' : getenv('DB_USER'),
            getenv('DB_PASSWORD') === false ? '' : getenv('DB_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $db->exec(stream_get_contents(STDIN));'''
        subprocess.run([PHP, '-d', 'extension=pdo_mysql', '-r', code],
                       input=query, text=True, env=cls.env, check=True, capture_output=True)

    @classmethod
    def tearDownClass(cls):
        cls.server.terminate()
        cls.server.wait(timeout=10)
        cls.log.seek(0)
        log = cls.log.read()
        cls.log.close()
        cls.temp.cleanup()
        if getattr(cls, 'database_created', False):
            cls.sql('DROP DATABASE `' + cls.env['DB_NAME'] + '`')
        for marker in ['PHP Warning', 'PHP Fatal error', 'PHP Deprecated']:
            if marker in log:
                raise AssertionError(log)

    def setUp(self):
        self.client = urllib.request.build_opener(
            urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()), NoRedirect())

    def request(self, path, data=None):
        payload = urllib.parse.urlencode(data).encode() if data is not None else None
        try:
            response = self.client.open(self.base + path, payload, timeout=10)
        except urllib.error.HTTPError as error:
            response = error
        return response.code, response.headers, response.read().decode('utf-8')

    def assertRedirect(self, result, target):
        self.assertEqual(result[0], 302, result[2])
        self.assertTrue(result[1]['Location'].startswith(target), result[1])

    def test_01_protect_every_product_page(self):
        for page in ['product_list.php', 'product_add.php',
                     'product_edit.php?id=1', 'product_delete.php?id=1']:
            for data in [None, {'name': 'Unauthorized', 'price': '10', 'quantity': '1', 'confirm': '1'}]:
                with self.subTest(page=page, method='POST' if data else 'GET'):
                    self.assertRedirect(self.request(page, data), 'login.php')

    def test_02_register_login_crud_logout(self):
        schema = (ROOT / 'database.sql').read_text(encoding='utf-8')
        type(self).database_created = True
        self.sql(schema.replace('shopping_cart', self.env['DB_NAME']))

        self.assertEqual(self.request('register.php')[0], 200)
        empty = self.request('register.php', {'username': ' ', 'password': ' '})
        self.assertEqual(empty[0], 200)
        self.assertIn('không được để trống', empty[2])
        blank_login = self.request('login.php', {'username': '', 'password': ''})
        self.assertEqual(blank_login[0], 200)
        self.assertIn('nhập đầy đủ', blank_login[2])
        self.assertRedirect(self.request('register.php', {
            'username': 'sinhvien', 'password': 'matkhau123'}), 'login.php')
        duplicate = self.request('register.php', {'username': 'SINHVIEN', 'password': 'khac'})
        self.assertEqual(duplicate[0], 200)
        self.assertIn('đã tồn tại', duplicate[2])
        wrong = self.request('login.php', {'username': 'sinhvien', 'password': 'sai'})
        self.assertEqual(wrong[0], 200)
        self.assertIn('không chính xác', wrong[2])
        self.assertRedirect(self.request('product_list.php'), 'login.php')
        self.assertRedirect(self.request('login.php', {
            'username': 'sinhvien', 'password': 'matkhau123'}), 'product_list.php')
        listing = self.request('product_list.php')
        self.assertIn('sinhvien', listing[2])
        self.assertIn('Đăng xuất', listing[2])
        self.assertEqual(listing[2].count('<td class="actions">'), 5)

        for name, price, quantity in [('', '1', '0'), ('Test', '0', '0'),
                                      ('Test', '1', '-1'), ('Test', '1', '1.5'),
                                      ('Test', '0.001', '0'), ('Test', '1', '2147483648')]:
            result = self.request('product_add.php', dict(name=name, price=price, quantity=quantity))
            self.assertEqual(result[0], 200)
            self.assertIn('class="errors"', result[2])
        self.assertRedirect(self.request('product_add.php', {
            'name': '<script>test</script>', 'price': '123.45', 'quantity': '0'}), 'product_list.php')
        self.assertIn('&lt;script&gt;test&lt;/script&gt;', self.request('product_list.php')[2])
        edit = self.request('product_edit.php?id=6')
        self.assertIn('123.45', edit[2])
        self.assertIn('value="0"', edit[2])
        self.assertEqual(self.request('product_edit.php?id=6', {
            'name': 'Test', 'price': '-5', 'quantity': '1'})[0], 200)
        self.assertRedirect(self.request('product_edit.php?id=6', {
            'name': 'Sản phẩm đã sửa', 'price': '250.50', 'quantity': '2'}), 'product_list.php')
        self.assertIn('Sản phẩm đã sửa', self.request('product_list.php')[2])
        self.assertIn('Xác nhận xóa', self.request('product_delete.php?id=6')[2])
        self.request('product_delete.php?id=6', {})
        self.assertIn('Sản phẩm đã sửa', self.request('product_list.php')[2])
        self.assertRedirect(self.request('product_delete.php?id=6', {'confirm': '1'}), 'product_list.php')
        self.assertNotIn('Sản phẩm đã sửa', self.request('product_list.php')[2])
        self.assertIn('Không tìm thấy', self.request('product_delete.php?id=999999')[2])
        self.assertRedirect(self.request('product_edit.php?id=999999'), 'product_list.php')
        self.assertRedirect(self.request('product_edit.php?id=abc'), 'product_list.php')
        self.assertRedirect(self.request('logout.php'), 'login.php')
        self.assertRedirect(self.request('product_list.php'), 'login.php')
        self.assertRedirect(self.request('login.php', {
            'username': 'admin', 'password': 'admin123'}), 'product_list.php')


if __name__ == '__main__':
    unittest.main(verbosity=2)
