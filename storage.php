<!DOCTYPE html>
<?php
    session_start(); // Start the session
    if (!isset($_SESSION['email'])) {
        // If the user is not logged in, redirect them to the login page
        header("Location: index.php");
        exit();
    }
    $name = $_SESSION['firstname'];
    $email =  $_SESSION['email'];
    $bucket_id = $_SESSION['user_bucket_id'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="js/pageController.js"></script>
    <script src="js/bucketController.js"></script>
    <script src="js/navController.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <link rel="stylesheet" href="style.css"> 
    <title>Files</title>
</head>
<body style="height:100%">
    <!-- Navbar -->
        <div class="w3-top">
        <div class="w3-bar w3-black w3-card">
            <h3 class="w3-padding-large w3-bar-item w3-wide"><b>VAULTS</b></h3>
            <a href="runnable/logout.php" class="logout-button w3-bar-item w3-button w3-padding-large w3-text-red w3-right">Logout</a>
        </div>
    </div>
    <!--Main Content  -->
    <div class="w3-main w3-content" style="max-width:2000px; margin-top:83px; height:100%; display: flex; justify-content: space-between; align-items: top; width: 100%;">
        <!-- Sidebar/nav bar -->
        <nav class="sideNav w3-bar-block w3-light-grey w3-left" style="width:250px; position:flex; height:100%">
            <div id ="sideNavExpanded"> 
                <div class="w3-container w3-display-container w3-padding-16">
                    <i class="hide-nav-button fa fas fa-angle-double-left w3-display-topright w3-button w3-xxlarge w3-transparent"></i>
                </div>
                <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
                    <a href="#MyFiles" class="w3-bar-item w3-button" id="navMyFiles">My Files</a>
                    <a href="#SharedFiles" class="w3-bar-item w3-button" id="navMySharedFiles">My Shared Files</a>
                </div>
                <!-- <div class="w3-padding-16 w3-medium">
                    <a href="#contact" class="w3-bar-item w3-text-black w3-button w3-padding">Contact</a> 
                </div> -->
            </div>
            <div id="sideNavMin" style="display: none;"> 
                <div class="w3-container w3-display-container w3-padding-16">
                    <i class="show-nav-button fa fas fa-angle-double-right w3-display-topright w3-button w3-xxlarge w3-transparent"></i>
                </div>
            </div>
        </nav>
        
        <div id="contentArea" class="w3-left" style="margin:20px; width: 100%; box-sizing: border-box;"> </div>
    </div>
    

   
</body>
</html>
