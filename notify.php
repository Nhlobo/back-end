<?php
// notify.php

$notification = file_get_contents('php://input');
file_put_contents('payment_log.txt', $notification . "\n", FILE_APPEND);

parse_str($notification, $data);

if (verifyPayment($data)) {
    updateOrderStatus($data['m_payment_id'], 'paid');
    echo "OK";
} else {
    file_put_contents('payment_log.txt', "Invalid payment notification\n", FILE_APPEND);
    http_response_code(400);
    echo "Invalid payment notification";
}

function verifyPayment($data) {
    // In production, use signature and source IP validation
    return isset($data['payment_status']) && $data['payment_status'] === 'COMPLETE';
}

function updateOrderStatus($paymentId, $status) {
    $log = "Payment ID $paymentId marked as $status\n";
    file_put_contents('orders.txt', $log, FILE_APPEND);
}
