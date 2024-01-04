<!DOCTYPE html>
<?php
    $name = $_COOKIE['username'];
    $bucket_id = $_COOKIE['bucket_id'];
?>
<h1>Welcome <?php echo $name;?> + <?php echo $bucket_id;?></h1>
<div id="directoryListing">
</div>
