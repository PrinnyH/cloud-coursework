<?php
    require 'vendor/autoload.php';

    use Google\Cloud\Storage\StorageClient;

    session_start();

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


    // function print_directories_html($directories) {
    //     $html = "<ul class='list-dir'>";

    //     foreach ($directories as $dir => $subDirs) {
    //         $dirSafe = htmlspecialchars($dir); // Escape the directory name

    //         // Calculate the number of slashes in the path to determine indentation
    //         $slashCount = substr_count($dirSafe, '/');
    //         $indentation = $slashCount * 20; // 20px per slash for example

    //         // Split the path and get the last part for display
    //         $pathParts = explode('/', rtrim($dirSafe, '/'));
    //         $displayName = end($pathParts);

    //         // Flex container for each list item's content with border and background
    //         $html .= "<li class='list-dir-item'>";
    //         $html .= "<div class='list-dir-item-container' style='padding-left:{$indentation}px;'>"; // Light blue border and background

    //         // Display only the last part of the path
    //         $html .= "<span style='flex-grow: 1; white-space: nowrap;'>├─{$displayName}</span>";

    //         // Buttons (conditionally displayed)
    //         if (substr($dirSafe, -1) === '/') {
    //             $html .= "<span>
    //                 <button class='list-dir-item-button' onclick='handleAddDirectory(this)' data-dir='{$dirSafe}'>+🗀</button>
    //                 <button class='list-dir-item-button' onclick='handleDeleteDirectory(this)' data-dir='{$dirSafe}'>🗑</button>
    //                 <button class='list-dir-item-button' onclick='handleUploadFile(this)' data-dir='{$dirSafe}'>+🖹</button>
    //             </span>";
    //         } else {
    //             $html .= "<span>
    //                 <button class='list-dir-item-button' onclick='handleDeleteFile(this)' data-dir='{$dirSafe}'>🗑</button>
    //             </span>";
    //         }

    //         $html .= "</div>"; // Close flex container div

    //         // Subdirectories
    //         if (!empty($subDirs)) {
    //             $html .= print_directories_html($subDirs);
    //         }

    //         $html .= '</li>';
    //     }

    //     $html .= '</ul>';
    //     return $html;
    // }

    // $directories = list_all_directories();
    // echo print_directories_html($directories);
?>