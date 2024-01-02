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
    $html = $level == 0 ? '<ul style="padding: 0; margin: 0;">' : '<ul style="list-style-type:none; padding-left:20px;">';

    foreach ($directories as $dir => $subDirs) {
        $dirSafe = htmlspecialchars($dir); // Escape the directory name

        // Flex container for each list item's content
        $html .= "<li style='padding-top: 10px;'>";
        $html .= "<div style='display: flex; justify-content: space-between; align-items: center; width: 100%;'>";

        // Directory/file name
        $html .= "<span style='flex-grow: 1; white-space: nowrap;'>├─{$dirSafe}</span>";

        // Buttons (conditionally displayed)
        if (substr($dirSafe, -1) === '/') {
            $html .= "<span>
                <button onclick='handleAddDirectory(this)' data-dir='{$dirSafe}'>+🗀</button>
                <button onclick='handleDeleteDirectory(this)' data-dir='{$dirSafe}'>🗑</button>
                <button onclick='handleUploadFile(this)' data-dir='{$dirSafe}'>+🖹</button>
              </span>";
        } else {
            $html .= "<span>
                <button onclick='handleDeleteFile(this)' data-dir='{$dirSafe}'>🗑</button>
              </span>";
        }

        $html .= "</div>"; // Close flex container div

        // Subdirectories
        if (!empty($subDirs)) {
            $html .= print_directories_html($subDirs, $level + 1);
        }

        $html .= '</li>';
    }

    $html .= '</ul>';
    return $html;
}
?>