<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$desc = $data['description'];
$price = $data['price'];
$stock = $data['stock'];
$image = $data['image_url'];

$sql = "INSERT INTO products (name, description, price, stock, image_url) 
        VALUES ('$name', '$desc', '$price', '$stock', '$image')";
mysqli_query($conn, $sql);
?>
