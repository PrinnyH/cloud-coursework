<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('../vendor/autoload.php');
    use Google\Cloud\Storage\StorageClient;
    require_once("credentials.php");
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    function list_all_shared_buckets() {
        $tokenCookie = $_COOKIE['auth_token'] ?? null;
        // Check if the token cookie is set
        if ($tokenCookie) {
            // Decode the token to get user information
            $decodedToken = JWT::decode($tokenCookie, new key('password123**1$$23', 'HS256'));
            
            if ($decodedToken) {
                $email = $decodedToken->email;
            }
        }
        // Set the connection timeout
        $timeout = 10; // Timeout in seconds
        $mysqli = new mysqli($host, $username, $password, $database, $port);

        // Output any connection error
        if ($mysqli->connect_error) {
            error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            echo("false");
            exit;
        }


        $allBucketIds = [];

        // Prepare the SQL statement
        if ($stmt = $mysqli->prepare("SELECT Shared_BucketBucketID FROM User_Shared_Bucket WHERE UserEmail = ?")) {
            // Bind parameters and execute query
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Fetch the results into an array
            while ($row = $result->fetch_assoc()) {
                $allBucketIds[] = $row['Shared_BucketBucketID'];
            }
    
            $stmt->close();
        } else {
            error_log('Error preparing statement: ' . $mysqli->error);
            echo("false");
        }
    
        // Close the database connection
        $mysqli->close();
    
        return $allBucketIds;
    } 

    function print_all_shared_directories_html($bucketIds) {
        $html = "<a href='#' onclick='createSharedDirectoryListing()'>Create</a>";
        foreach ($bucketIds as $bucketId) {
            $html .= "<a href='#' onclick='loadSharedDirectoryListing(this)' data-id='$bucketId'>$bucketId</a><br>";
        }
        return $html;
    }
    
    $bucketIds = list_all_shared_buckets();
    echo print_all_shared_directories_html($bucketIds);
?>