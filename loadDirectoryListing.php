<?php
    require_once "vendor/autoload.php";

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

    function print_directories_html($directories) {
        $html = "<ul class='list-dir'>";
        
        //the top bar defined her to allow dropping onto
        $html .= "<li class='list-dir-item' draggable='true'ondragstart='' ondragover='dragOver(event)' ondrop='drop(event)'>";
        $html .= "<div class='list-dir-item-container' style='padding-left:0px; justify-content:right; border: 0px solid; background:lightgray;'>";
        $html .= "<span>";
        $html .= "<button class='list-dir-item-button' style='margin-bottom:0px;' onclick='handleAddDirectory(this)' data-dir=''>+🗀</button>";
        $html .= "<button class='list-dir-item-button' style='margin-bottom:0px;' onclick='handleUploadFile(this)' data-dir=''>+🖹</button>";
        $html .= "<input type='file' id='fileInput' style='display: none;' multiple> ";
        $html .= "<input type='file' id='folderInput' style='display: none;'webkitdirectory multiple>";
        $html .= "</span>";
        $html .= "</div>";
        $html .= "</li>";

        foreach ($directories as $dir => $subDirs) {
            $dirSafe = htmlspecialchars($dir); // Escape the directory name
    
            // Calculate the number of slashes in the path to determine indentation
            $slashCount = substr_count($dirSafe, '/');
            // Add extra indentation for files
            $isFile = substr($dirSafe, -1) !== '/';
            $indentation = ($slashCount + ($isFile ? 1 : 0)) * 30; // 20px per slash for example
    
            // Split the path and get the last part for display
            $pathParts = explode('/', rtrim($dirSafe, '/'));
            $displayName = end($pathParts);
            
            // Flex container for each list item's content with border and background
            $html .= "<li class='list-dir-item' draggable='true' ondragstart='dragStart(event)' ondragover='dragOver(event)' ondrop='drop(event)' style='padding-left:{$indentation}px;'>";
            $html .= "<div class='list-dir-item-container'>"; // Light blue border and background
    
            // Determine if it's a file and split the name and extension
            $isFile = substr($dirSafe, -1) !== '/';
            $fileName = $displayName;
            $fileExtension = '';

            if ($isFile) {
                $fileParts = pathinfo($displayName);
                $fileName = $fileParts['filename'];
                $fileExtension = isset($fileParts['extension']) ? '.' . $fileParts['extension'] : '';
            }

            // Make the directory/file name editable
            $html .= "<span style='flex-grow: 1; white-space: nowrap;'>";
            $html .= "<input type='text' class='editable-name' value='{$fileName}' ";
            $html .= "onchange='handleNameChange(this, \"{$dirSafe}\", \"{$fileExtension}\")' />"; // Event when the name is changed
            $html .= $fileExtension; // Display the extension (not editable)
            $html .= "</span>";

            // Buttons (conditionally displayed)
            if ($isFile) {
                $html .= "<span>
                    <button class='list-dir-item-button' onclick='handleDelete(this)' data-dir='{$dirSafe}'>🗑</button>
                </span>";
            } else {
                $html .= "<span>
                    <button class='list-dir-item-button' onclick='handleAddDirectory(this)' data-dir='{$dirSafe}'>+🗀</button>
                    <button class='list-dir-item-button' onclick='handleDelete(this)' data-dir='{$dirSafe}'>🗑</button>
                    <button class='list-dir-item-button' onclick='handleUploadFile(this)' data-dir='{$dirSafe}'>↑🖹</button>
                    <button class='list-dir-item-button' onclick='handleUploadFolder(this)' data-dir='{$dirSafe}'>↑🗀</button>
                </span>";
            }
    
            $html .= "</div>"; // Close flex container div
    
            // Subdirectories
            if (!empty($subDirs)) {
                $html .= print_directories_html($subDirs);
            }
    
            $html .= '</li>';
        }
    
        $html .= '</ul>';
        return $html;
    }
    
    $directories = list_all_directories();
    echo print_directories_html($directories);
?>