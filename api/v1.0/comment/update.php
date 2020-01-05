<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
	$station_id = $_POST['stationID'];
    $username = $_POST['username'];
    $commentID = $_POST['commentID'];
    $comment = $_POST['comment'];
    $userStars = $_POST['stars'];
	$commentPhoto = $_POST['commentPhoto'];

    if (strlen($commentID) == 0 || $commentID == 0) {
        echo "commentID required";
        exit;
    }

    if (strlen($comment) == 0) {
        echo "comment required";
        exit;
    }

    if (strlen($userStars) == 0) {
        echo "rate required";
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

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
	
	$comment = mysqli_real_escape_string($conn, $comment);
	
	if (strlen($commentPhoto) > 0) {
        $timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/comments/' . $username . '-' . $station_id . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/comments/' . $username . '-' . $station_id . '-' . $timeStamp, base64_decode($commentPhoto));
    } else {
        $actualpath = '';
    }

    $sql = "UPDATE comments SET comment= '$comment', stars = '$userStars', comment_photo = '$actualpath' WHERE id= '" . $commentID . "'";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}