<?php

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/common/functions.php';
require_once __DIR__ . '/model/user.php';

$pageTitle = 'Đăng ký';
$username = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(postString('username'));
    $password = postString('password');
    if ($username === '') {
        $errors[] = 'Tên đăng nhập không được để trống.';
    } elseif (textLength($username) > 50) {
        $errors[] = 'Tên đăng nhập không được vượt quá 50 ký tự.';
    }
    if (trim($password) === '') {
        $errors[] = 'Mật khẩu không được để trống.';
    } elseif (strlen($password) > 72) {
        $errors[] = 'Mật khẩu không được vượt quá 72 byte.';
    }

    if (count($errors) === 0) {
        if (getUserByUsername($username) !== false || !registerUser($username, $password)) {
            $errors[] = 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';
        } else {
            $_SESSION['message'] = 'Đăng ký thành công. Bạn có thể đăng nhập.';
            header('Location: login.php');
            exit;
        }
    }
}

require __DIR__ . '/view/header.php';
?>
<section class="panel">
    <h2>Đăng ký tài khoản</h2>
    <?php if (count($errors) > 0): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="register.php">
        <label for="username">Tên đăng nhập</label>
        <input id="username" name="username" type="text" maxlength="50" autocomplete="username" value="<?= escapeHtml($username) ?>" required>
        <label for="password">Mật khẩu</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required>
        <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>
