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
        $pathParts = explode('/', $object->name());

        // Reference to start of the array
        $currentLevel = &$allDirectories;

        foreach ($pathParts as $part) {
            // Build nested array structure
            if ($part != end($pathParts)) { // Ignore the actual file name
                if (!isset($currentLevel[$part])) {
                    $currentLevel[$part] = [];
                }
                $currentLevel = &$currentLevel[$part];
            }
        }
    }

    return $allDirectories;
}

function print_directories($directories, $level = 0) {
    foreach ($directories as $dir => $subDirs) {
        // Print the directory name with indentation
        echo str_repeat('    ', $level) . $dir . '/' . PHP_EOL;

        // If there are subdirectories, recursively print them
        if (!empty($subDirs)) {
            print_directories($subDirs, $level + 1);
        }
    }
}


$projectId = 'coursework-self-load-balance';
$bucketName = '123123123123my-bucket';

//$directories = list_directories_in_bucket($projectId, $bucketName);
$directories = list_all_directories($bucketName);

print_directories($directories);

//print_r($directories);
?>