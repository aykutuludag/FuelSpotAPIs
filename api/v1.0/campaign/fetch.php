<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $sID = $_GET['stationID'];
    $date = date('Y-m-d H:i:s');
    $outPutArray = [];

    if (strlen($sID) == 0 || $sID == 0) {
        echo "stationID required";
        exit;
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
