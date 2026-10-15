<?php

function getConnection()
{
    static $connection = null;

    if ($connection !== null) {
        return $connection;
    }

    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_NAME') ?: 'shopping_cart';
    $username = getenv('DB_USER') === false ? 'root' : getenv('DB_USER');
    $password = getenv('DB_PASSWORD') === false ? '' : getenv('DB_PASSWORD');

    try {
        $connection = new PDO(
            "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $exception) {
        http_response_code(503);
        die('Không thể kết nối đến cơ sở dữ liệu. Hãy kiểm tra MySQL và cấu hình kết nối.');
    }

    return $connection;
}
