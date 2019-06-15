<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $comment = $_POST['comment'];
    $station_id = $_POST['stationID'];
    $username = $_POST['username'];
    $userStars = $_POST['stars'];
    $userphoto = $_POST['user_photo'];

    if (strlen($comment) == 0) {
        echo "comment required";
        exit;
    }

    if (strlen($station_id) == 0 || $station_id == 0) {
        echo "stationID required";
        exit;
    }

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }

    if (strlen($userStars) == 0) {
        echo "stars required";
        exit;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
	
	$comment = mysqli_real_escape_string($conn, $comment);
	
    $sql = "INSERT INTO comments(username,user_photo,station_id,comment,stars) VALUES('$username','$userphoto','$station_id','$comment','$userStars')";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
