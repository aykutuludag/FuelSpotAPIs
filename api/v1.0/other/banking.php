<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $username = $_GET['username'];
    $outPutArray = [];

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "SELECT * FROM banking WHERE username = '" . $username . "' ORDER BY time DESC LIMIT 0, 3";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}