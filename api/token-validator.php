<?php
require_once('php-jwt/JWT.php');
require_once('php-jwt/BeforeValidException.php');
require_once('php-jwt/ExpiredException.php');
require_once('php-jwt/SignatureInvalidException.php');

$secret_key  = "Ph76g0MSZ2okeWQmShYDlXakjgjhbe";
$bearerToken = "";

$requestHeaders = apache_request_headers();
// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

if (isset($requestHeaders['Authorization'])) {
    $headers = trim($requestHeaders['Authorization']);
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            $bearerToken = $matches[1];
        }
    }
}

if (strlen($bearerToken) == 0) {
    echo "AuthError";
    exit;
}

try {
    $decoded = JWT::decode($bearerToken, $secret_key, array('HS256'));
} catch (\Exception $e) {
    echo "AuthError";
    exit();
}