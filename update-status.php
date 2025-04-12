<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['order_id'];
$status = $data['status'];

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

echo json_encode(["success" => true]);
?>
