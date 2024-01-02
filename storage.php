<!DOCTYPE html>
<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: index.html");
    exit();
}
$name = $_SESSION['user_id']

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/login.js"></script>
    <script src="js/script.js"></script>
    <script>
        function handleDirectoryClick(button) {
            var dirName = button.getAttribute('data-dir');
            console.log("Button clicked for directory: " + dirName);
        }
        function handleAddDirectory(this){}
        function handleDeleteDirectory(this){}
        function handleUploadFile(this){}
        function handleDeleteFile(this){}
    </script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <link rel="stylesheet" href="style.css"> 
    <title>Database Access</title>
</head>
<body style="height:100%">
    <!-- Navbar -->
        <div class="w3-top">
        <div class="w3-bar w3-black w3-card">
            <h3 class="w3-padding-large w3-bar-item w3-wide"><b>VAULTS</b></h3>
            <a href="logout.php" class="logout-button w3-bar-item w3-button w3-padding-large w3-text-red w3-right">Logout</a>
        </div>
    </div>
    <!--Main Content  -->
    <div class="w3-main w3-content" style="max-width:2000px; margin-top:83px; height:100%; display: flex; justify-content: space-between; align-items: top; width: 100%;">
        <!-- Sidebar/nav bar -->
        <nav class="sideNav w3-bar-block w3-light-grey w3-left" style="min-width:250px; position:flex; height:100%">
            <div id ="sideNavExpanded"> 
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
            </div>
            <div id="sideNavMin" style="display: none;"> 
                <div class="w3-container w3-display-container w3-padding-16">
                    <i class="show-nav-button fa fas fa-angle-double-right w3-display-topright w3-button w3-xxlarge w3-transparent"></i>
                </div>
            </div>
        </nav>

        <div class="w3-left" style="margin:20px; width: 100%; box-sizing: border-box;">
            <h1>Welcome <?php echo htmlspecialchars($name); ?></h1>
            <div>
                <button> Create Folder </button>
                <button> Upload File </button>
                <button> Expand All </button>

                <p> Per item in this list 
                <p> Per Folder Listed
                <button> Create Folder </button>
                <button> Delete Folder </button>
                <button> Upload To </button>

                <p> Per File Listed
                <button> Delete </button>
                
                <p> Drag/Drop all else

            </div>
            <div>
                <?php
                    session_start();
                    include 'directoryListing.php'; // Include the separate PHP file here

                    $projectId = 'coursework-self-load-balance';
                    $bucketName = $_SESSION['user_bucket_id'];

                    $directories = list_all_directories($bucketName);
                    echo print_directories_html($directories);
                ?>
            </div>
        </div>


    </div>
    

   
</body>
</html>
