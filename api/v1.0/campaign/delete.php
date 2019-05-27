<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $campaignID = $_POST['campaignID'];
	$userKey   = $_POST['AUTH_KEY'];

	
	if (strlen($campaignID) == 0 || $campaignID == 0) {
        echo "campaignID required";
        return;
    }
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql  = "DELETE FROM campaigns WHERE id= $campaignID";
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
