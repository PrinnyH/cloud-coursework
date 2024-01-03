<!DOCTYPE html>
<?php
    session_start(); // Start the session
    $name = $_SESSION['firstname'];
    $bucket_id = $_SESSION['user_bucket_id'];
?>
<h1>Welcome <?php echo $name;?> + <?php echo $bucket_id;?></h1>
<div id="directoryListing">
</div>
