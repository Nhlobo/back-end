<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['user'])) {
  http_response_code(403);
  echo json_encode(["error" => "Access denied: User not logged in."]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['order_id']) || !isset($data['csrf_token'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing required parameters."]);
  exit;
}

if (!verify_csrf_token($data['csrf_token'])) {
  http_response_code(403);
  echo json_encode(["error" => "CSRF token validation failed."]);
  exit;
}

$order_id = sanitize_input($data['order_id']);
$user_id = $_SESSION['user']['id'];

try {
  $stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND user_id = ? AND status = 'Pending'");
  $stmt->execute([$order_id, $user_id]);
  echo json_encode(["success" => true]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
?>
