<?php
// backend/save_order.php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$fullname = $data['customer']['fullname'];
$address = $data['customer']['address'];
$email = $data['customer']['email'];
$cart = $data['cart'];

// Save order
$stmt = $conn->prepare("INSERT INTO orders (fullname, address, email, order_date) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $fullname, $address, $email);
$stmt->execute();
$order_id = $stmt->insert_id;

// Save each cart item
$item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");

foreach ($cart as $item) {
  $item_stmt->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
  $item_stmt->execute();
}

echo "✅ Order placed successfully!";
?>
