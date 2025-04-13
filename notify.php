<?php
// Allow frontend from GitHub Pages to access backend
header("Access-Control-Allow-Origin: https://your-github-username.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

$notification = file_get_contents('php://input');
file_put_contents('payment_log.txt', $notification . "\n", FILE_APPEND);

parse_str($notification, $data);

// For now, just log the data and check the status
if (verifyPayment($data)) {
    // Update order status in your system (example)
    updateOrderStatus($data['m_payment_id'], 'paid');
    echo "OK";  // Send confirmation back to PayFast
} else {
    file_put_contents('payment_log.txt', "Invalid payment notification\n", FILE_APPEND);
    http_response_code(400);
    echo "Invalid payment notification";
}

function verifyPayment($data) {
    // Implement your payment verification logic here
    return true; // Placeholder, replace with actual logic
}

function updateOrderStatus($paymentId, $status) {
    // Implement your order status update logic here
}
?>
