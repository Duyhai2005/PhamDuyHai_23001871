<?php

require_once __DIR__ . '/../common/functions.php';
require_once __DIR__ . '/../common/auth.php';
$pageTitle = isset($pageTitle) ? $pageTitle : 'Quản lý sản phẩm';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escapeHtml($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="container">
    <header class="site-header">
        <h1>Quản lý sản phẩm</h1>
        <nav>
            <?php if (isLoggedIn()): ?>
            <a href="product_list.php">Danh sách sản phẩm</a>
            <a href="product_add.php">Thêm sản phẩm</a>
            <span>Tài khoản: <strong><?= escapeHtml($_SESSION['username']) ?></strong></span>
            <a href="logout.php">Đăng xuất</a>
            <?php else: ?>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
            <?php endif; ?>
        </nav>
    </header>
