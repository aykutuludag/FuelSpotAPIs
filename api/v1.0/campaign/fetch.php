<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $sID = $_POST['stationID'];
    $userKey = $_POST['AUTH_KEY'];
    $date = date('Y-m-d H:i:s');
    $outPutArray = [];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($sID) == 0 || $sID == 0) {
        echo "stationID required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "SELECT * FROM campaigns WHERE stationID = '" . $sID . "' AND campaignEnd >= '" . $date . "' ORDER BY campaignStart DESC";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
