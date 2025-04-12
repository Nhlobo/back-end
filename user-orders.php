<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['user'])) {
  http_response_code(403);
  echo json_encode(["error" => "Access denied: User not logged in."]);
  exit;
}

rate_limit('user_orders_' . $_SESSION['user']['id'], 100, 60); // 100 requests per minute

$user_id = $_SESSION['user']['id'];

try {
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($orders);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
?>
