<?php

require_once('../vendor/autoload.php');
use Google\Cloud\Storage\StorageClient;
require_once("credentials.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['dirName'];
    
    $storage = new StorageClient();
    // Retrieve the values of the 'auth_token' cookie
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
    $folderBaseName = 'newfolder'; // Base name for the folder
    $newFolderPath = $dirName . $folderBaseName . '/';
    $counter = 1;

    // Check if the folder (object) already exists and find a unique name
    while ($bucket->object($newFolderPath)->exists()) {
        $newFolderPath = $dirName . $folderBaseName . $counter . '/';
        $counter++;
    }

    $bucket->upload('', ['name' => $newFolderPath]);

    echo 'true';
} else {
    echo 'false';
}
?>
