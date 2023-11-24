<?php
// Specify the path to your bash script
$bashScriptPath = 'scripts/createBucket.sh';

// Use shell_exec to run the bash script
$output = shell_exec("bash $bashScriptPath");

// Display the output (if any)
echo $output;
?>
