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

    $stringToHash = $email . $name;
    // we use password hash here but we are just creating a unique name for the bucket we want to create
    $hashedString = sha1($stringToHash);

    $storage = new StorageClient();
    // Create a new bucket
    $bucket = $storage->createBucket($hashedString);
    
    
    $mysqli = new mysqli($host, $username, $password, $database, $port);
    // Output any connection error
    if ($mysqli->connect_error) {
        error_log('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        echo("false");
        exit;
    }

    $mysqli->begin_transaction();
    try {
        // Insert into User_Shared_Bucket
        $stmtInsert = $mysqli->prepare("INSERT INTO User (Email, BucketID) VALUES (?, ?)");
        $stmtInsert->bind_param("ss", $email, $hashedString);
        $stmtInsert->execute();
        $stmtInsert->close();

        $mysqli->commit();
        error_log("Entry created successfully in User_Shared_Bucket");
        echo 'true';
    } catch (mysqli_sql_exception $exception) {
        $mysqli->rollback();
        error_log("Error occurred: " . $exception->getMessage());
        echo 'false';
    }

    // Close the connection
    $mysqli->close();
?>
