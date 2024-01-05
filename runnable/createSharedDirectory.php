<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    require_once('../vendor/autoload.php');
    require_once("credentials.php");
    use Google\Cloud\Storage\StorageClient;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    // Retrieve the values of the 'auth_token' cookie
    $tokenCookie = $_COOKIE['auth_token'] ?? null;

    // Check if the token cookie is set
    if ($tokenCookie) {
        // Decode the token to get user information
        $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

        if ($decodedToken) {
            // Get the email and name from the decoded token
            $email = $decodedToken->email;
            $name = $decodedToken->username;
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

    $stringToHash = $email . $name . $_POST['folderName'];
    // we use password hash here but we are just creating a unique name for the bucket we want to create
    $hashedString = sha1($stringToHash);

    $storage = new StorageClient();
    // Create a new bucket
    $bucket = $storage->createBucket($hashedString);

    $mysqli->begin_transaction();
    try {
        // Insert into Shared_Bucket
        $stmtInsertSharedBucket = $mysqli->prepare("INSERT INTO Shared_Bucket (BucketID, OwnerEmail) VALUES (?, ?)");
        $stmtInsertSharedBucket->bind_param("ss", $hashedString, $email);
        $stmtInsertSharedBucket->execute();
        $stmtInsertSharedBucket->close();

        // Insert into User_Shared_Bucket
        $stmtInsertUserSharedBucket = $mysqli->prepare("INSERT INTO User_Shared_Bucket (UserEmail, Shared_BucketBucketID) VALUES (?, ?)");
        $stmtInsertUserSharedBucket->bind_param("ss", $email, $hashedString);
        $stmtInsertUserSharedBucket->execute();
        $stmtInsertUserSharedBucket->close();

        // Commit transaction
        $mysqli->commit();
        error_log("Both Shared_Bucket and User_Shared_Bucket entries created successfully");
        echo 'true';
    } catch (mysqli_sql_exception $exception) {
        // Rollback transaction on error
        $mysqli->rollback();
        error_log("Error occurred: " . $exception->getMessage());
        echo 'false';
    }

    // Close the connection
    $mysqli->close();
?>