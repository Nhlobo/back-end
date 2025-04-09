<?php
// process_payment.php - Process the payment through PayFast

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
