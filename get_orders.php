<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$stmt = $conn->prepare("SELECT orders.*, GROUP_CONCAT(order_items.product_name) as items, SUM(order_items.price * order_items.quantity) as total FROM orders JOIN order_items ON orders.id = order_items.order_id GROUP BY orders.id");
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode($orders);
?>
