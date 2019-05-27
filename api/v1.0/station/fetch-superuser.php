<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $superusername = $_GET['superusername'];
    $outPutArray = [];

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