<?php
session_start(); // Start a new session or resume the existing one

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID token sent by the client
    $id_token = $_POST['token'];

    // Include Google Client Library
    require 'vendor/autoload.php';

    $client = new Google_Client(['client_id' => '23146911805-tuefejed4hddunmos49sph1jgvub608o']);  // Specify your app's client ID

    // Verify the ID token
    try {
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
            $userid = $payload['sub']; // User's unique Google ID
            $email = $payload['email']; // User's email address
            $email_verified = $payload['email_verified']; // Boolean: whether the email is verified

            // Check if the email is verified
            if ($email_verified) {
                // Set session variables
                $_SESSION['user_id'] = $userid;
                $_SESSION['email'] = $email;
                print_r($_SESSION);
                // Respond to the client
                echo json_encode(['status' => 'success', 'email' => $email]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Email not verified']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID token']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // Not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
