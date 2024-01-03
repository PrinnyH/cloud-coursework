<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldDir = $_POST['oldDir']; // The old directory full path
    $newDir = $_POST['newDir']; // The new directory full path
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    // List all objects in the old directory
    $objects = $bucket->objects(['prefix' => $oldDir]);
    foreach ($objects as $object) {
        // Determine the new object name
        $newObjectName = $newDir . substr($object->name(), strlen($oldDir));

        // Copy the object to the new location
        $object->copy($bucket, ['name' => $newObjectName]);

        // Delete the original object
        $object->delete();
    }

    echo 'true';
} else {
    echo 'false';
}
?>

