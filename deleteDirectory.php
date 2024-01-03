<?php
session_start();
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = $_POST['dirName']; // Full path of the file or directory

    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    try {
        // Extract the parent directory path
        $pathParts = explode('/', rtrim($filePath, '/'));
        array_pop($pathParts); // Remove the file or directory name
        $parentDir = implode('/', $pathParts);
        $parentDir = empty($parentDir) ? "" : $parentDir . '/';

        // Get the object
        $object = $bucket->object($filePath);

        // Check if the object exists
        if ($object->exists()) {
            // Move the object to the parent directory, if it's not already there
            if ($filePath !== $parentDir) {
                $newObjectName = $parentDir . basename($filePath);
                $object->copy($bucket, ['name' => $newObjectName]);
                $object->delete();
            }
            echo 'true';
        } else {
            echo 'false'; // Object not found
        }
    } catch (Exception $e) {
        error_log("Error occurred: " . $e->getMessage()); // Log the error
        echo 'false'; // An error occurred
    }
} else {
    echo 'false'; // Not a POST request
}
?>
