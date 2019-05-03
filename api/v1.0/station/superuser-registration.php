<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $stationID = $_POST['stationID'];
    $licenseNo = $_POST['licenseNo'];
    $owner = $_POST['owner'];
    $userKey = $_POST['AUTH_KEY'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }

    if (strlen($licenseNo) == 0) {
        echo "licenseNo required";
        return;
    }

    if (strlen($owner) == 0) {
        echo "owner required";
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

    $sql = "UPDATE stations SET";

    if (strlen($licenseNo) > 0) {
        $var0 = " licenseNo='$licenseNo',";
        $sql = $sql . $var0;
    }

    if (strlen($owner) > 0) {
        $var1 = " owner='$owner',";
        $sql = $sql . $var1;
    }

    if ($sql == "UPDATE stations SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }

        $sql = $sql . " WHERE id= '" . $stationID . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}