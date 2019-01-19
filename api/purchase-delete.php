<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
   	// Mandatory
    $id        = $_POST['purchaseID'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($id) == 0 || $id == 0) {
        echo "purchaseID required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "DELETE FROM purchases WHERE id= $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>