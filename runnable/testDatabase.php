<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

    // Replace these with your database credentials
    $host = "10.107.112.3";
    $port = "3306";             
    $username = "root";
    $password = "f}]^x\a>9Kk#D2xF"; 
    $database = "vaultzsSite";
    $port = 3306;              // Database port (default is 3306 for MySQL)

    // Attempt to connect to the database
    $mysqli = new mysqli($host, $username, $password, $database, $port);

    // Check the connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        echo "Connected successfully to the database.";
    }


    $allBucketIds = [];
    if ($stmt = $mysqli->prepare("SELECT Shared_BucketBucketID FROM User_Shared_Bucket WHERE UserEmail = ?")) {
        // Bind parameters and execute query
        $stmt->bind_param("s", "zionmaster100@gmail.com");
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the results into an array
        while ($row = $result->fetch_assoc()) {
            $allBucketIds[] = $row['Shared_BucketBucketID'];
        }
        echo $allBucketIds;

        $stmt->close();
    } else {
        error_log('Error preparing statement: ' . $mysqli->error);
        echo("false");
    }


    // Close the connection
    $mysqli->close();
?>
