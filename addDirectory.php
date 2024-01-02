<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['dirName'];
    
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);
    

    echo 'true';
} else {
    echo 'false';
}

?>