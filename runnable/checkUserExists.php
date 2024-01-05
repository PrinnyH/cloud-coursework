<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    require_once("credentials.php");
    require_once('../vendor/autoload.php');
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    // Retrieve the value of the 'auth_token' cookie
    $tokenCookie = $_COOKIE['auth_token'] ?? null;

    // Check if the token cookie is set
    if (!$tokenCookie) {
        echo 'false'; // Token cookie is not set
    }
    
    // Decode the token to get user information
    $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

    if (!$decodedToken) {
        echo 'false'; // Token is invalid or expired
    }

    // Get the email from the decoded token
    $email = $decodedToken->email;

    // Initialize the mysqli object
    $mysqli = new mysqli($host, $username, $password, $database, $port);
    // Output any connection error
    if ($mysqli->connect_error) {
        error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        echo "false";
        exit; // If there is a connection error, exit the script
    }

    try {
        // Insert into User_Shared_Bucket
        $stmt = $mysqli->prepare("SELECT BucketID FROM `User` WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->num_rows > 0) {
            echo 'true'; // Email exists in the database
        } else {
            echo 'false'; // Email does not exist
        }

        error_log("Entry created successfully in BucketID");
        echo 'true';
    } catch (mysqli_sql_exception $exception) {
        error_log("Error occurred: " . $exception->getMessage());
        echo 'false';
    }

    // Close the connection
    $mysqli->close();

?>

