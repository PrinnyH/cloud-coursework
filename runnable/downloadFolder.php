<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('../vendor/autoload.php');
    require_once("credentials.php");

    use Google\Cloud\Storage\StorageClient;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo 'Invalid request method';
        exit;
    }
    $folderPath = $_GET['folderPath']; // Full path of the folder in the storage bucket

    // Initialize Google Cloud Storage client
    $storage = new StorageClient();
    $tokenCookie = $_COOKIE['auth_token'] ?? null;

    if (!$tokenCookie) {
        echo 'No token found';
        exit;
    }

    // Decode the token to get user information
    $decodedToken = JWT::decode($tokenCookie, new Key($secretKey, 'HS256'));

    if (!isset($decodedToken->bucket_id)) {
        error_log('Token decoding failed');
        echo 'Token decoding failed';
        exit;
    }
    $bucket_id = $decodedToken->bucket_id;
    $bucket = $storage->bucket($bucket_id);

    // List objects in the specified folder
    $objects = $bucket->objects(['prefix' => $folderPath]);

    // Create a new ZipArchive object
    $zip = new ZipArchive();
    // Set the name of the zip file
    $zipFileName = 'folder.zip'; // Set a static name for the zip file

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

    // Serve the Zip file for download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
    header('Content-Length: ' . filesize($zipFileName));
    readfile($zipFileName);

    // Cleanup
    unlink($zipFileName);
?>
