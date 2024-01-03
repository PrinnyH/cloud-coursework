<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldDir = $_POST['oldDir']; // The old directory full path
    $newDir = $_POST['newDir']; // The new directory full path
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    
    // Copy the object to the new location
    $bucket->object($oldDir)->copy($bucket, $newDir);
    // delete old object
    $bucket->object($oldDir)->delete();
    

    echo 'true';
} else {
    echo 'false';
}
?>
