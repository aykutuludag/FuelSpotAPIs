<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Mandatory
    $username = $_POST['username'];
    $message  = $_POST['message'];
    $userKey  = $_POST['AUTH_KEY'];
    
    // Optional
    $screenshot = $_POST['screenshot'];
    
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
    if (strlen($username) == 0) {
        echo "username required";
        return;
    }
    
    if (strlen($message) == 0) {
        echo "message required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($screenshot != null) {
        $timeStamp  = time() . '.jpg';
        $actualpath = 'https://fuel-spot.com/uploads/feedback/' . $username . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuel-spot.com/uploads/feedback/' . $username . '-' . $timeStamp, base64_decode($screenshot));
        $sql = "INSERT INTO feedback(username,message,screenshot) VALUES('$username', '$message', '$actualpath')";
    } else {
        $sql = "INSERT INTO feedback(username,message) VALUES('$username', '$message')";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>