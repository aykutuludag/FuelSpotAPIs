<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
	// Mandatory
    $commentID  = $_POST['commentID'];
    $answer    = $_POST['answer'];
    $logo      = $_POST['logo'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($commentID) == 0 || $commentID == 0) {
        echo "commentID required";
        return;
    }
	
	if (strlen($answer) == 0) {
        echo "answer required";
        return;
    }
	
	if (strlen($logo) == 0) {
        echo "logo required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "UPDATE comments SET answer= '$answer', logo= '$logo' WHERE id= '" . $commentID . "'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>