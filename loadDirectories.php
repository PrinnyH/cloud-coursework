<?php
    session_start();
    include 'directoryListing.php'; 

    $directories = list_all_directories($bucketName);
    echo print_directories_html($directories);
?>