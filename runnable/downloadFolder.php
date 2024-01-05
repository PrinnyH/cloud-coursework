<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;

require_once("credentials.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folderPath = $_POST['folderPath']; // Full path of the directory
    
    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $tokenCookie = $_COOKIE['auth_token'] ?? null;
    // Check if the token cookie is set
    if ($tokenCookie) {
        // Decode the token to get user information
        $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

        if ($decodedToken) {
            $bucket_id = $decodedToken->bucket_id;
        }
    }
    $bucket = $storage->bucket($bucket_id);
    // List objects in the specified folder
    $objects = $bucket->objects(['prefix' => $folderPath]);

    // Prepare a Zip file
    $zip = new ZipArchive();
    $zipFileName = 'download.zip';
    if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
        exit("Cannot open <$zipFileName>\n");
    }

    // Add files to the Zip file
    foreach ($objects as $object) {
        if (substr($object->name(), -1) != '/') { // Exclude 'directories'
            $objectContent = $object->downloadAsString();
            $zip->addFromString(basename($object->name()), $objectContent);
        }
    }

    $zip->close();

    // Download the Zip file
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
    header('Content-Length: ' . filesize($zipFileName));
    readfile($zipFileName);

    // Cleanup
    unlink($zipFileName);
    echo 'true';
} else {
    echo 'false';
}
?>