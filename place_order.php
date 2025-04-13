<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data["user_id"];
$cart = $data["cart"];
$date = date("Y-m-d");

foreach ($cart as $product_id => $qty) {
    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, order_date, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("iiis", $user_id, $product_id, $qty, $date);
    $stmt->execute();
}

echo json_encode(["message" => "Order placed successfully"]);
?>
