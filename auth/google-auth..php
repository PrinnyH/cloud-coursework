<?php

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
            $userid = $payload['sub'];
            // If request specified a G Suite domain:
            //$domain = $payload['hd'];

            // Perform user authentication and session management here
            // ...

            echo json_encode(['status' => 'success', 'userid' => $userid]);
        } else {
            // Invalid ID token
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID token']);
        }
    } catch (Exception $e) {
        // Handle error
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // Not a POST request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
