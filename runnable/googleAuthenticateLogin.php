<?php
    require_once '../vendor/autoload.php';
    session_start();
    
    $client = new Google_Client(['client_id' => $clientId]);  // Specify your client ID
    $id_token = $_POST['idtoken'];

    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
        $_SESSION['email'] = $payload['email'];
        $_SESSION['firstname'] = $payload['given_name'];
        echo "true";
    } else {
        echo "false";
    }
?>