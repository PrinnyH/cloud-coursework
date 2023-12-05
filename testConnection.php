<?php

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

$host = "34.135.89.198"; // Change this to your database host
$username = "root"; // Change this to your database username
$password = ",dO*cp%|jzSi5=#)"; // Change this to your database password
$database = "test_data"; // Change this to your database name

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