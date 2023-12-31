<?php
// Hardcoded credentials for demonstration
$valid_username = "admin";
$valid_password = "password";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $valid_username && $password === $valid_password) {
        echo 'true'; // Indicate success
    } else {
        echo 'false'; // Indicate failure
    }
}
?>
