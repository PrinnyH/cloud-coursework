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
    <!-- Navbar -->
        <div class="w3-top">
        <div class="w3-bar w3-black w3-card">
            <h3 class="w3-padding-large w3-bar-item w3-wide"><b>VAULTS</b></h3>
            <a href="#logout" class="logout-button w3-bar-item w3-button w3-padding-large w3-text-red w3-right">Logout</a>
        </div>
    </div>
    
    <!-- Sidebar/nav bar -->
    <nav id ="sideNavExpanded" class="w3-sidebar w3-bar-block w3-light-grey w3-collapse w3-top" style="z-index:3;width:250px">
        <div class="w3-container w3-display-container w3-padding-16">
            <i class="hide-nav-button fa fas fa-angle-double-left w3-display-topright w3-button w3-xxlarge w3-transparent"></i>
        </div>
        <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
            <a href="#" class="w3-bar-item w3-button">My Files</a>
            <a href="#" class="w3-bar-item w3-button">My Shared Files</a>
        </div>
        <!-- <div class="w3-padding-16 w3-medium">
            <a href="#contact" class="w3-bar-item w3-text-black w3-button w3-padding">Contact</a> 
        </div> -->
    </nav>
    
    <nav id ="sideNavMin" class="w3-sidebar w3-bar-block w3-light-grey w3-collapse w3-top" style="z-index:3;width:50px;display:none;">
        <div class="w3-container w3-display-container w3-padding-16">
            <i class="show-nav-button fa fas fa-angle-double-right w3-display-topright w3-button w3-xxlarge w3-transparent"></i>
        </div>
        <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
        </div>
    </nav>
    
    
    <!--Main Content  -->
    <div class="w3-main w3-content" style="max-width:1600px;margin-top:83px">
        <h1>Welcome [Add first name here]</h1>
         <div>
            <button id="Create_Test_Bucket" > Create Test Bucket </button>
            <div id ="output">
                <h5>...</h5>
            </div>
            <p>
            <button id="Read_Test_Bucket"> Read Test Bucket </button>
            <div id ="output2">
                <h5>...</h5>
            </div>
        </div>
    </div>
    

   
</body>
</html>
