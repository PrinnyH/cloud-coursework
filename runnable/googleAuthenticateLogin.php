<?php
require_once '../vendor/autoload.php';
session_start();

try {
    $clientId = '23146911805-tuefejed4hddunmos49sph1jgvub608o.apps.googleusercontent.com';
    $client = new Google_Client(['client_id' => $clientId]);  // Specify your client ID
    
    // Validate and sanitize the input
    $id_token = filter_input(INPUT_POST, 'idtoken', FILTER_SANITIZE_STRING);

    if ($id_token) {
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
            $_SESSION['email'] = $payload['email'];
            $_SESSION['firstname'] = $payload['given_name'];
            echo "true";
        } else {
            echo "false"; // Token is invalid
        }
    } else {
        echo "false"; // No token provided
    }
} catch (Exception $e) {
    // Handle exception
    error_log($e->getMessage());
    echo "false";
}
?>


