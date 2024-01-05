<!DOCTYPE html>
<?php
    require_once('vendor/autoload.php');
    require_once("runnable/credentials.php");
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    // Retrieve the values of the 'auth_token' cookie
    $tokenCookie = $_COOKIE['auth_token'] ?? null;

    // Check if the token cookie is set
    if ($tokenCookie) {
        // Decode the token to get user information
        $decodedToken = JWT::decode($tokenCookie, new key($secretKey, 'HS256'));

        if ($decodedToken) {
            // Get the name and bucketId from the decoded token
            $name = $decodedToken->username;
            $bucket_id = $decodedToken->bucket_id;
        }
    }
?>
<!-- Page welcome -->
<h1>Welcome <?php echo $name;?> (<?php echo $bucket_id;?>)</h1>
<div id="directoryListing">
    <!-- Directory contents dynamically loaded here -->
</div>
