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

function list_all_directories($bucketName) {
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    $allDirectories = [];
    foreach ($bucket->objects() as $object) {
        $objectName = $object->name();
        $pathParts = explode('/', $objectName);
        $path = '';

        foreach ($pathParts as $part) {
            if ($part != end($pathParts)) { // Ignore the actual file name
                $path .= $part . '/';
                $allDirectories[$path] = true; // Use array keys to avoid duplicates
            }
        }
    }

    return array_keys($allDirectories);
}

$projectId = 'coursework-self-load-balance';
$bucketName = '123123123123my-bucket';

//$directories = list_directories_in_bucket($projectId, $bucketName);
$directories = list_all_directories($projectId);

print_r($directories);
?>