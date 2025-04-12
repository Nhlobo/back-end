<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Only cancel if order is still Pending
$stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND user_id = ? AND status = 'Pending'");
$stmt->execute([$order_id, $user_id]);

header('Location: user_dashboard.php');
exit();
