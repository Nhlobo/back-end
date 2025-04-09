<?php
// notify.php - Handle PayFast notifications and confirm the order

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentData = $_POST;  // Receive payment data from PayFast

    // Log the payment notification for debugging
    $notification = file_get_contents('php://input');
    file_put_contents('payment_log.txt', $notification . "\n", FILE_APPEND);

    // Validate payment (you may need to verify the payment with PayFast's API)
    if (verifyPayment($paymentData)) {
        // Update order status in your system (example)
        updateOrderStatus($paymentData['m_payment_id'], 'paid');

        // Send email confirmation to customer
        $customer_email = $paymentData['email'];
        $customer_name = $paymentData['name'];
        $order_id = rand(1000, 9999);  // Example order ID
        $subject = "Order Confirmation";
        $message = "Dear $customer_name, \n\nYour order ID is $order_id. Your order has been successfully placed.";
        mail($customer_email, $subject, $message);

        // Send order details to the seller
        $seller_email = "seller@example.com";
        $subject_seller = "New Order to Fulfill";
        $message_seller = "New order from $customer_name. Order ID: $order_id.";
        mail($seller_email, $subject_seller, $message_seller);

        echo "OK";  // Send confirmation back to PayFast
    } else {
        file_put_contents('payment_log.txt', "Invalid payment notification\n", FILE_APPEND);
        http_response_code(400);
        echo "Invalid payment notification";
    }
}

function verifyPayment($data) {
    // Implement your payment verification logic here
    // Example: Validate signature with PayFast's verification endpoint
    return true; // Placeholder, replace with actual logic
}

function updateOrderStatus($paymentId, $status) {
    // Implement your order status update logic here (e.g., database update)
    file_put_contents('payment_log.txt', "Updated order $paymentId to $status\n", FILE_APPEND);
}
?>
