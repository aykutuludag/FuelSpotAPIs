<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $stationID = $_POST['stationID'];
    $campaignName = $_POST['campaignName'];
    $campaignDesc = $_POST['campaignDesc'];
    $campaignStart = $_POST['campaignStart'];
    $campaignEnd = $_POST['campaignEnd'];
    $userKey = $_POST['AUTH_KEY'];
    $campaignPhoto = $_POST['campaignPhoto'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }

    if (strlen($campaignName) == 0) {
        echo "campaignName required";
        return;
    }

    if (strlen($campaignDesc) == 0) {
        echo "campaignDesc required";
        return;
    }

    if (strlen($campaignStart) == 0) {
        echo "campaignStart required";
        return;
    }

    if (strlen($campaignEnd) == 0) {
        echo "campaignEnd required";
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

    if ($campaignPhoto != null) {
        $actualpath = 'https://fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $campaignName . '.jpg';
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $campaignName . '.jpg', base64_decode($campaignPhoto));
        $sql = "INSERT INTO campaigns(stationID,campaignName,campaignDesc,campaignPhoto,campaignStart,campaignEnd) VALUES('$stationID', '$campaignName', '$campaignDesc', '$actualpath', '$campaignStart', '$campaignEnd')";
    } else {
        $sql = "INSERT INTO campaigns(stationID,campaignName,campaignDesc,campaignStart,campaignEnd) VALUES('$stationID', '$campaignName', '$campaignDesc', '$campaignStart', '$campaignEnd')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
