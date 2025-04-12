<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo json_encode(["error" => "Access denied: Admin privileges required."]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['order_id']) || !isset($data['status']) || !isset($data['csrf_token'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing required parameters."]);
  exit;
}

if (!verify_csrf_token($data['csrf_token'])) {
  http_response_code(403);
  echo json_encode(["error" => "CSRF token validation failed."]);
  exit;
}

$id = sanitize_input($data['order_id']);
$status = sanitize_input($data['status']);

try {
  $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
  $stmt->execute([$status, $id]);
  echo json_encode(["success" => true]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error"]);
}
?>
