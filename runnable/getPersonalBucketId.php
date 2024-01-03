<?php
    require_once("credentials.php");
    session_start();

    // Set the connection timeout
    $timeout = 10; // Timeout in seconds
    $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

    // Attempt to connect to the database
    $mysqli = new mysqli($host, $username, $password, $database);

    //Output any connection error
    if ($mysqli->connect_error) {
        error_log('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
        echo("false");
        exit;
    }
    $email = $_SESSION['email'];

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
            exit;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }

    // Close the connection
    $mysqli->close();
?>