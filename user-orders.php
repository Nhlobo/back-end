<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
  http_response_code(403);
  exit;
}

$user_id = $_SESSION['user']['id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($orders);
?>
