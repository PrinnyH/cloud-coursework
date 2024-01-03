<?php

// Set the connection timeout
$timeout = 10; // Timeout in seconds
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

// Attempt to connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

echo "Connected successfully to the database.";

// Close the connection
$mysqli->close();

?>