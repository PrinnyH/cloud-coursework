<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['dirName'];
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);
    
    // Specify the new folder path in the bucket
    $newFolderPath = $dirName . 'newfolder/'; // Change 'newfolder' to your desired folder name

    // Create a pseudo-folder by uploading an empty file
    $file = $bucket->upload('', 
    ['name' => $newFolderPath . '.dummy'] // This creates a dummy file in the new folder
    );

    echo 'true';
} else {
    echo 'false';
}

?>