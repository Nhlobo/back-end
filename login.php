<?php
session_start();
require 'db.php';
require 'security.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['email']) || !isset($data['password'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing required parameters."]);
  exit;
}

$email = sanitize_input($data['email']);
$password = sanitize_input($data['password']);

if (!validate_input($email, 'email')) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Invalid email."]);
  exit;
}

try {
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && verify_password($password, $user['password'])) {
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'email' => $user['email'],
      'role' => $user['role']
    ];
    echo json_encode(["success" => true, "message" => "Login successful."]);
  } else {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: Invalid email or password."]);
  }
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
}
?>
