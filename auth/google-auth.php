<?php

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

// Include Google Client Library
require_once 'vendor/autoload.php';

// Create a new Google_Client instance with your app's client ID
$client = new Google_Client(['client_id' => '23146911805-tuefejed4hddunmos49sph1jgvub608o']);

try {
    // Verify the ID token
    $payload = $client->verifyIdToken($id_token);

    // Check if the ID token is valid
    if (!$payload) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID token']);
        exit; // Stop further execution
    }

    // Extract user information from the payload
    $userid = $payload['sub'];
    $email = $payload['email'];
    $email_verified = $payload['email_verified'];

    // Check if the email is verified
    if (!$email_verified) {
        echo json_encode(['status' => 'error', 'message' => 'Email not verified']);
        exit; // Stop further execution
    }

    // Set session variables
    $_SESSION['user_id'] = $userid;
    $_SESSION['email'] = $email;

    // Respond to the client with success and user email
    echo json_encode(['status' => 'success', 'email' => $email]);
} catch (Exception $e) {
    // Handle exceptions and respond with an error message
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

