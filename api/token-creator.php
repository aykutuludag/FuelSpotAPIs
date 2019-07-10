<?php
require_once('php-jwt/JWT.php');
$t = time();
if ($deviceType == "android") {
    $token = array(
        "iss" => "https://fuelspot.com.tr",
        "aud" => "FSAndroid",
        "iat" => $t,
        'user_id' => $tempArray[0]['id']
    );
} else if ($deviceType == "ios") {
    $token = array(
        "iss" => "https://fuelspot.com.tr",
        "aud" => "FSiOS",
        "iat" => $t,
        'user_id' => $tempArray[0]['id']
    );
} else {
    if ($username == "guest") {
        $token = array(
            "iss" => "https://fuelspot.com.tr",
            "aud" => "FSWeb",
            "iat" => $t,
            "exp" => $t + 21600,
            'user_id' => $tempArray[0]['id']
        );
    } else {
        $token = array(
            "iss" => "https://fuelspot.com.tr",
            "aud" => "FSWeb",
            "iat" => $t,
            "exp" => $t + 604800,
            'user_id' => $tempArray[0]['id']
        );
    }
}
$secret_key = "Ph76g0MSZ2okeWQmShYDlXakjgjhbe";
$jwt        = JWT::encode($token, $secret_key);