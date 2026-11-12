<?php

function getConnection()
{
    static $connection = null;

    if ($connection !== null) {
        return $connection;
    }

    $host = 'localhost';
    $database = 'thuc_hanh_8';
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
        http_response_code(503);
        die(json_encode([
            'success' => false,
            'message' => 'Không thể kết nối đến cơ sở dữ liệu.'
        ], JSON_UNESCAPED_UNICODE));
    }

    return $connection;
}
