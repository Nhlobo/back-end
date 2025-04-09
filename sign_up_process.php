<?php
// CORS Headers
header("Access-Control-Allow-Origin: https://nhlobo.github.io");  // Allow all domains or specify your front-end domain
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Process the sign-up (Example: handle form data and store in DB)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Process and save to database (this is just a mock example)
    // For security, never store passwords as plain text, always hash them before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Assume user was successfully saved
    $response = [
        'success' => true,
        'message' => 'User registered successfully!'
    ];

    echo json_encode($response);  // Return JSON response
    exit;
}
?>
