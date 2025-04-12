CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  full_name VARCHAR(255),
  item_name VARCHAR(255),
  order_type ENUM('Delivery', 'Collection'),
  status ENUM('Pending', 'Collected', 'Delivered', 'Cancelled') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
