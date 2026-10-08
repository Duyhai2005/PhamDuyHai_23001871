<?php

function getConnection()
{
    static $connection = null;

    if ($connection !== null) {
        return $connection;
    }

    $host = 'localhost';
    $database = 'shopping_cart';
    $username = 'root';
    $password = '';

    try {
        $connection = new PDO(
            "mysql:host=$host;dbname=$database;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $exception) {
        die('Không thể kết nối đến cơ sở dữ liệu. Hãy kiểm tra MySQL và cấu hình kết nối.');
    }

    return $connection;
}
