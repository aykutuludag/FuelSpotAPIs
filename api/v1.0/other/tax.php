<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $country = $_GET['country'];

    if (strlen($country) == 0) {
        echo "country required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "SELECT * FROM taxes WHERE country = '" . $country . "'";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
    }
    mysqli_close($conn);
}