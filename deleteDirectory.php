<?php
    session_start();
    require 'vendor/autoload.php';

    use Google\Cloud\Storage\StorageClient;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $filePath = $_POST['dirName']; // Full path of the file

        // Initialize Google Cloud Storage client
        $storage = new StorageClient();
        $bucket = $storage->bucket($_SESSION['user_bucket_id']);

        try {
            // Get the parent directory path
            $pathParts = explode('/', rtrim($filePath, '/'));
            array_pop($pathParts); // Remove the file name
            $parentDir = implode('/', $pathParts) . '/';

            if ($parentDir === "/") $parentDir = "";    //check for root dir

            // List objects in the current directory
            $objects = $bucket->objects(['prefix' => $filePath]);
            foreach ($objects as $object) {
                if ($object->name() != $filePath) { // Skip the file itself
                    // Create new object path under parent directory
                    $newObjectName = $parentDir . basename($object->name());

                    // Copy the object to the new path
                    $bucket->object($object->name())->copy($bucket, ['name' => $newObjectName]);

                    // Delete the original object
                    $object->delete();
                }
            }

            // Now delete the specified file
            $fileObject = $bucket->object($filePath);
            if ($fileObject->exists()) {
                $fileObject->delete();
                echo 'true'; // File and subfolder contents moved and file deleted successfully
            } else {
                echo 'false'; // File not found
            }
        } catch (Exception $e) {
            echo 'false'; // An error occurred
        }
    } else {
        echo 'false'; // Not a POST request
    }
?>