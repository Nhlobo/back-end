<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data["user_id"];
$cart = $data["cart"];
$date = date("Y-m-d");

$conn->begin_transaction();

try {
    foreach ($cart as $product_id => $qty) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, order_date, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iiis", $user_id, $product_id, $qty, $date);
        $stmt->execute();
    }
    $conn->commit();
    echo json_encode(["message" => "Order placed successfully"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Order placement failed"]);
}
?>
