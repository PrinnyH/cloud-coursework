<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="js/login.js"></script>
    <title>Database Access</title>
</head>
<body>
    <h1>You are logged in!</h1>
    <button id="logout_button" onclick="logout()"> logout </button>

    <input id="file" name="file" type="file" />
    <button id="upload_file" onclick="uploadFile()"> read name </button>
    <?php include("testConnection.php"); ?>
</body>
</html>
