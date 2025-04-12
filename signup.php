<?php
session_start();
require 'db.php';
require 'security.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing required parameters."]);
  exit;
}

$username = sanitize_input($data['username']);
$email = sanitize_input($data['email']);
$password = sanitize_input($data['password']);

if (!validate_input($email, 'email')) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Invalid email."]);
  exit;
}

$hashed_password = hash_password($password);

try {
  $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
  $stmt->execute([$username, $email, $hashed_password]);
  echo json_encode(["success" => true, "message" => "User registered successfully."]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
}
?>
