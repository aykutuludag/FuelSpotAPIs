<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $superusername = $_POST['superusername'];
    $userKey = $_POST['AUTH_KEY'];
    $outPutArray = [];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($superusername) == 0) {
        echo "superusername required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "SELECT * FROM stations WHERE owner = '" . $superusername . "' AND isActive='1'";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}