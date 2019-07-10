<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $date = date('Y-m-d H:i:s');
    $outPutArray = [];

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "SELECT * FROM campaigns_global WHERE campaignEnd >= '" . $date . "' ORDER BY campaignEnd ASC";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
