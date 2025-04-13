<?php
include 'db.php';

$stmt = $conn->prepare("SELECT * FROM products WHERE stock > 0 ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($products);
?>
