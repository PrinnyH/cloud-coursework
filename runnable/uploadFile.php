<?php
    require_once('../vendor/autoload.php');
    require_once("credentials.php");
    use Google\Cloud\Storage\StorageClient;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['uploadedFiles'])) {
        echo 'false'; // Not a POST request or files not set
    }
    
    $parentPath = $_POST['dirSelected']; // Full path of the directory
    $files = $_FILES['uploadedFiles']; // The uploaded files

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

    // Iterate over each file
    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] === UPLOAD_ERR_OK) {
            $filePath = $files['tmp_name'][$index]; // Temporary file path on the server
            $fileName = $parentPath . basename($name); // Construct the full file path

            // Upload file to Google Cloud Storage
            $bucket->upload(fopen($filePath, 'r'), [
                'name' => $fileName
            ]);
        } else {
            echo 'false'; // File upload error
            exit; // Exit the script or handle the error appropriately
        }
    }

    echo 'true'; // All files uploaded successfully

?>
