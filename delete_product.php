<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=$id";
mysqli_query($conn, $sql);
?>
