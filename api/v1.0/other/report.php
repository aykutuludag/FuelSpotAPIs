<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
    $station_id = $_POST['stationID'];
    $report = $_POST['report'];
    $details = $_POST['details'];
    $photo = $_POST['photo'];
    $prices = $_POST['prices'];

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }

    if (strlen($station_id) == 0 || $station_id == 0) {
        echo "stationID required";
        exit;
    }

    if (strlen($report) == 0) {
        echo "report required";
        exit;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $details = mysqli_real_escape_string($conn, $details);

    if (strlen($photo) > 0) {
        $timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/reports/' . $username . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/reports/' . $username . '-' . $timeStamp, base64_decode($photo));
    } else {
        $actualpath = '';
    }

    $sql = "INSERT INTO reports(username,stationID,report,details,photo) VALUES('$username', '$station_id', '$report', '$details', '$actualpath')";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}