<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="js/login.js"></script>
    <title>Database Access</title>
</head>
<body>
    <h1>You are logged in!</h1>
    <button id="logout_button" onclick="logout()"> logout </button>

    <input id="file" name="file" type="file" />
    <button id="upload_file" onclick="uploadFile()"> read name </button>
    <form action="createBucket.php" method="post">
        <input type="submit" name="runScript" value="Run PHP Script">
    </form>
    <?php include("testConnection.php"); ?>
</body>
</html>
