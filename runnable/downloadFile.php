<?php
require_once('../vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;

require_once("credentials.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileDir = $_POST['fileDir']; // Full path of the directory
    
    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $tokenCookie = $_COOKIE['auth_token'] ?? null;
    // Check if the token cookie is set
    if ($tokenCookie) {
        // Decode the token to get user information
        $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

        if ($decodedToken) {
            $bucket_id = $decodedToken->bucket_id;
        }
    }
    $bucket = $storage->bucket($bucket_id);

    // Get the file object
    $object = $bucket->object($fileDir);
    if ($object->exists()) {
        // Download and serve the file
        $fileContent = $object->downloadAsString();

        header('Content-Type: ' . mime_content_type($fileDir));
        header('Content-Disposition: attachment; filename="' . basename($fileDir) . '"');
        header('Content-Length: ' . strlen($fileContent));
        echo 'true';
    } else {
        error_log('File not found');
        echo "false";
    }

} else {
    echo 'false';
}
?>