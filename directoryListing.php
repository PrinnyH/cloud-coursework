<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

function list_all_directories() {
    $storage = new StorageClient();
    $bucket = $storage->bucket($_SESSION['user_bucket_id']);

    $allDirectories = [];
    foreach ($bucket->objects() as $object) {
        $objectName = $object->name();
        $pathParts = explode('/', $objectName);

        $fullPath = ''; // Initialize an empty string to build the full path

        foreach ($pathParts as $index => $part) {
            // Skip empty parts
            if (empty($part)) {
                continue;
            }

            // Append this part to the full path
            $fullPath .= $part;

            // Determine if the current part is a directory
            $isDirectory = $index < count($pathParts) - 1;

            // Add a slash only if it's a directory
            if ($isDirectory) {
                $fullPath .= '/';
            }

            // Add the current part to the array if it doesn't exist
            if (!isset($allDirectories[$fullPath])) {
                $allDirectories[$fullPath] = $isDirectory ? [] : null;
            }

            // Move reference deeper into the array for directories
            if ($isDirectory) {
                $currentLevel = &$allDirectories[$fullPath];
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