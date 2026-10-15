<?php

require_once __DIR__ . '/common/auth.php';
requireLogin();

require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/functions.php';

$pageTitle = 'Thêm sản phẩm';
$name = '';
$price = '';
$quantity = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = postString('name');
    $price = postString('price');
    $quantity = postString('quantity');
    $errors = validateProductInput($name, $price, $quantity);

    if (count($errors) === 0) {
        addProduct($name, $price, (int) $quantity);
        header('Location: product_list.php?message=' . urlencode('Đã thêm sản phẩm thành công.'));
        exit;
    }
}

require __DIR__ . '/view/header.php';
?>
<section class="panel">
    <h2>Thêm sản phẩm</h2>
    <?php if (count($errors) > 0): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="product_add.php">
        <label for="name">Tên sản phẩm</label>
        <input id="name" name="name" type="text" maxlength="100" value="<?= escapeHtml($name) ?>" required>

        <label for="price">Giá</label>
        <input id="price" name="price" type="number" min="0.01" step="0.01" value="<?= escapeHtml($price) ?>" required>

        <label for="quantity">Số lượng</label>
        <input id="quantity" name="quantity" type="number" min="0" step="1" value="<?= escapeHtml($quantity) ?>" required>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>
