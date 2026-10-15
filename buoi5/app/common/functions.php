<?php

function escapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function postString($key)
{
    return isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
}

function textLength($value)
{
    return preg_match_all('/./us', $value);
}

function validateProductInput($name, $price, $quantity)
{
    $errors = [];
    $name = trim($name);
    $priceValue = trim($price);
    $quantityValue = trim($quantity);
    $nameLength = textLength($name);

    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif ($nameLength > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    if (!preg_match('/^\d+(\.\d{1,2})?$/D', $priceValue) || (float) $priceValue <= 0 || (float) $priceValue > 99999999.99) {
        $errors[] = 'Giá phải lớn hơn 0, tối đa 99.999.999,99 và có tối đa 2 chữ số thập phân.';
    }

    $validQuantity = filter_var($quantityValue, FILTER_VALIDATE_INT);
    if ($validQuantity === false || $validQuantity < 0 || $validQuantity > 2147483647) {
        $errors[] = 'Số lượng phải là số nguyên từ 0 đến 2.147.483.647.';
    }

    return $errors;
}
