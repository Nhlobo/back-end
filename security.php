<?php
// Allow frontend from GitHub Pages to access backend
header("Access-Control-Allow-Origin: https://your-github-username.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

function sanitize_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

function validate_input($data, $type) {
  switch ($type) {
    case 'int':
      return filter_var($data, FILTER_VALIDATE_INT);
    case 'float':
      return filter_var($data, FILTER_VALIDATE_FLOAT);
    case 'email':
      return filter_var($data, FILTER_VALIDATE_EMAIL);
    case 'url':
      return filter_var($data, FILTER_VALIDATE_URL);
    default:
      return false;
  }
}

function generate_csrf_token() {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
  return hash_equals($_SESSION['csrf_token'], $token);
}

function rate_limit($key, $max_requests, $interval) {
  $redis = new Redis();
  $redis->connect('127.0.0.1', 6379);
  $current = $redis->incr($key);
  if ($current == 1) {
    $redis->expire($key, $interval);
  } elseif ($current > $max_requests) {
    http_response_code(429);
    echo json_encode(["error" => "Too Many Requests"]);
    exit;
  }
}

function hash_password($password) {
  return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($password, $hash) {
  return password_verify($password, $hash);
}
?>
