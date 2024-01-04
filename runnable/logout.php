<?php

// Set cookies with expiration in the past to delete them
setcookie('username', '', time() - 3600, '/');
setcookie('email', '', time() - 3600, '/');
setcookie('bucket_id', '', time() - 3600, '/');

// Redirect to login page or home page
header("Location: ../index.html");
exit;
?>
