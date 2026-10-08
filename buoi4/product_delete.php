<?php

require_once __DIR__ . '/app/model/product.php';
require_once __DIR__ . '/app/common/functions.php';

$pageTitle = 'Xóa sản phẩm';
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : false;

if ($id === false || $id < 1) {
    header('Location: product_list.php?message=' . urlencode('Mã sản phẩm không hợp lệ.'));
    exit;
}

$product = getProductById($id);
if ($product === false) {
    $product = null;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $product !== null) {
    if (deleteProduct($id)) {
        header('Location: product_list.php?message=' . urlencode('Đã xóa sản phẩm thành công.'));
        exit;
    }

    $message = 'Không tìm thấy sản phẩm cần xóa.';
}

require __DIR__ . '/app/view/header.php';
?>
<section class="panel">
    <h2>Xóa sản phẩm</h2>
    <?php if ($product === null): ?>
        <p>Không tìm thấy sản phẩm cần xóa.</p>
        <p><a href="product_list.php">Quay lại danh sách</a></p>
    <?php else: ?>
        <p>Bạn có chắc muốn xóa sản phẩm <strong><?= escapeHtml($product['name']) ?></strong> không?</p>
        <?php if ($message !== ''): ?>
            <p class="errors"><?= escapeHtml($message) ?></p>
        <?php endif; ?>
        <form method="post" action="product_delete.php?id=<?= urlencode($id) ?>">
            <button type="submit" name="confirm" value="1">Xác nhận xóa</button>
            <a href="product_list.php">Hủy</a>
        </form>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/app/view/footer.php'; ?>
