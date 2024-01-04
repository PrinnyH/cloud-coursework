<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('../vendor/autoload.php');
use Google\Cloud\Storage\StorageClient;

require_once("credentials.php");
session_start();
$email = $_SESSION['email'];
$name = $_SESSION['firstname'];

// Set the connection timeout
$timeout = 10; // Timeout in seconds
$mysqli = new mysqli($host, $username, $password, $database, $port);

// Output any connection error
if ($mysqli->connect_error) {
    error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    echo("false");
    exit;
}

$stringToHash = $email . $name;
// we use password hash here but we are just creating a unique name for the bucket we want to create
$hashedString = password_hash($stringToHash, PASSWORD_DEFAULT);

$storage = new StorageClient();
// Create a new bucket
$bucket = $storage->createBucket($hashedString);

// Insert data into the database
if ($stmtInsert = $mysqli->prepare("INSERT INTO User (Email, BucketID) VALUES (?, ?)")) {
    $stmtInsert->bind_param("ss", $email, $hashedString);
    $stmtInsert->execute();
    error_log("Bucket and Database entry created successfully");
    echo 'true';
    $stmtInsert->close();
} else {
    error_log("Error preparing insert statement: " . $mysqli->error);
    echo 'false';
}

// Close the connection
$mysqli->close();
?>
