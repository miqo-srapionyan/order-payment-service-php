-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- Create `products` table
CREATE TABLE IF NOT EXISTS products (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        name VARCHAR(100),
                                        price FLOAT,
                                        stock INT
);

-- Create `orders` table
CREATE TABLE IF NOT EXISTS orders (
                                      id INT AUTO_INCREMENT PRIMARY KEY,
                                      user_id INT,
                                      items JSON,
                                      total_price FLOAT,
                                      status TINYINT
);

-- Insert default products if not exists
INSERT INTO products (name, price, stock)
SELECT * FROM (SELECT 'Product 1', 100.0, 10) AS tmp
WHERE NOT EXISTS (SELECT name FROM products WHERE name = 'Product 1') LIMIT 1;

INSERT INTO products (name, price, stock)
SELECT * FROM (SELECT 'Product 2', 50.0, 5) AS tmp
WHERE NOT EXISTS (SELECT name FROM products WHERE name = 'Product 2') LIMIT 1;
