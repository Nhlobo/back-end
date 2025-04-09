<?php
// Allow requests from your frontend domain (replace this with your actual frontend URL)
header("Access-Control-Allow-Origin:  https://nhlobo.github.io/firt-try/"); 
// Allow methods like POST, GET, OPTIONS (adjust as needed)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// Allow specific headers that might be needed (e.g., Content-Type, Authorization, etc.)
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle OPTIONS request (preflight request for CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // No need to process further
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple validation
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Hash password for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the database (replace with your own credentials)
    $db = new PDO('mysql:host=localhost;dbname=your_database', 'root', '');

    // Insert into the database
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password]);

    // Send email verification (assuming simple email sending logic)
    $verification_link = "https://yourwebsite.com/verify.php?email=$email&token=" . md5($email);
    mail($email, "Verify Your Email", "Click this link to verify your email: $verification_link");

    echo "Registration successful! Please check your email to verify your account.";
}
?>
