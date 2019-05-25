<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $username = $_POST['username'];
    $id       = $_POST['vehicleID'];
    $userKey  = $_POST['AUTH_KEY'];
    
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
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