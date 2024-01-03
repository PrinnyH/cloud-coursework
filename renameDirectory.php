<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

function formatPath($path) {
    // Ensure the path is correctly formatted
    return rtrim($path, '/') . '/';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldDir = formatPath($_POST['oldDir']);
    $newDir = formatPath($_POST['newDir']);
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    // List all objects in the old directory
    $objects = $bucket->objects(['prefix' => $oldDir]);
    foreach ($objects as $object) {
        // Determine the new object name
        $newObjectName = $newDir . substr($object->name(), strlen($oldDir));

        try {
            // Copy the object to the new location
            $object->copy($bucket, ['name' => $newObjectName]);

            // Delete the original object
            $object->delete();
        } catch (Exception $e) {
            // Handle exceptions (log them, notify, etc.)
            error_log("Error moving object: " . $e->getMessage());
            echo 'false';
            exit; // Exit the script or handle the error appropriately
        }
    }

    echo 'true';
} else {
    echo 'false';
}
?>
