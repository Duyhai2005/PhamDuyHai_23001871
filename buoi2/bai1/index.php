<?php

require_once __DIR__ . '/CartItem.php';
require_once __DIR__ . '/ShoppingCart.php';

echo '<!DOCTYPE html>';
echo '<html lang="vi">';
echo '<head><meta charset="UTF-8"><title>Bài 1 - Giỏ hàng</title></head>';
echo '<body>';
echo '<h1>Bài 1 - Quản lý giỏ hàng</h1>';

$cart = new ShoppingCart();

$cart->addItem(new CartItem('Laptop', 15000000, 1));
$cart->addItem(new CartItem('Chuột không dây', 350000, 2));
$cart->addItem(new CartItem('Bàn phím', 750000, 1));
$cart->addItem(new CartItem('Tai nghe', 1200000, 1));

echo '<h2>Giỏ hàng ban đầu</h2>';
$cart->displayCart();
echo '<p>Tổng tiền: ' . number_format($cart->calculateTotal(), 0, ',', '.') . ' đ</p>';

$cart->removeItem('Bàn phím');

echo '<h2>Giỏ hàng sau khi xóa</h2>';
$cart->displayCart();

echo '</body>';
echo '</html>';
