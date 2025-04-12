<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$query->execute([$user_id]);
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>
