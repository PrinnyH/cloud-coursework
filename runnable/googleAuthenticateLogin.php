<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once("credentials.php");
require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;

try {
    $clientId = '23146911805-tuefejed4hddunmos49sph1jgvub608o.apps.googleusercontent.com';
    $client = new Google_Client(['client_id' => $clientId]);  // Specify your client ID
    
    // Validate and sanitize the input
    $id_token = $_POST['idtoken'];

    if ($id_token) {
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {

            $token = JWT::encode(['email' => $payload['email'], 'username' => $payload['given_name']], $secretKey, 'HS256');

            // Send the token to the client as part of the JSON response
            echo json_encode(['success' => true, 'token' => $token]);
        } else {
            error_log("payload is not verified");
            echo json_encode(['success' => false, 'message' => 'Token is invalid']);
        }
    } else {
        error_log("ID token is null");
        echo json_encode(['success' => false, 'message' => 'No token provided']);
    }
} catch (Exception $e) {
    // Handle exception
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}
?>
