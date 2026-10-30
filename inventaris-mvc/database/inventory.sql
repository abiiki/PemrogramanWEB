CREATE DATABASE IF NOT EXISTS db_inventory
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE db_inventory;

DROP TABLE IF EXISTS transactions, items, categories, users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin','staff','manager') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category_id INT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit VARCHAR(20) NOT NULL DEFAULT 'unit',
    price DECIMAL(15,2) NOT NULL DEFAULT 0,
    entry_date DATE NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category FOREIGN KEY (category_id)
    REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('IN','OUT') NOT NULL,
    quantity INT NOT NULL,
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_transactions_item FOREIGN KEY (item_id)
    REFERENCES items(id) ON DELETE CASCADE,
    CONSTRAINT fk_transactions_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (id, username, password, full_name, role) VALUES
(1, 'admin', '$2y$12$YB6mBPuC2evxJFb5hN4uTeei/YTdiwfIXWiTLx4r5iCyFf1./fsd2', 'Administrator', 'admin'),
(2, 'staff', '$2y$12$YB6mBPuC2evxJFb5hN4uTeei/YTdiwfIXWiTLx4r5iCyFf1./fsd2', 'Staf Inventaris', 'staff'),
(3, 'manager', '$2y$12$YB6mBPuC2evxJFb5hN4uTeei/YTdiwfIXWiTLx4r5iCyFf1./fsd2', 'Manajer', 'manager');

INSERT INTO categories (id, name, description) VALUES
(1, 'Elektronik', 'Perangkat elektronik dan komputer'),
(2, 'Furniture', 'Perlengkapan meja dan ruang kerja'),
(3, 'Alat Tulis', 'Alat tulis dan perlengkapan administrasi'),
(4, 'Jaringan', 'Perangkat jaringan dan komunikasi');

INSERT INTO items (id, code, name, category_id, quantity, unit, price, entry_date, description) VALUES
(1, 'ITM0001', 'Laptop', 1, 8, 'unit', 12500000, '2026-01-05', 'Laptop untuk kebutuhan operasional'),
(2, 'ITM0002', 'Monitor 24 inch', 1, 12, 'unit', 1850000, '2026-01-05', 'Monitor LED 24 inch'),
(3, 'ITM0003', 'Keyboard USB', 1, 3, 'unit', 175000, '2026-01-06', 'Keyboard kabel USB'),
(4, 'ITM0004', 'Mouse Wireless', 1, 4, 'unit', 125000, '2026-01-06', 'Mouse nirkabel'),
(5, 'ITM0005', 'Meja Kerja', 2, 6, 'unit', 950000, '2026-01-07', 'Meja kerja staf'),
(6, 'ITM0006', 'Kursi Kantor', 2, 2, 'unit', 1250000, '2026-01-07', 'Kursi kantor ergonomis'),
(7, 'ITM0007', 'Buku Tulis', 3, 25, 'pcs', 12000, '2026-01-08', 'Buku tulis A5'),
(8, 'ITM0008', 'Pulpen', 3, 40, 'pcs', 5000, '2026-01-08', 'Pulpen tinta hitam'),
(9, 'ITM0009', 'Router WiFi', 4, 3, 'unit', 725000, '2026-01-09', 'Router nirkabel dual-band'),
(10, 'ITM0010', 'Switch 8 Port', 4, 5, 'unit', 425000, '2026-01-09', 'Switch jaringan gigabit'),
(11, 'ITM0011', 'Printer', 1, 2, 'unit', 2350000, '2026-01-10', 'Printer laser kantor'),
(12, 'ITM0012', 'Kabel LAN 10m', 4, 15, 'pcs', 45000, '2026-01-10', 'Kabel jaringan kategori 6');

INSERT INTO transactions (item_id, user_id, type, quantity, notes, created_at) VALUES
(1, 1, 'IN', 10, 'Stok awal laptop', '2026-01-05 09:00:00'),
(2, 2, 'OUT', 2, 'Pemakaian ruang rapat', '2026-01-06 10:30:00'),
(3, 1, 'IN', 5, 'Pengadaan keyboard', '2026-01-07 13:15:00'),
(4, 3, 'OUT', 1, 'Penggantian perangkat', '2026-01-08 15:45:00');
