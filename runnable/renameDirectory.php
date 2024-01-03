<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPath = $_POST['oldDir']; // Could be a file or directory path
    $newPath = $_POST['newDir']; // New file or directory path
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    // Check if the path is a directory
    $isDirectory = substr($oldPath, -1) === '/';
    $oldPath = $isDirectory ? formatPath($oldPath) : $oldPath;
    $newPath = $isDirectory ? formatPath($newPath) : $newPath;

    // Process based on whether it's a directory
    if ($isDirectory) {
        // Directory: move all objects in the directory
        $objects = $bucket->objects(['prefix' => $oldPath]);
        foreach ($objects as $object) {
            $newObjectName = $newPath . substr($object->name(), strlen($oldPath));
            moveObject($object, $bucket, $newObjectName);
        }
    } else {
        // Single file: move the file
        $object = $bucket->object($oldPath);
        if ($object->exists()) {
            moveObject($object, $bucket, $newPath);
        }
    }

    echo 'true';
} else {
    echo 'false';
}

function formatPath($path) {
    // Add a slash only if it's not already present and if the path is not empty
    return (substr($path, -1) !== '/' && !empty($path)) ? $path . '/' : $path;
}

function moveObject($object, $bucket, $newName) {
    try {
        $object->copy($bucket, ['name' => $newName]);
        $object->delete();
    } catch (Exception $e) {
        error_log("Error moving object: " . $e->getMessage());
        echo 'false';
        exit;
    }
}
?>