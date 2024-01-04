<?php
require_once '../vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFiles'])) {
    $parentPath = $_POST['dirSelected']; // Full path of the directory
    $files = $_FILES['uploadedFiles']; // The uploaded files

    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $bucket_id = $_COOKIE['bucket_id'];
    $bucket = $storage->bucket(bucket_id);

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
} else {
    echo 'false'; // Not a POST request or files not set
}
?>
