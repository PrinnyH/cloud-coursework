<?php
    session_start();
    require 'vendor/autoload.php';

    use Google\Cloud\Storage\StorageClient;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $objectPath = $_POST['dirName'];

        // Initialize Google Cloud Storage client
        $storage = new StorageClient();
        $bucket = $storage->bucket($_SESSION['user_bucket_id']);

        // Delete the object
        try {
            $object = $bucket->object($objectPath);
            if ($object->exists()) {
                $object->delete();
                echo 'true'; // Object deleted successfully
            } else {
                echo 'false'; // Object not found
            }
        } catch (Exception $e) {
            echo 'false'; // An error occurred
        }
    } else {
        echo 'false'; // Not a POST request
    }
?>
