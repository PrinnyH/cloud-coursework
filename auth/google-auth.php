<?php

// Include Google Client Library
require_once '../vendor/autoload.php';

// Display errors for debugging
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Start a new session or resume the existing one
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Respond with an error if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit; // Stop further execution
}

// Get the ID token sent by the client
$id_token = $_POST['token'];

// Create a new Google_Client instance with your app's client ID
$client = new Google_Client(['client_id' => '23146911805-tuefejed4hddunmos49sph1jgvub608o']);

$email = $payload['email'];
console.log($email);

?>

