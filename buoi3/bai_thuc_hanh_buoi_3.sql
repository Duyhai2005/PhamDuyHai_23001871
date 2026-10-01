CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS movies;

-- BAI 1: QUAN LY GIO HANG
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO cart_items (name, price, quantity) VALUES
    ('Ban phim co', 850000.00, 2),
    ('Chuot khong day', 320000.00, 3),
    ('Tai nghe', 1250000.00, 1),
    ('Lot chuot', 75000.00, 8),
    ('Cap USB-C', 150000.00, 6);

-- 1. Hien thi toan bo san pham.
SELECT * FROM cart_items;

-- 2. San pham co gia lon hon 100000.
SELECT * FROM cart_items WHERE price > 100000;

-- 3. San pham co so luong lon hon 5.
SELECT * FROM cart_items WHERE quantity > 5;

-- 4. Sap xep san pham theo gia giam dan.
SELECT * FROM cart_items ORDER BY price DESC;

-- 5. Cap nhat gia cua mot san pham.
UPDATE cart_items SET price = 900000.00 WHERE name = 'Ban phim co';
SELECT * FROM cart_items WHERE name = 'Ban phim co';

-- 6. Cap nhat so luong cua mot san pham.
UPDATE cart_items SET quantity = 4 WHERE name = 'Chuot khong day';
SELECT * FROM cart_items WHERE name = 'Chuot khong day';

-- 7. Xoa mot san pham.
DELETE FROM cart_items WHERE name = 'Cap USB-C';
SELECT * FROM cart_items;

-- 8. Thanh tien tung san pham.
SELECT name, price, quantity, price * quantity AS thanh_tien
FROM cart_items;

-- 9. Tong tien toan bo gio hang.
SELECT SUM(price * quantity) AS tong_tien_gio_hang
FROM cart_items;

-- BAI 2: QUAN LY VE XEM PHIM
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

INSERT INTO movies (title, price, total_seats, available_seats) VALUES
    ('Hanh tinh xanh', 90000.00, 120, 35),
    ('Thanh pho trong suong', 120000.00, 100, 20),
    ('Chuyen tau dem', 105000.00, 150, 80),
    ('Mua he bat tan', 85000.00, 90, 60),
    ('Dai duong bi an', 150000.00, 200, 40);

-- 1. Hien thi toan bo danh sach phim.
SELECT * FROM movies;

-- 2. Phim co gia ve lon hon 100000.
SELECT * FROM movies WHERE price > 100000;

-- 3. Phim con nhieu hon 50 ghe.
SELECT * FROM movies WHERE available_seats > 50;

-- 4. Sap xep phim theo gia ve giam dan.
SELECT * FROM movies ORDER BY price DESC;

-- 5. Cap nhat so ghe con lai cua mot phim.
UPDATE movies SET available_seats = 30 WHERE title = 'Chuyen tau dem';
SELECT * FROM movies WHERE title = 'Chuyen tau dem';

-- 6. Xoa mot phim.
DELETE FROM movies WHERE title = 'Mua he bat tan';
SELECT * FROM movies;

-- 7. So ve da ban cua tung phim.
SELECT title, total_seats - available_seats AS tickets_sold
FROM movies;

-- 8. Doanh thu tung phim.
SELECT title,
       (total_seats - available_seats) AS tickets_sold,
       price,
       (total_seats - available_seats) * price AS revenue
FROM movies;

-- 9. Tong doanh thu cua tat ca cac phim.
SELECT SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

-- 10. Phim co so ve ban ra nhieu nhat (tra ve tat ca phim neu dong hang).
SELECT title, total_seats - available_seats AS tickets_sold
FROM movies
WHERE total_seats - available_seats = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
