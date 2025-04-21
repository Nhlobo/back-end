<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$email = htmlspecialchars($data['email']);

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user) {
    $token = bin2hex(random_bytes(16));
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $reset_link = "https://nhlobo.github.io/reset-password.html?token=$token";
    echo json_encode(["success" => true, "message" => "Reset link sent! Please check your email.", "link" => $reset_link]);
} else {
    echo json_encode(["success" => false, "message" => "No account associated with this email."]);
}
?>
