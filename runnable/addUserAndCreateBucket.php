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
    $email = $_POST['email'];

    // Prepare the query
    if ($stmt = $mysqli->prepare("SELECT Email FROM 'User' WHERE Email = ?")) {
        
        // Bind parameters (s - string)
        $stmt->bind_param("s", $email);

        // Execute the query
        $stmt->execute();

        // Store the result to get properties like num_rows
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "true";
        } else {
            echo "false";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }

    // Close the connection
    $mysqli->close();

?>