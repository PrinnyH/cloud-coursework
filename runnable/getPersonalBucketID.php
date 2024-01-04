<?php
require_once("credentials.php");

require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Retrieve the value of the 'auth_token' cookie
$tokenCookie = $_COOKIE['auth_token'] ?? null;

// Check if the token cookie is set
if ($tokenCookie) {
    // Decode the token to get user information
    $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

    if ($decodedToken) {
        // Get the email from the decoded token
        $email = $decodedToken->email;

        // Attempt to connect to the database
        $mysqli = new mysqli($host, $username, $password, $database, $port);

        // Set the connection timeout
        $timeout = 10; // Timeout in seconds
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

        // Output any connection error
        if ($mysqli->connect_error) {
            error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            echo json_encode(["success" => false, "message" => "Database connection error"]);
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
                // Add the BucketID to the original token and return the updated token
                $updatedToken = JWT::encode(['email' => $email, 'username' => $decodedToken->username, 'bucket_id' => $bucketId], $secretKey, 'HS256');
                echo json_encode(["success" => true, "updatedToken" => $updatedToken]);
            } else {
                echo json_encode(["success" => false, "message" => "Email does not exist in the database"]);
            }

            // Close statement
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Error preparing statement: " . $mysqli->error]);
        }

        // Close the connection
        $mysqli->close();
    } else {
        echo json_encode(["success" => false, "message" => "Token is invalid or expired"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Token cookie is not set"]);
}
?>
