<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFiles'])) {
    $parentPath = $_POST['dirSelected'];
    $files = $_FILES['uploadedFiles'];
    $filePaths = $_POST['filePaths']; // Relative paths

    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] === UPLOAD_ERR_OK) {
            $filePath = $files['tmp_name'][$index];
            $relativePath = $filePaths[$index];

            // Construct the full file path including the directory structure
            $fullPath = $parentPath . $relativePath;

            // Upload file to Google Cloud Storage
            $bucket->upload(fopen($fullPath, 'r'), [
                'name' => $fileName
            ]);
        } else {
            echo 'false'; // File upload error
            exit; // Exit the script or handle the error appropriately
        }
    }

    echo 'true';
} else {
    echo 'false';
}
?>
