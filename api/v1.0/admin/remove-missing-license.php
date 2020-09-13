<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $id = $_POST['id'];

    if (strlen($id) == 0 || $id == 0) {
        echo "id required";
        exit;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "DELETE FROM missing_licenses WHERE id= $id";

    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}