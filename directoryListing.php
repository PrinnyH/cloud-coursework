<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

function list_all_directories($bucketName) {
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);

    $allDirectories = [];
    foreach ($bucket->objects() as $object) {
        $objectName = $object->name();
        // Split the object name into path parts
        $pathParts = explode('/', $objectName);

        // Reference to start of the array
        $currentLevel = &$allDirectories;

        foreach ($pathParts as $index => $part) {
            // Skip empty parts
            if (empty($part)) {
                continue;
            }

            // Add '/' at the end of the directory name
            $part .= ($index < count($pathParts) - 1) ? '/' : '';

            // Initialize the directory or file in the array
            if (!isset($currentLevel[$part])) {
                $currentLevel[$part] = ($index < count($pathParts) - 1) ? [] : null;
            }

            // Move reference deeper into the array
            if ($index < count($pathParts) - 1) {
                $currentLevel = &$currentLevel[$part];
            }
        }
    }

    return $allDirectories;
}


function print_directories_html($directories, $level = 0) {
    $html = $level == 0 ? '<ul>' : '<ul style="list-style-type:none; padding-left:20px;">'; // Indent sub-lists

    foreach ($directories as $dir => $subDirs) {
        // Escape the directory name to prevent XSS attacks
        $dirSafe = htmlspecialchars($dir);

        $html .= "<li style='padding-top:10px;'>├─{$dirSafe}";
        // Add a button next to each directory
        //directory
        if (substr($dirSafe, -1) === '/'){
            $html .= "
            <button onclick='handleAddDirectory(this)' data-dir='{$dirSafe}'>+🗀</button>
            <button onclick='handleDeleteDirectory(this)' data-dir='{$dirSafe}'>🗑</button>
            <button onclick='handleUploadFile(this)' data-dir='{$dirSafe}'>+🖹</button>";
        }
        else        {
            $html .= "
            <button onclick='handleDeleteFile(this)' data-dir='{$dirSafe}'>🗑</button>";
        }
            

        if (!empty($subDirs)) {
            // Recursively build the HTML for subdirectories
            $html .= print_directories_html($subDirs, $level + 1);
        }

        $html .= '</li>';
    }

    $html .= '</ul>';
    return $html;
}
?>