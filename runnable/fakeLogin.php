<?php
    require_once('vendor/autoload.php');
    require_once('runnable/credentials.php');
    use Firebase\JWT\JWT;
    $updatedToken JWT::encode(['email' => 'zionmaster100@gmail.com', 'username' => 'prince', 'bucket_id' => '87ca841e86dbc89dd26f72211ff40fb947ce0e12'], $secretKey, 'HS256');
    echo json_encode(["success" => true, "updatedToken" => $updatedToken]);
?>