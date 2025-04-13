CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    image_url VARCHAR(255)
);

-- Sample products
INSERT INTO products (name, description, price, stock, image_url) VALUES
('Bluetooth Headphones', 'Wireless over-ear headphones with long battery life', 899.99, 30, 'https://example.com/headphones.jpg'),
('Smart Watch', 'Track your health and fitness stats', 1299.50, 20, 'https://example.com/smartwatch.jpg');
