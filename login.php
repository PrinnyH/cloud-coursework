<?php
session_start(); // Start a new session or resume the existing one
// Hardcoded credentials for test
$valid_username = "admin";
$valid_password = "password";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION['user_id'] = $username;


    if ($username === $valid_username && $password === $valid_password) {
        echo 'true'; // Indicate success
    } else {
        echo 'false'; // Indicate failure
    }
}
?>
