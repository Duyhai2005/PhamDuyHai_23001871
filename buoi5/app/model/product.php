<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts()
{
    $statement = getConnection()->query('SELECT id, name, price, quantity FROM products ORDER BY id');
    return $statement->fetchAll();
}

function getProductById($id)
{
    $statement = getConnection()->prepare('SELECT id, name, price, quantity FROM products WHERE id = :id');
    $statement->execute(['id' => $id]);
    return $statement->fetch();
}

function addProduct($name, $price, $quantity)
{
    $statement = getConnection()->prepare(
        'INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)'
    );

    return $statement->execute([
        'name' => trim($name),
        'price' => $price,
        'quantity' => $quantity
    ]);
}

function updateProduct($id, $name, $price, $quantity)
{
    $statement = getConnection()->prepare(
        'UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id'
    );

    return $statement->execute([
        'id' => $id,
        'name' => trim($name),
        'price' => $price,
        'quantity' => $quantity
    ]);
}

function deleteProduct($id)
{
    $statement = getConnection()->prepare('DELETE FROM products WHERE id = :id');
    $statement->execute(['id' => $id]);
    return $statement->rowCount() > 0;
}
