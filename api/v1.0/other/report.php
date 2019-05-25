<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $username = $_POST['username'];
    $station_id = $_POST['stationID'];
    $report = $_POST['report'];
    $details = $_POST['details'];
    $photo = $_POST['photo'];
    $prices = $_POST['prices'];
    $userKey = $_POST['AUTH_KEY'];

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

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    if (strlen($photo) > 0) {
        $timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/reports/' . $username . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/reports/' . $username . '-' . $timeStamp, base64_decode($photo));
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