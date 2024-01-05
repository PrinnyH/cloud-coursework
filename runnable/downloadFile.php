<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('../vendor/autoload.php');
    require_once("credentials.php");
    use Google\Cloud\Storage\StorageClient;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $fileDir = $_GET['fileDir']; // Full path of the directory from GET request

        // Initialize Google Cloud Storage client
        $storage = new StorageClient();
        $tokenCookie = $_COOKIE['auth_token'] ?? null;

        if ($tokenCookie) {
            // Decode the token to get user information
            $decodedToken = JWT::decode($tokenCookie, new Key($secretKey, 'HS256'));

            if (isset($decodedToken->bucket_id)) {
                $bucket_id = $decodedToken->bucket_id;
                $bucket = $storage->bucket($bucket_id);

                // Get the file object
                $object = $bucket->object($fileDir);
                if ($object->exists()) {
                    // Download and serve the file
                    $fileContent = $object->downloadAsString();

                    header('Content-Type: ' . mime_content_type($fileDir));
                    header('Content-Disposition: attachment; filename="' . basename($fileDir) . '"');
                    header('Content-Length: ' . strlen($fileContent));
                    echo $fileContent;  // Output the file content
                    exit;
                } else {
                    error_log('File not found');
                    echo 'File not found';
                    exit;
                }
            } else {
                error_log('Token decoding failed');
                echo 'Token decoding failed';
                exit;
            }
        } else {
            echo 'No token found';
            exit;
        }
    } else {
        echo 'Invalid request method';
        exit;
    }
?>