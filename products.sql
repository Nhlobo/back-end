-- Create the products table
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  image_url VARCHAR(255),
  stock INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample product data
INSERT INTO products (name, description, price, image_url, stock) VALUES
('Wireless Mouse', 'Smooth and silent ergonomic mouse', 199.99, 'images/mouse.jpg', 50),
('Gaming Keyboard', 'RGB backlit mechanical keyboard', 699.00, 'images/keyboard.jpg', 30),
('Noise Cancelling Headphones', 'Deep bass, Bluetooth 5.0', 1299.00, 'images/headphones.jpg', 20);
