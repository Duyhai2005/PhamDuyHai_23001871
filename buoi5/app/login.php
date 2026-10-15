<?php

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/common/functions.php';
require_once __DIR__ . '/model/user.php';

if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$pageTitle = 'Đăng nhập';
$username = '';
$errors = [];
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(postString('username'));
    $password = postString('password');
    if ($username === '' || trim($password) === '') {
        $errors[] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
    } else {
        $user = getUserByUsername($username);
        if ($user !== false && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        }
        $errors[] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}

require __DIR__ . '/view/header.php';
?>
<section class="panel">
    <h2>Đăng nhập</h2>
    <?php if ($message !== ''): ?>
        <p class="message"><?= escapeHtml($message) ?></p>
    <?php endif; ?>
    <?php if (count($errors) > 0): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label for="username">Tên đăng nhập</label>
        <input id="username" name="username" type="text" maxlength="50" autocomplete="username" value="<?= escapeHtml($username) ?>" required>
        <label for="password">Mật khẩu</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>
