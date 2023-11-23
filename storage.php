<?php
if ($_GET['run']) {
  # This code will run if ?run=true is set.
  exec("shell/echo.sh");
}
?>

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
    <button id="upload_file" href="?run=true"> echo me </button>

    <?php include("test_connection.php");?>
</body>
</html>
