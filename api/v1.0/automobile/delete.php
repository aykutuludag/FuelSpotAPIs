<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
    $id       = $_POST['vehicleID'];
    
    if (strlen($username) == 0) {
        echo "username required";
        return;
    }
    
    if (strlen($id) == 0 || $id == 0) {
        echo "vehicleID required";
        return;
    }
    
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql  = "DELETE FROM automobiles WHERE id= $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}