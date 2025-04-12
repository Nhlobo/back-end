<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo json_encode(["error" => "Access denied: Admin privileges required."]);
  exit;
}

rate_limit('admin_orders_' . $_SESSION['user']['id'], 100, 60); // 100 requests per minute

try {
  $stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
  $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($orders);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
?>
