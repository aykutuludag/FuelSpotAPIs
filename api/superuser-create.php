<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $username = $_POST['username'];
    $name     = $_POST['name'];
	$userKey   = $_POST['AUTH_KEY'];
	
	// Optional
	$email    = $_POST['email'];
    $photo    = $_POST['photo'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($username) == 0) {
        echo "username required";
        return;
    }
	
	if (strlen($name) == 0) {
        echo "username required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "INSERT INTO superusers(username,name,email,photo) VALUES ('$username','$name','$email','$photo')";
	
    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
	
	
	$sql_result = mysqli_query($conn, "SELECT * FROM superusers WHERE username = '" . $username . "'") or die(mysql_error());
	$sql_row = mysqli_fetch_assoc($sql_result);
	if(!empty($sql_row)) {
		echo "Success";
	} else {
		// register & login
		$sql = "INSERT INTO superusers(username,name,email,photo) VALUES ('$username','$name','$email','$photo')";	
		if (mysqli_query($conn, $sql)) {
			echo "Success";
		} else {
			echo "Fail";
		}
	}
	mysqli_close($conn);
}
?>