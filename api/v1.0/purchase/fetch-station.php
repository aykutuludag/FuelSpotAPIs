<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $stationID = $_POST['stationID'];
	$userKey   = $_POST['AUTH_KEY'];
    $outPutArray = [];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql  = "SELECT * FROM purchases WHERE stationID = '" . $stationID . "' ORDER BY time DESC";

    $result = $conn->query($sql);
    if (!empty($result)) {
        // check for empty result
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $outPutArray[] = $row;
            }
            echo json_encode($outPutArray);
        }
    }
	mysqli_close($conn);
}