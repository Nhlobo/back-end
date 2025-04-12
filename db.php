<?php
$dsn = "mysql:host=localhost;dbname=ecommerce;charset=utf8mb4";
$username = "root";
$password = "";

try {
  $conn = new PDO($dsn, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
  die("DB connection failed: " . $e->getMessage());
}
?>
