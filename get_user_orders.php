<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$user_id = $_GET['user_id'];
$sql = "SELECT o.*, GROUP_CONCAT(p.name) as items, SUM(oi.price * oi.quantity) as total FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = $user_id GROUP BY o.id";
$result = mysqli_query($conn, $sql);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
  $orders[] = $row;
}
echo json_encode($orders);
?>
