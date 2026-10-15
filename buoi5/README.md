# Bài thực hành buổi 5 - PHP + MySQL

Quản lý sản phẩm: danh sách, thêm, sửa, xác nhận xóa; đăng ký, đăng nhập,
đăng xuất và bảo vệ cả bốn trang sản phẩm bằng session.

## Chạy bài

1. Cần PHP có extension `pdo_mysql` và MySQL đang chạy.
2. Import `database.sql` bằng phpMyAdmin hoặc MySQL Workbench. File tạo
   database `shopping_cart`, bảng `products` có 5 sản phẩm và bảng `users`
   có tài khoản mẫu. Chỉ import dữ liệu mẫu một lần.
3. Cấu hình kết nối trong `app/common/dbConnect.php`, hoặc đặt các biến
   môi trường `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`.
   Mặc định: `localhost:3306`, database `shopping_cart`, user `root`, mật khẩu trống.
4. Từ thư mục gốc repository, chạy:

   ```powershell
   php -d extension=pdo_mysql -S localhost:8000 -t buoi5/app
   ```

5. Mở `http://localhost:8000/`. Đăng nhập bằng **admin / admin123** hoặc
   đăng ký tài khoản mới. Mật khẩu trong database chỉ lưu hash, được tạo
   bằng `password_hash()` và kiểm tra bằng `password_verify()`.

Thư mục `app/` chứa đúng các nhóm `common/`, `model/`, `view/`, `assets/`
và các trang PHP theo đề. Các bài buổi trước được giữ riêng.

## Kiểm thử

```powershell
python buoi5/tests/test_app.py
```

Cần Python 3, PHP và MySQL. Đặt các biến kết nối như trên; user kiểm thử
cần quyền tạo/xóa database. Bộ kiểm thử tự tạo database có tên ngẫu nhiên
`shopping_cart_test_...`, import SQL, chạy HTTP qua PHP server tạm rồi xóa
database kiểm thử. Database `shopping_cart` hiện có không bị thay đổi.

Kiểm tra truy cập GET/POST khi chưa đăng nhập, đăng ký và tên trùng, mật khẩu
sai/đúng, tài khoản mẫu, CRUD, dữ liệu không hợp lệ, hiển thị HTML an toàn,
xác nhận trước khi xóa, ID không tồn tại và truy cập sau đăng xuất.
