<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $commentID = $_POST['commentID'];
    $comment = $_POST['comment'];
    $userStars = $_POST['stars'];

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

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
	
	$comment = mysqli_real_escape_string($conn, $comment);

    $sql = "UPDATE comments SET comment= '$comment', stars = '$userStars' WHERE id= '" . $commentID . "'";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}