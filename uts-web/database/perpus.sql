CREATE DATABASE IF NOT EXISTS db_library
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE db_library;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL 
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT, code VARCHAR(10) NOT  NULL UNIQUE,
    title VARCHAR(150) NOT NULL, author VARCHAR(100) NOT NULL,
    published_year year NOT NULL, stock INT NOT NULL DEFAULT 0,
    deleted_at DATETIME NULL DEFAULT NULL
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, password, name) VALUES
('admin', '$2y$10$5UrEGG05QpNz8yDQ1TLohO4PROtJfQlb9JRdbs/ae2dO29lCkh5WK', 'Administrator');

INSERT INTO books (code, title, author, published_year, stock) VALUES
('B001', 'PHP Programming', 'Andi', 2024, 5),
('B002', 'Database System', 'Siti', 2023, 3);