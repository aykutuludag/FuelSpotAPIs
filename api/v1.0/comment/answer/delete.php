<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../../token-validator.php');

    // Parameters
    $commentID = $_POST['commentID'];

    if (strlen($commentID) == 0 || $commentID == 0) {
        echo "commentID required";
        exit;
    }

	require_once('../../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "UPDATE comments SET answer = '', replyTime = '', logo = '' WHERE id= '" . $commentID . "'";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}