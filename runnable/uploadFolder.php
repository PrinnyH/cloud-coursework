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
    $files = $_FILES['uploadedFiles'];
    $filePaths = $_POST['filePaths']; // Relative paths

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

    $uploadSuccess = true;

    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] === UPLOAD_ERR_OK) {
            $filePath = $files['tmp_name'][$index]; // Temporary file path on the server
            $relativePath = $filePaths[$index]; // Use the relative path here

            // Construct the full file path for Google Cloud Storage
            $fullPath = $parentPath . $relativePath;

            // Read the file and upload it to Google Cloud Storage
            try {
                $bucket->upload(fopen($filePath, 'r'), [
                    'name' => $fullPath
                ]);
            } catch (Exception $e) {
                $uploadSuccess = false; // Set the flag to false if any upload fails
            }
        } else {
            $uploadSuccess = false; // Set the flag to false if any file has an error
        }
    }

    echo $uploadSuccess ? 'true' : 'false';
?>
