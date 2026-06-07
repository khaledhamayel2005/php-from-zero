CREATE DATABASE IF NOT EXISTS web1231439_souvenirStore;
USE web1231439_souvenirStore;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_code VARCHAR(10) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    flat_no VARCHAR(30),
    street VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    postal_code VARCHAR(6) NOT NULL,
    password VARCHAR(32) NOT NULL,
    role VARCHAR(20) NOT NULL
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    rating INT NOT NULL,
    photo1 VARCHAR(100) NOT NULL,
    photo2 VARCHAR(100) NOT NULL,
    photo3 VARCHAR(100) NOT NULL,
    default_photo VARCHAR(100) NOT NULL
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(10) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL
);

CREATE TABLE order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    line_total DECIMAL(10,2) NOT NULL
);

INSERT INTO users
(user_id, user_code, first_name, last_name, email, mobile, date_of_birth, flat_no, street, city, country, postal_code, password, role)
VALUES
(1, '1234567890', 'Layla', 'Nasser', 'layla@qadyate.ps', '0599111111', '1999-03-12', '4A', 'Al-Bireh Street 15', 'Ramallah', 'Palestine', '111111', md5('Customer123'), 'Customer'),
(2, '2345678901', 'Omar', 'Hamad', 'omar@qadyate.ps', '0599222222', '1998-08-22', '7', 'Manger Street 21', 'Bethlehem', 'Palestine', '222222', md5('Customer123'), 'Customer'),
(3, '3456789012', 'Khaled', 'Hamayel', '1231439@student.birzeit.edu', '+970 569698697', '1995-01-17', '2', 'Abu Falah Village', 'Ramallah', 'Palestine', '123143', md5('Employee123'), 'Employee');

INSERT INTO products
(product_id, product_name, category, description, price, quantity, rating, photo1, photo2, photo3, default_photo)
VALUES
(1, 'Olive Branch Memory Carving', 'Olive Wood', 'A small olive wood carving inspired by family memory, patience, and rootedness.', 19.50, 30, 5, '1_1.jpeg', '1_2.jpeg', '1_3.jpeg', '1_1.jpeg'),
(2, 'Keffiyeh Pattern Mug', 'Keffiyeh', 'A ceramic mug decorated with a simple black and white keffiyeh pattern.', 12.00, 45, 4, '2_1.jpeg', '2_2.jpeg', '2_3.jpeg', '2_1.jpeg'),
(3, 'Jerusalem Gate Bookmark', 'Jerusalem', 'A metal bookmark inspired by old city gates and the long history of Jerusalem.', 7.25, 60, 5, '3_1.jpeg', '3_2.jpeg', '3_3.jpeg', '3_2.jpeg'),
(4, 'Gaza Shore Notebook', 'Gaza Memory', 'A notebook cover inspired by Gaza shore, sea air, and quiet evening memories.', 9.75, 50, 4, '4_1.jpeg', '4_2.jpeg', '4_3.jpeg', '4_1.jpeg'),
(5, 'Return Key Pendant', 'Gaza Memory', 'A simple pendant shaped like an old key, symbolizing home and return.', 14.40, 25, 5, '5_1.jpeg', '5_2.jpeg', '5_3.jpeg', '5_3.jpeg'),
(6, 'Olive Tree Tote Bag', 'Olive Wood', 'A cotton tote bag printed with an olive tree and warm earth colors.', 16.00, 35, 4, '6_1.jpeg', '6_2.jpeg', '6_3.jpeg', '6_2.jpeg'),
(7, 'Palestinian Embroidery Pin', 'Embroidery', 'A small pin inspired by traditional Palestinian embroidery shapes and colors.', 6.50, 80, 5, '7_1.jpeg', '7_2.jpeg', '7_3.jpeg', '7_1.jpeg'),
(8, 'Steadfast Home Ceramic Plate', 'Jerusalem', 'A decorative plate showing an old stone home and a peaceful courtyard.', 24.99, 18, 4, '8_1.jpeg', '8_2.jpeg', '8_3.jpeg', '8_2.jpeg'),
(9, 'Freedom Horizon Poster', 'Posters', 'A printed poster with a calm horizon, olive branches, and hopeful colors.', 11.75, 40, 4, '9_1.jpeg', '9_2.jpeg', '9_3.jpeg', '9_1.jpeg'),
(10, 'Handwoven Memory Scarf', 'Keffiyeh', 'A light scarf with patterns inspired by Palestinian memory and daily resilience.', 21.00, 22, 5, '10_1.jpeg', '10_2.jpeg', '10_3.jpeg', '10_3.jpeg');

ALTER TABLE users AUTO_INCREMENT = 4;
ALTER TABLE products AUTO_INCREMENT = 11;
