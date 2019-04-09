<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $location = $_POST['location'];
    $radius = $_POST['radius'];
    $userKey = $_POST['AUTH_KEY'];
    $outPutArray = [];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($location) == 0) {
        echo "location required";
        return;
    }

    if (strlen($radius) == 0) {
        echo "radius required";
        return;
    }

    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user_lat = explode(";", $location)[0];
    $user_lon = explode(";", $location)[1];

    $sql = "SELECT *, ( 6371000 * acos( cos( radians('" . $user_lat . "') ) * cos( radians( SUBSTRING_INDEX(location, ';', 1) ) ) * cos( radians( SUBSTRING_INDEX(location, ';', -1) ) - radians('" . $user_lon . "') ) + sin( radians('" . $user_lat . "') ) * sin( radians( SUBSTRING_INDEX(location, ';', 1) ) ) ) ) AS distance FROM stations WHERE isActive='1' HAVING distance < '" . $radius . "' ORDER BY distance LIMIT 0, 33";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}