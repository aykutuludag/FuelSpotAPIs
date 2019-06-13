<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../../token-validator.php');

    // Parameters
    $commentID = $_POST['commentID'];
    $answer = $_POST['answer'];
    $logo = $_POST['logo'];

    if (strlen($commentID) == 0 || $commentID == 0) {
        echo "commentID required";
        exit;
    }

    if (strlen($answer) == 0) {
        echo "answer required";
        exit;
    }

    if (strlen($logo) == 0) {
        echo "logo required";
        exit;
    }

	require_once('../../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "UPDATE comments SET answer= '$answer', logo= '$logo' WHERE id= '" . $commentID . "'";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
