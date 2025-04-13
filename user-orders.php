<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");

$user_id = $_GET['user_id'];
$sql = "SELECT o.*, p.name as product_name FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.user_id = $user_id ORDER BY o.id DESC";
$result = mysqli_query($conn, $sql);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
  $orders[] = $row;
}
echo json_encode($orders);
?>
