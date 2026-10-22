
<?php
$prices = [125000, 80000, 250000, 45000, 175000, 200000];

function calculateTotal($prices) {
    $total = 0;

    foreach ($prices as $price) {
        $total += $price;
    }

    return $total;
}

function findMaxPrice($prices) {
    $maxPrice = $prices[0];

    foreach ($prices as $price) {
        if ($price > $maxPrice) {
            $maxPrice = $price;
        }
    }

    return $maxPrice;
}

$total = calculateTotal($prices);
$max = findMaxPrice($prices);

echo "Tổng giá trị: " . $total . " VNĐ<br>";
echo "Giá cao nhất: " . $max . " VNĐ";
?>
