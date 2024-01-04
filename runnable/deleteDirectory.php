<?php
require_once '../vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $path = $_POST['dirName']; // Full path of the file or directory

    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $bucket_id = $_COOKIE['bucket_id'];
    $bucket = $storage->bucket(bucket_id);

    try {
        // Check if the path is for a directory (ends with '/')
        $isDirectory = substr($path, -1) === '/';

        if ($isDirectory) {
            // Ensure the directory path ends with a slash
            $path = rtrim($path, '/') . '/';

            // List and delete all objects in the directory
            $objects = $bucket->objects(['prefix' => $path]);
            foreach ($objects as $object) {
                $object->delete();
            }
        } else {
            // It's a file, delete the single object
            $object = $bucket->object($path);
            if ($object->exists()) {
                $object->delete();
            }
        }

        echo 'true'; // Successfully deleted
    } catch (Exception $e) {
        error_log("Error occurred: " . $e->getMessage()); // Log the error
        echo 'false'; // An error occurred
    }
} else {
    echo 'false'; // Not a POST request
}
?>
