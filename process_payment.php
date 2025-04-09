<?php
// process_payment.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$merchant_id = getenv('MERCHANT_ID');
$merchant_key = getenv('MERCHANT_KEY');
$amount = $data['amount'];
$return_url = $data['return_url'];
$cancel_url = $data['cancel_url'];
$notify_url = $data['notify_url'];

$payfast_url = "https://www.payfast.co.za/eng/process";

$paymentData = [
    'merchant_id' => $merchant_id,
    'merchant_key' => $merchant_key,
    'amount' => number_format($amount, 2, '.', ''),
    'item_name' => 'Full Chicken',
    'return_url' => $return_url,
    'cancel_url' => $cancel_url,
    'notify_url' => $notify_url,
];

$query_string = http_build_query($paymentData);
$redirect_url = "$payfast_url?$query_string";

echo json_encode(['redirect_url' => $redirect_url]);
?>
