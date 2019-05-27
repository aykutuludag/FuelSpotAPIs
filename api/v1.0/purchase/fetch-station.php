<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $stationID = $_GET['stationID'];
    $outPutArray = [];
	

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