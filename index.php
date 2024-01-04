<!DOCTYPE html>
<!-- <?php
session_start(); // check session started if not start
if (!isset($_SESSION['email'])) {
  // If the user is already logged in, got to storage page
  header("Location: storage.php");
  exit();
}
?> -->
<html>
  <head>
    <title>VAULTZ</title>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/pageController.js"></script>
    <script src="js/googleLogin.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <!-- USING THE W3 style sheeet to make look prettier -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-black w3-card" style="max-height:83px">
          <h2 class="w3-wide w3-center w3-padding-16">Vaults</h2>
        </div>
    </div>

    <!-- The content Section -->
    <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px; margin-top:83px">
        <p class="w3-opacity"><i>Store it Safe, Store it Secure</i></p>
        <div class="w3-padding-16">
            <div class="card-deck">
              <div class="card bg-dark">
                <div class="card-body text-center">
                <p style="color: #ffffff;" class="card-text">Dependable storage, lightning-fast file access</p>
                </div>
              </div>
              <div class="card bg-dark">
                <div class="card-body text-center">
                  <p style="color: #ffffff;" class="card-text">Your files, our priority.</p>
                </div>
              </div>
              <div class="card bg-dark">
                <div class="card-body text-center">
                  <p style="color: #ffffff;" class="card-text">Store, upload, and download your files effortlessly</p>
                </div>
              </div>
              <div class="card bg-dark">
                <div class="card-body text-center">
                  <p style="color: #ffffff;" class="card-text">Leverage enhanced security</p>
                </div>
              </div>  
            </div>
          </div>
        <div class="googleSignInButton w3-center" style="max-width: 250px;"> 
          <div id="g_id_onload"
                data-client_id="23146911805-tuefejed4hddunmos49sph1jgvub608o.apps.googleusercontent.com"
                data-context="signin"
                data-ux_mode="popup"
                data-callback="handleCredentialResponse"
                data-itp_support="true">
          </div>
          
          <div class="g_id_signin"
                data-type="standard"
                data-shape="pill"
                data-theme="outline"
                data-text="signin_with"
                data-size="large"
                data-locale="en-GB"
                data-logo_alignment="centre">
          </div>
        </div>
        
        
    </div>
</body>

<footer class="w3-container w3-bottom w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
    <p class="w3-medium"> Created by Prince and Valli </p>
</footer>

</html>
