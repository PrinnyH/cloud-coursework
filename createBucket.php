<?php
require_once "vendor/autoload.php";

use Google\Cloud\Storage\StorageClient;

try {
    $storage = new StorageClient([
        'keyFilePath' => 'JSON_KEY_FILE_PATH',
    ]);

    $bucketName = '123123123123my-bucket';
    $bucket = $storage->bucket($bucketName);
    $response = $storage->createBucket($bucketName);
    echo "Your Bucket $bucketName is created successfully.";
} catch(Exception $e) {
    echo $e->getMessage();
}

