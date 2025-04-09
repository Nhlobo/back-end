<?php
// process_payment.php - Process the payment through PayFast

// At the beginning of your PHP backend file (process_payment.php), add:
header("Access-Control-Allow-Origin: https://nhlobo.github.io"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow Content-Type and Authorization headers
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, and OPTIONS requests

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $amount = 100.00;  // Example amount
    $merchant_id = "your_merchant_id";
    $merchant_key = "your_merchant_key";
    $payfast_url = "https://sandbox.payfast.co.za/eng/process";  // For testing, use sandbox

    // Prepare PayFast payment data
    $paymentData = [
        'merchant_id' => $merchant_id,
        'merchant_key' => $merchant_key,
        'amount' => number_format($amount, 2, '.', ''),
        'item_name' => 'Product Name',
        'return_url' => 'https://yourwebsite.com/success.php',
        'cancel_url' => 'https://yourwebsite.com/cancel.php',
        'notify_url' => 'https://yourwebsite.com/notify.php',
    ];

    // Redirect to PayFast payment page
    $query_string = http_build_query($paymentData);
    $redirect_url = "$payfast_url?$query_string";
    header("Location: $redirect_url");
    exit();
}
?>
