<?php
require_once('php-jwt/JWT.php');
$headers = apache_request_headers();
$bearerToken = $headers['token'];
$secret_key = "Ph76g0MSZ2okeWQmShYDlXakjgjhbe";

try {
    $decoded = JWT::decode($bearerToken, $secret_key, array('HS256'));
} catch (Exception $e) { // Also tried JwtException
    echo "AuthError";
    exit();
}