<?php

require_once __DIR__ . '/app/model/product.php';
require_once __DIR__ . '/app/common/functions.php';

$pageTitle = 'Sửa sản phẩm';
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : false;

if ($id === false || $id < 1) {
    header('Location: product_list.php?message=' . urlencode('Mã sản phẩm không hợp lệ.'));
    exit;
}

$product = getProductById($id);
if ($product === false) {
    header('Location: product_list.php?message=' . urlencode('Không tìm thấy sản phẩm cần sửa.'));
    exit;
}

$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $errors = validateProductInput($name, $price, $quantity);

    if (count($errors) === 0) {
        updateProduct($id, $name, $price, (int) $quantity);
        header('Location: product_list.php?message=' . urlencode('Đã cập nhật sản phẩm thành công.'));
        exit;
    }
}

require __DIR__ . '/app/view/header.php';
?>
<section class="panel">
    <h2>Sửa sản phẩm</h2>
    <?php if (count($errors) > 0): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="product_edit.php?id=<?= urlencode($id) ?>">
        <label for="name">Tên sản phẩm</label>
        <input id="name" name="name" type="text" maxlength="100" value="<?= escapeHtml($name) ?>" required>

        <label for="price">Giá</label>
        <input id="price" name="price" type="number" min="0.01" step="0.01" value="<?= escapeHtml($price) ?>" required>

        <label for="quantity">Số lượng</label>
        <input id="quantity" name="quantity" type="number" min="0" step="1" value="<?= escapeHtml($quantity) ?>" required>

        <button type="submit">Lưu thay đổi</button>
    </form>
</section>
<?php require __DIR__ . '/app/view/footer.php'; ?>
