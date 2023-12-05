<?php

require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

// Replace 'your-project-id' with your Google Cloud project ID
$projectId = 'coursework-self-load-balance';

// Replace 'your-bucket-name' with the desired bucket name
$bucketName = '123123123123my-bucket';

// Instantiate the StorageClient
$storage = new StorageClient([
    'projectId' => $projectId,
]);

// Get the bucket
$bucket = $storage->createBucket($bucketName);

// Print the created bucket information
printf('Bucket created: %s' . PHP_EOL, $bucket->name());

?>
