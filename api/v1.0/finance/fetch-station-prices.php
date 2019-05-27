<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $stationID = $_POST['stationID'];
    $outPutArray = [];

    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "SELECT * FROM finance WHERE stationID = '" . $stationID . "' ORDER BY date DESC LIMIT 5";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }

    mysqli_close($conn);
}