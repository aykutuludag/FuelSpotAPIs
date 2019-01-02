<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $commentID = $_POST['commentID'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($commentID) == 0 || $commentID == 0){
		echo "commentID required";
		return;
	}
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "DELETE FROM comments WHERE id= $commentID";
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>