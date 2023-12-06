<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="js/login.js"></script>
    <title>Database Access</title>
</head>
<body>
    <h1>You are logged in!</h1>
    <div>
        <button id="logout_button" onclick="logout()"> logout </button>
    </div>
    <div >
        <input id="file" name="file" type="file" />
    </div>
    <div >
        <button id="Create Test Bucket" onclick="createTestBucket()"> read name </button>
    </div>
    <div id ="output">
        <h5>...</h5>
    </div>

    <?php include("testConnection.php"); ?>

</body>
</html>
