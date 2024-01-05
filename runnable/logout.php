<?php
    // Set cookies with expiration in the past to delete them
    setcookie('auth_token', '', time() - 3600, '/');

    // Redirect to login page or home page
    header("Location: ../index.html");
    exit;
?>
