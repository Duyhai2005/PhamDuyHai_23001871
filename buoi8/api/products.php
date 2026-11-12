<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/dbConnect.php';

function sendResponse($success, $data = null, $message = null, $status = 200)
{
    http_response_code($status);

    $response = ['success' => $success];

    if ($data !== null) {
        $response['data'] = $data;
    }

    if ($message !== null) {
        $response['message'] = $message;
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

function getProductInput()
{
    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        sendResponse(false, null, 'Dữ liệu JSON không hợp lệ.', 400);
    }

    $name = isset($input['name']) && is_string($input['name'])
        ? trim($input['name']) : '';
    $price = $input['price'] ?? null;
    $stock = $input['stock'] ?? null;

    if (mb_strlen($name, 'UTF-8') < 1 || mb_strlen($name, 'UTF-8') > 100) {
        sendResponse(false, null, 'Tên sản phẩm phải có từ 1 đến 100 ký tự.', 400);
    }

    if (!is_int($price) || $price <= 0) {
        sendResponse(false, null, 'Đơn giá phải là số nguyên lớn hơn 0.', 400);
    }

    if (!is_int($stock) || $stock < 0) {
        sendResponse(false, null, 'Số lượng tồn phải là số nguyên không âm.', 400);
    }

    return [$name, $price, $stock];
}

try {
    $connection = getConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $statement = $connection->query('SELECT id, name, price, stock FROM products ORDER BY id');
        sendResponse(true, $statement->fetchAll());
    }

    if ($method === 'POST') {
        list($name, $price, $stock) = getProductInput();

        $statement = $connection->prepare(
            'INSERT INTO products (name, price, stock) VALUES (?, ?, ?)'
        );
        $statement->execute([$name, $price, $stock]);

        sendResponse(true, ['id' => (int) $connection->lastInsertId()], 'Thêm sản phẩm thành công.', 201);
    }

    if ($method === 'PUT' || $method === 'DELETE') {
        $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : false;

        if ($id === false || $id < 1) {
            sendResponse(false, null, 'Mã sản phẩm không hợp lệ.', 400);
        }

        $statement = $connection->prepare('SELECT id FROM products WHERE id = ?');
        $statement->execute([$id]);

        if (!$statement->fetch()) {
            sendResponse(false, null, 'Không tìm thấy sản phẩm.', 404);
        }

        if ($method === 'PUT') {
            list($name, $price, $stock) = getProductInput();

            $statement = $connection->prepare(
                'UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?'
            );
            $statement->execute([$name, $price, $stock, $id]);

            sendResponse(true, null, 'Cập nhật sản phẩm thành công.');
        }

        $statement = $connection->prepare('DELETE FROM products WHERE id = ?');
        $statement->execute([$id]);

        sendResponse(true, null, 'Xóa sản phẩm thành công.');
    }

    sendResponse(false, null, 'Phương thức không được hỗ trợ.', 405);
} catch (PDOException $exception) {
    sendResponse(false, null, 'Có lỗi xảy ra khi thao tác với cơ sở dữ liệu.', 500);
}
