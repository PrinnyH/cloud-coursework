<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="js/login.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Database Access</title>
</head>
<body>
    <!-- Sidebar/nav bar -->
    <nav class="w3-sidebar w3-bar-block w3-light-grey w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
        <div class="w3-container w3-display-container w3-padding-16">
            <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
            <h3 class="w3-wide"><b>LOGO</b></h3>
        </div>
        <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
            <a href="#" class="w3-bar-item w3-button">My Files</a>
            <a href="#" class="w3-bar-item w3-button">My Shared Files</a>
        </div>
        <a href="#footer" class="w3-bar-item w3-button w3-padding">Contact</a> 
        <a id="logout" href="#logout" class=" w3-text-red w3-bar-item w3-button w3-padding">Logout</a>
    </nav>


    <h1>Welcome [Add first name here]</h1>

    <!-- <div >
        <button id="Create_Test_Bucket" onclick="createTestBucket()"> Create Test Bucket </button>
        <div id ="output">
            <h5>...</h5>
        </div>
        <p>
        <button id="Read_Test_Bucket" onclick="readTestBucket()"> Read Test Bucket </button>
        <div id ="output2">
            <h5>...</h5>
        </div>
    </div> -->
</body>
</html>
