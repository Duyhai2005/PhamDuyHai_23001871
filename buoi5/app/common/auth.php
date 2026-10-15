<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'use_strict_mode' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

function isLoggedIn()
{
    return isset($_SESSION['user_id'], $_SESSION['username']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
