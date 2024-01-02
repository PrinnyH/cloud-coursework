<?php
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
    $html = $level == 0 ? '<ul>' : '<ul style="list-style-type:none; padding-left:20px;">'; // Indent sub-lists

    foreach ($directories as $dir => $subDirs) {
        // Escape the directory name to prevent XSS attacks
        $dirSafe = htmlspecialchars($dir);

        $html .= "<li>├─{$dirSafe}/";
        // Add a button next to each directory
        //directory
        if (str_ends_with($dirSafe, '/')){
            $html .= "
            <button onclick='handleDirectoryClick(this)' data-dir='{$dirSafe}'>+🗀</button>
            <button onclick='handleDirectoryClick(this)' data-dir='{$dirSafe}'>🗑</button>
            <button onclick='handleDirectoryClick(this)' data-dir='{$dirSafe}'>+🖹</button>";
        }
        else        {
            $html .= "
            <button onclick='handleDirectoryClick(this)' data-dir='{$dirSafe}'>🗑</button>";
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