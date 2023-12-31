<!DOCTYPE html>
<html>
<head>
    <title>Page with Login Overlay</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <h2>Welcome to the Website</h2>
    <button id="loginButton">Login</button>

    <div id="loginOverlay" class="overlay" style="display: none;">
        <div class="login-popup">
            <h2>Login Form</h2>
            <div id="loginError" style="color: red; display: none;"></div> <!-- Error message placeholder -->

            <form id="loginForm">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <button type="submit">Login</button>
                <button type="button" id="closeButton">Close</button>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
    <?php phpinfo() ?>
</body>
<footer>
    
</footer>

</html>
