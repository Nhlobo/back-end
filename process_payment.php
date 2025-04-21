<?php
require 'security.php';

header("Access-Control-Allow-Origin: https://nhlobo.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['amount']) || !isset($data['return_url']) || !isset($data['cancel_url']) || !isset($data['notify_url']) || !isset($data['csrf_token'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing required parameters."]);
  exit;
}

if (!verify_csrf_token($data['csrf_token'])) {
  http_response_code(403);
  echo json_encode(["error" => "CSRF token validation failed."]);
  exit;
}

$amount = sanitize_input($data['amount']);
$return_url = sanitize_input($data['return_url']);
$cancel_url = sanitize_input($data['cancel_url']);
$notify_url = sanitize_input($data['notify_url']);

if (!validate_input($amount, 'float')) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Invalid amount."]);
  exit;
}

if (!validate_input($return_url, 'url') || !validate_input($cancel_url, 'url') || !validate_input($notify_url, 'url')) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Invalid URL."]);
  exit;
}

// Use your PayFast credentials
$merchant_id = "15465428";
$merchant_key = "Ocyrfu755y7bg";

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
