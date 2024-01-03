<?php
require_once 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['dirName'];
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);
    
    $folderBaseName = 'newfolder'; // Base name for the folder
    $newFolderPath = $dirName . $folderBaseName . '/';
    $counter = 1;

    // Check if the folder (object) already exists and find a unique name
    while ($bucket->object($newFolderPath)->exists()) {
        $newFolderPath = $dirName . $folderBaseName . $counter . '/';
        $counter++;
    }

    $bucket->upload('', ['name' => $newFolderPath]);

    echo 'true';
} else {
    echo 'false';
}
?>
