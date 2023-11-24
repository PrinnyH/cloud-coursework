<?php

require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

// Replace these values with your own
$projectId = 'coursework-test-406000 ';
$bucketName = '123123123123my-bucket';

// Create a storage client
$storage = new StorageClient([
    'projectId' => $projectId,
]);

// Create a new bucket
$bucket = $storage->createBucket($bucketName);

echo 'Bucket ' . $bucket->name() . ' created.';

?>