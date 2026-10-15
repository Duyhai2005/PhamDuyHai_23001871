CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
    ('Bàn phím cơ', 850000.00, 10),
    ('Chuột không dây', 320000.00, 25),
    ('Tai nghe', 1250000.00, 8),
    ('Màn hình máy tính', 4200000.00, 5),
    ('Cáp USB-C', 150000.00, 30);

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tài khoản mẫu: admin / admin123.
-- Hash được tạo bằng password_hash('admin123', PASSWORD_DEFAULT) trong PHP.
INSERT INTO users (username, password) VALUES
    ('admin', '$2y$12$/Tok9gD9xQyZWZ9GGqshPOVw/CtdpsGE6jZFX4wxlhuPEdAntdidS');
