<?php

require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

function list_directories_in_bucket($projectId, $bucketName) {
    $storage = new StorageClient(['projectId' => $projectId]);
    $bucket = $storage->bucket($bucketName);
    
    $options = [
        'prefix'    => '',
        'delimiter' => '/'
    ];
    
    $directories = [];
    foreach ($bucket->objects($options) as $object) {
        if (substr($object->name(), -1) === '/') {
            $directories[] = $object->name();
        }
    }    
    return $directories;
}

$projectId = 'coursework-self-load-balance';
$bucketName = '123123123123my-bucket';

$directories = list_directories_in_bucket($projectId, $bucketName);

print_r($directories);
?>