<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername($username)
{
    $statement = getConnection()->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $statement->execute(['username' => trim($username)]);
    return $statement->fetch();
}

function registerUser($username, $password)
{
    $statement = getConnection()->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    return $statement->execute([
        'username' => trim($username),
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
}
