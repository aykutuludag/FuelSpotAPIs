<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Mandatory
    $username   = $_POST['username'];
    $station_id = $_POST['stationID'];
    $report     = $_POST['report'];
    $userKey    = $_POST['AUTH_KEY'];
    
    // Optional
    $details = $_POST['details'];
    $photo   = $_POST['photo'];
    $prices  = $_POST['prices'];
    
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
    if (strlen($username) == 0) {
        echo "username required";
        return;
    }
    
    if (strlen($station_id) == 0 || $station_id == 0) {
        echo "stationID required";
        return;
    }
    
    if (strlen($report) == 0) {
        echo "report required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if (strlen($photo) > 0) {
        $timeStamp  = time() . '.jpg';
        $actualpath = 'https://fuel-spot.com/uploads/reports/' . $username . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuel-spot.com/uploads/reports/' . $username . '-' . $timeStamp, base64_decode($photo));
    } else {
        $actualpath = '';
    }
    
    $sql = "INSERT INTO reports(username,stationID,report,details,photo,prices) VALUES('$username', '$station_id', '$report', '$details', '$actualpath', '$prices')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>