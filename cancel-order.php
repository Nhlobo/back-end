<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
  http_response_code(403);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data['order_id'];
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND user_id = ? AND status = 'Pending'");
$stmt->execute([$order_id, $user_id]);

echo json_encode(["success" => true]);
?>
