<?php

class ShoppingCart
{
    private $items = [];

    public function addItem($item)
    {
        if (!($item instanceof CartItem)) {
            echo '<p>Không thể thêm sản phẩm không hợp lệ.</p>';
            return false;
        }

        if (trim($item->name) === '') {
            echo '<p>Tên sản phẩm không được để trống.</p>';
            return false;
        }

        if ($item->price <= 0) {
            echo '<p>Không thể thêm sản phẩm có đơn giá nhỏ hơn hoặc bằng 0.</p>';
            return false;
        }

        if ($item->quantity <= 0) {
            echo '<p>Không thể thêm sản phẩm có số lượng nhỏ hơn hoặc bằng 0.</p>';
            return false;
        }

        $this->items[] = $item;
        return true;
    }

    public function removeItem($name)
    {
        foreach ($this->items as $index => $item) {
            if ($item->name === $name) {
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                echo '<p>Đã xóa sản phẩm: ' . htmlspecialchars($name) . '.</p>';
                return true;
            }
        }

        echo '<p>Không tìm thấy sản phẩm cần xóa: ' . htmlspecialchars($name) . '.</p>';
        return false;
    }

    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function displayCart()
    {
        if (count($this->items) === 0) {
            echo '<p>Giỏ hàng đang trống.</p>';
            return;
        }

        echo '<table border="1" cellpadding="8" cellspacing="0">';
        echo '<tr><th>Tên sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr>';

        foreach ($this->items as $item) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item->name) . '</td>';
            echo '<td>' . number_format($item->price, 0, ',', '.') . ' đ</td>';
            echo '<td>' . $item->quantity . '</td>';
            echo '<td>' . number_format($item->getTotal(), 0, ',', '.') . ' đ</td>';
            echo '</tr>';
        }

        echo '<tr><th colspan="3">Tổng tiền</th><th>' . number_format($this->calculateTotal(), 0, ',', '.') . ' đ</th></tr>';
        echo '</table>';
    }
}
