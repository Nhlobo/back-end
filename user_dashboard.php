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

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <h3>Your Orders</h3>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Item</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Delivery Type</th>
            <th>Delivery Info</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['item_name'] ?></td>
            <td>R<?= $order['amount'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['delivery_type'] ?></td>
            <td><?= htmlspecialchars($order['delivery_info']) ?></td>
            <td>
                <?php if ($order['status'] == 'Pending'): ?>
                    <a href="cancel_order.php?id=<?= $order['id'] ?>">Cancel</a> |
                    <a href="edit_order.php?id=<?= $order['id'] ?>">Edit</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
