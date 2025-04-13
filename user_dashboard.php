<?php
session_start();
$timeout = 900; // 15 minutes

if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.html");
    exit();
}

if (time() - $_SESSION['last_login_time'] > $timeout) {
    session_destroy();
    header("Location: ../frontend/login.html?timeout=true");
    exit();
} else {
    $_SESSION['last_login_time'] = time();
}
?>
