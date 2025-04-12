CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255),
  role ENUM('user', 'admin') DEFAULT 'user'
);

-- Create one admin
INSERT INTO users (username, email, password, role)
VALUES ('Admin', 'admin@example.com', SHA2('admin123', 256), 'admin');
