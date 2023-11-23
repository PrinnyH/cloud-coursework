<?php

// if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
//     echo 'We don\'t have mysqli!!!';
// } else {
//     echo 'Phew we have it!';
// }

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
