<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  http_response_code(403);
  echo json_encode(["error" => "Access denied: Admin privileges required."]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['action'])) {
  http_response_code(400);
  echo json_encode(["error" => "Bad Request: Missing action parameter."]);
  exit;
}

$action = sanitize_input($data['action']);

switch ($action) {
  case 'create_admin':
    if (isset($data['username']) && isset($data['email']) && isset($data['password'])) {
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
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$username, $email, $hashed_password]);
        echo json_encode(["success" => true, "message" => "Admin created successfully."]);
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
      }
    } else {
      http_response_code(400);
      echo json_encode(["error" => "Bad Request: Missing required parameters."]);
    }
    break;

  case 'delete_admin':
    if (isset($data['admin_id'])) {
      $admin_id = sanitize_input($data['admin_id']);

      try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'admin'");
        $stmt->execute([$admin_id]);
        echo json_encode(["success" => true, "message" => "Admin deleted successfully."]);
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
      }
    } else {
      http_response_code(400);
      echo json_encode(["error" => "Bad Request: Missing admin_id parameter."]);
    }
    break;

  default:
    http_response_code(400);
    echo json_encode(["error" => "Bad Request: Invalid action."]);
    break;
}
?>
