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
        }
    }
?>

<!-- Heading displaying the name of the shared folders -->
<h1>Welcome <?php echo $name;?> - SHARED FOLDERS </h1>

<!-- Dropdown menu for selecting folders -->
<div class="dropdown">
    <button onclick="dropDownChange()" class="dropbtn">▼ Folder</button>
    <div id="sharedFolderSelector" class="dropdown-content">
      <!-- Shared fodlers list dynamically loaded here -->
    </div>
</div>

<!-- Buttons to add/remove a user to the shared folder -->
<button onclick="addUser()" class="dropbtn">+👤</button>
<button onclick="removeUser()" class="dropbtn">-👤</button>

<div id="directoryListing">
  <!-- Directory contents dynamically loaded here -->
</div>

<!-- Hidden element to store the selected bucket's ID -->
<div id="selectedBucket" selected-bucket=''></div>
