-- Produktový katalóg - Databázová schéma
-- Vytvorenie databázy (voliteľné)
CREATE DATABASE IF NOT EXISTS product_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE product_catalog;

-- Tabuľka produktov
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sku (sku),
    INDEX idx_is_active (is_active),
    INDEX idx_price (price)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vloženie ukážkových produktov
INSERT INTO products (name, sku, price, stock_quantity, is_active) VALUES
('Notebook Lenovo ThinkPad X1', 'LEN-X1-001', 1299.99, 15, 1),
('Bezdrôtová myš Logitech MX Master 3', 'LOG-MX3-002', 99.99, 0, 1),
('Mechanická klávesnica Keychron K2', 'KEY-K2-003', 89.50, 8, 1),
('Monitor Dell UltraSharp 27"', 'DEL-U27-004', 449.00, 5, 1),
('USB-C Hub 7v1', 'HUB-7IN1-005', 45.90, 0, 0);
