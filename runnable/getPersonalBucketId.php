<?php
require_once("credentials.php");
session_start();
$email = $_SESSION['email']; // Assuming $_SESSION['email'] is already set

// Attempt to connect to the database
$mysqli = new mysqli($host, $username, $password, $database, $port);

// Set the connection timeout
$timeout = 10; // Timeout in seconds
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

// Output any connection error
if ($mysqli->connect_error) {
    error_log('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    echo "false";
    exit; // If there is a connection error, exit the script
}

// Prepare the query
if ($stmt = $mysqli->prepare("SELECT BucketID FROM `User` WHERE Email = ?")) {
    
    // Bind parameters (s - string)
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($bucketId);

    // Fetch the value
    if ($stmt->fetch()) {
        $_SESSION['user_bucket_id'] = $bucketId;
        echo "true"; // Indicate success
    } else {
        echo "false"; // Email does not exist in the database
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
