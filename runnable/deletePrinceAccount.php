<?php
require_once("credentials.php");

// Create a new MySQLi object
$conn = new mysqli($host, $username, $password, $database, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Primary key value to be deleted
$primaryKeyToDelete = "zionmaster100@gmail.com";


// Prepare the SELECT query
if ($stmt = $conn->prepare("SELECT * FROM User")) {
    // Execute the query
    $stmt->execute();

    // Store the result to get properties like num_rows
    $stmt->store_result();

    // Check if there are rows in the result set
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($email, $bucketID);

        // Fetch and echo the results
        while ($stmt->fetch()) {
            echo "Email: $email, BucketID: $bucketID<br>";
        }
    } else {
        echo "The User table is empty.";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing SELECT statement: " . $conn->error;
}


// Prepare the DELETE query
if ($stmt = $conn->prepare("DELETE FROM User WHERE Email = ?")) {
    // Bind parameters (s - string)
    $stmt->bind_param("s", $primaryKeyToDelete);

    // Execute the query
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Entry with primary key '$primaryKeyToDelete' deleted successfully";
    } else {
        echo "No entry found with primary key '$primaryKeyToDelete'";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing DELETE statement: " . $conn->error;
}

// Close the connection
$conn->close();
?>
