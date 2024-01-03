<?php
require_once("credentials.php");
session_start();

// Initialize the mysqli object
$mysqli = new mysqli($host, $username, $password, $database);

// Set the connection timeout
$timeout = 10; // Timeout in seconds
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

// Output any connection error
if ($mysqli->connect_error) {
    error_log('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    echo "false";
    exit; // If there is a connection error, exit the script
}

$email = $_SESSION['email']; // Assuming $_SESSION['email'] is already set
error_log($email)
// Prepare the query
if ($stmt = $mysqli->prepare("SELECT BucketID FROM `User` WHERE Email = ?")) {
    
    // Bind parameters (s - string)
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();

    // Store the result to get properties like num_rows
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "true"; // Email exists in the database
    } else {
        echo "false"; // Email does not exist
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
