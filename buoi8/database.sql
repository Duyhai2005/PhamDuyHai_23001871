CREATE DATABASE IF NOT EXISTS thuc_hanh_8
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE thuc_hanh_8;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL
);

INSERT INTO products (name, price, stock) VALUES
    ('Bút bi', 5000, 20),
    ('Vở ô ly', 12000, 15),
    ('Thước kẻ', 8000, 0);
