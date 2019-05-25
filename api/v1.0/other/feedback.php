<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $username = $_POST['username'];
    $message  = $_POST['message'];
    $userKey  = $_POST['AUTH_KEY'];
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
    
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    
    if ($screenshot != null) {
        $timeStamp  = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/feedback/' . $username . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/feedback/' . $username . '-' . $timeStamp, base64_decode($screenshot));
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