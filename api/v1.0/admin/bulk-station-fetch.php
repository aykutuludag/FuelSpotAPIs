<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $country = $_GET['country'];
    $outPutArray = [];

    if (strlen($country) == 0) {
        echo "country is required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "SELECT * FROM stations WHERE country = '" . $country . "' ORDER BY id";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
