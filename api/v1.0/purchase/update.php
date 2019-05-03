<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $id = $_POST['purchaseID'];
    $username = $_POST['username'];
    $plateNO = $_POST['plateNO'];
    $billPhoto = $_POST['billPhoto'];
    $userKey = $_POST['AUTH_KEY'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($id) == 0 || $id == 0) {
        echo "purchaseID required";
        return;
    }

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

    if (strlen($plateNO) == 0) {
        echo "plateNO required";
        return;
    }

    if (strlen($billPhoto) == 0) {
        echo "billPhoto required";
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

    if (strlen($billPhoto) > 0) {
        $timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp, base64_decode($billPhoto));

        $sql = "UPDATE purchases SET billPhoto = '$actualpath' WHERE id= '" . $id . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}