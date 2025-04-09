<?php
// Allow requests from your frontend domain (e.g., https://nhlobo.github.io)
header("Access-Control-Allow-Origin: https://nhlobo.github.io");
// Allow specific methods (GET, POST)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// Allow specific headers if needed (e.g., for authentication)
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle OPTIONS preflight request (for complex requests)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // No need to process further
}

// Get payment data from frontend
$data = json_decode(file_get_contents('php://input'), true);

// Example PayFast credentials (replace with actual)
$merchant_id = "10000100";
$merchant_key = "46f0cd694581a";
$amount = $data['amount'];
$item_name = "Product Name"; // Example product name
$shipping_method = $data['shippingMethod']; // Either "delivery" or "collection"
$return_url = "https://nhlobo.github.io/firt-try/return.html";
$cancel_url = "https://nhlobo.github.io/firt-try/cancel.html";
$notify_url = "https://back-end-2-kyrl.onrender.com/notify.php";

// PayFast payment URL
$payfast_url = "https://sandbox.payfast.co.za/eng/process";

// Payment data to send to PayFast
$paymentData = [
    'merchant_id' => $merchant_id,
    'merchant_key' => $merchant_key,
    'amount' => number_format($amount, 2, '.', ''),
    'item_name' => $item_name,
    'return_url' => $return_url,
    'cancel_url' => $cancel_url,
    'notify_url' => $notify_url
];

// Build the query string
$query_string = http_build_query($paymentData);

// Return PayFast URL for frontend to redirect to
echo json_encode([
    'payfast_redirect_url' => $payfast_url . '?' . $query_string
]);
exit();
?>
