<?php
require_once('php-jwt/JWT.php');
$t = time();
if ($deviceType == "mobile") {
    $token = array(
        "iss" => "https://fuelspot.com.tr",
        "aud" => "webApp",
        "iat" => $t,
        'user_id' => $outPutArray[0]['id'],
    );
} else if ($deviceType == "desktop") {
    $token = array(
        "iss" => "https://fuelspot.com.tr",
        "aud" => "webApp",
        "iat" => $t,
        "exp" => $t + 604800,
        'user_id' => $outPutArray[0]['id'],
    );
}
$secret_key = "Ph76g0MSZ2okeWQmShYDlXakjgjhbe";
$jwt = JWT::encode($token, $secret_key);