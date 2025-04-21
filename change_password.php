<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = htmlspecialchars($data['email']);
$oldPassword = $data['oldPassword'];
$newPassword = password_hash($data['newPassword'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($oldPassword, $user['password'])) {
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $newPassword, $email);
    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password changed successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid old password"]);
}
?>
