<?php

require_once __DIR__ . '/app/model/product.php';
require_once __DIR__ . '/app/common/functions.php';

$pageTitle = 'Danh sách sản phẩm';
$products = getAllProducts();
$message = isset($_GET['message']) ? $_GET['message'] : '';

require __DIR__ . '/app/view/header.php';
?>
<section class="panel">
    <h2>Danh sách sản phẩm</h2>
    <?php if ($message !== ''): ?>
        <p class="message"><?= escapeHtml($message) ?></p>
    <?php endif; ?>
    <?php if (count($products) === 0): ?>
        <p>Chưa có sản phẩm. Hãy thêm sản phẩm mới.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= escapeHtml($product['id']) ?></td>
                        <td><?= escapeHtml($product['name']) ?></td>
                        <td><?= number_format((float) $product['price'], 2, ',', '.') ?> đ</td>
                        <td><?= escapeHtml($product['quantity']) ?></td>
                        <td class="actions">
                            <a href="product_edit.php?id=<?= urlencode($product['id']) ?>">Sửa</a>
                            <a href="product_delete.php?id=<?= urlencode($product['id']) ?>">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/app/view/footer.php'; ?>
