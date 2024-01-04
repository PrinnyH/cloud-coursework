<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once("credentials.php");

require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;

// Retrieve the value of the 'auth_token' cookie
$tokenCookie = $_COOKIE['auth_token'] ?? null;

// Check if the token cookie is set
if ($tokenCookie) {
    // Decode the token to get user information
    $decodedToken = JWT::decode($tokenCookie, $secretKey, array('HS256'));

    if ($decodedToken) {
        // Get the email from the decoded token
        $email = $decodedToken->email;

        // Initialize the mysqli object
        $mysqli = new mysqli($host, $username, $password, $database, $port);

        // Set the connection timeout
        $timeout = 10; // Timeout in seconds
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

        // Output any connection error
        if ($mysqli->connect_error) {
            error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            echo "false";
            exit; // If there is a connection error, exit the script
        }

        // Prepare the query
        if ($stmt = $mysqli->prepare("SELECT BucketID FROM `User` WHERE Email = ?")) {

            // Bind parameters (s - string)
            $stmt->bind_param("s", $email);

            // Execute the query
            $stmt->execute();

            // Store the result to get properties like num_rows
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo 'true'; // Email exists in the database
            } else {
                echo 'false'; // Email does not exist
            }

            // Close statement
            $stmt->close();
        } else {
            error_log("Error preparing statement: " . $mysqli->error);
            echo 'false';
        }

        // Close the connection
        $mysqli->close();
    } else {
        echo 'false'; // Token is invalid or expired
    }
} else {
    echo 'false'; // Token cookie is not set
}
?>

