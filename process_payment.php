<?php
// Allow requests from your GitHub Pages frontend
header("Access-Control-Allow-Origin: https://nhlobo.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Use test PayFast credentials
$merchant_id = "10000100";  // Sandbox Merchant ID
$merchant_key = "46f0cd694581a";  // Sandbox Merchant Key

$amount = $data['amount'];
$return_url = $data['return_url'];
$cancel_url = $data['cancel_url'];
$notify_url = $data['notify_url'];

$payfast_url = "https://sandbox.payfast.co.za/eng/process";

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
