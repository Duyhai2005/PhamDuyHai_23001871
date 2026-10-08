<?php

function escapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function validateProductInput($name, $price, $quantity)
{
    $errors = [];
    $name = trim($name);
    $priceValue = trim($price);
    $quantityValue = trim($quantity);
    $nameLength = function_exists('mb_strlen') ? mb_strlen($name, 'UTF-8') : strlen($name);

    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif ($nameLength > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    if ($priceValue === '' || !is_numeric($priceValue) || (float) $priceValue <= 0 || (float) $priceValue > 99999999.99) {
        $errors[] = 'Giá sản phẩm phải lớn hơn 0 và không vượt quá 99.999.999,99.';
    }

    $validQuantity = filter_var($quantityValue, FILTER_VALIDATE_INT);
    if ($validQuantity === false || $validQuantity < 0) {
        $errors[] = 'Số lượng phải là số nguyên lớn hơn hoặc bằng 0.';
    }

    return $errors;
}
