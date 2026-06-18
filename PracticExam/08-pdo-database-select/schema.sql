CREATE DATABASE IF NOT EXISTS webTest;
USE webTest;

CREATE TABLE IF NOT EXISTS practice_books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL UNIQUE,
  author VARCHAR(100) NOT NULL,
  price DECIMAL(8,2) NOT NULL
);

INSERT IGNORE INTO practice_books (title, author, price) VALUES
('PHP Basics', 'Connolly', 20.00),
('HTML Introduction', 'Hoar', 15.50),
('Database Systems', 'Smith', 31.25),
('Web Forms', 'Ahmad', 12.00);
