<?php
// formspree_config.php

function sendOrderConfirmation($email, $order_details) {
    $url = 'https://formspree.io/f/xwpkkvnk';
    $data = [
        'name' => 'Customer Name',  // Name of the customer
        'email' => $email,
        'order_details' => $order_details
    ];

    // Set up cURL to send form data to Formspree
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
?>
