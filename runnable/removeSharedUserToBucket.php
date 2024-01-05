<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    require_once('../vendor/autoload.php');
    require_once("credentials.php");

    $email = $_POST['given-email'];
    $bucketID = $_POST['given-bucketID'];

    error_log($email);
    error_log($bucketID);

    // Set the connection timeout
    $timeout = 10; // Timeout in seconds
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
        $stmtInsertUserSharedBucket = $mysqli->prepare("DELETE FROM User_Shared_Bucket WHERE UserEmail = ? AND Shared_BucketBucketID = ?");
        $stmtInsertUserSharedBucket->bind_param("ss", $email, $bucketID);
        $stmtInsertUserSharedBucket->execute();
        $stmtInsertUserSharedBucket->close();

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
