<?php

use Exception;
use MongoDB\Client;
$uri = "mongodb+srv://vaultz-user:r7z82ChXYpPkwIoX@website.7x18c79.mongodb.net/?retryWrites=true&w=majority";
// Create a new client and connect to the server
$client = new MongoDB\Client($uri);
try {
    // Send a ping to confirm a successful connection
    $client->selectDatabase('admin')->command(['ping' => 1]);
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";
} catch (Exception $e) {
    printf($e->getMessage());
}

?>
