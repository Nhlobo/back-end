<?php
include 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$fullname = htmlspecialchars($data['name']);
$email = htmlspecialchars($data['email']);
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["error" => "Email already registered."]);
} else {
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $password);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
}
?>
