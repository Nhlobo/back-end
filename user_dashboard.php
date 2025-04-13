<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../frontend/login.html");
    exit();
}

// Load user-specific data
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="../frontend/style.css">
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo $_SESSION['fullname']; ?>!</h2>
    <p>Your Recent Orders:</p>
    <table>
      <tr>
        <th>#</th>
        <th>Order ID</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
      <?php foreach ($orders as $index => $order): ?>
      <tr>
        <td><?= $index + 1 ?></td>
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
