<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $commentID = $_POST['commentID'];
    $comment = $_POST['comment'];
    $userStars = $_POST['stars'];
    $userKey = $_POST['AUTH_KEY'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($commentID) == 0 || $commentID == 0) {
        echo "commentID required";
        return;
    }

    if (strlen($comment) == 0) {
        echo "comment required";
        return;
    }

    if (strlen($userStars) == 0) {
        echo "rate required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "UPDATE comments SET comment= '$comment', stars = '$userStars' WHERE id= '" . $commentID . "'";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}