<?php

// Set the Content-Type to text/plain
header('Content-Type: text/plain');

require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

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

function print_directories_html($directories, $level = 0) {
    $html = '';

    foreach ($directories as $dir => $subDirs) {
        // Print the directory name with indentation, using non-breaking spaces for indentation
        $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . htmlspecialchars($dir) . '/<br>';

        // If there are subdirectories, recursively print them
        if (!empty($subDirs)) {
            $html .= print_directories_html($subDirs, $level + 1);
        }
    }

    return $html;
}


$projectId = 'coursework-self-load-balance';
$bucketName = '123123123123my-bucket';

//$directories = list_directories_in_bucket($projectId, $bucketName);
$directories = list_all_directories($bucketName);

print_directories($directories);

//print_r($directories);
?>