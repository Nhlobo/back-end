<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$name = htmlspecialchars($data['name']);
$desc = htmlspecialchars($data['description']);
$price = floatval($data['price']);
$stock = intval($data['stock']);
$image = htmlspecialchars($data['image_url']);

$sql = "INSERT INTO products (name, description, price, stock, image_url)
        VALUES ('$name', '$desc', '$price', '$stock', '$image')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Product added successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
}
?>
