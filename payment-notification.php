<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");

$notification = file_get_contents('php://input');
file_put_contents('payment_log.txt', $notification . "\n", FILE_APPEND);

parse_str($notification, $data);

if (!isset($data['m_payment_id'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing payment ID."]);
  exit;
}

if (verifyPayment($data)) {
    updateOrderStatus($data['m_payment_id'], 'paid');
    echo "OK";
} else {
    file_put_contents('payment_log.txt', "Invalid payment notification\n", FILE_APPEND);
    http_response_code(400);
    echo "Invalid payment notification";
}

function verifyPayment($data) {
    return true;
}

function updateOrderStatus($paymentId, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $paymentId);
    $stmt->execute();
}
?>
