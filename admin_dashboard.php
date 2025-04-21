<?php
// Allow frontend from GitHub Pages to access backend
header("Access-Control-Allow-Origin: https://nhlobo.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../frontend/login.html");
    exit();
}

// Load all user orders
$stmt = $conn->prepare("SELECT orders.*, users.fullname FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../frontend/style.css">
</head>
<body>
  <div class="container">
    <h2>Admin Dashboard</h2>
    <p>All Orders Overview:</p>
    <table>
      <tr>
        <th>#</th>
        <th>User</th>
        <th>Order ID</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
      <?php foreach ($orders as $index => $order): ?>
      <tr>
        <td><?= $index + 1 ?></td>
        <td><?= $order['fullname'] ?></td>
        <td><?= $order['id'] ?></td>
        <td><?= ucfirst($order['status']) ?></td>
        <td><?= $order['created_at'] ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <a href="../backend/logout.php" class="btn-logout">Logout</a>
  </div>
</body>
</html>
