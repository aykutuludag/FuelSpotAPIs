<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $id            = $_POST['purchaseID'];
	$username      = $_POST['username'];
	$billPhoto   = $_POST['billPhoto'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($id) == 0 || $id == 0) {
        echo "purchaseID required";
        return;
    }
	
	if (strlen($username) == 0) {
        echo "username required";
        return;
    }
	
	if (strlen($billPhoto) == 0) {
        echo "billPhoto required";
        return;
    }
	
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if (strlen($billPhoto) > 0) {
		$timeStamp = time() . '.jpg';
        $actualpath       = 'https://fuel-spot.com/uploads/bills/' . $username . '-'. $timeStamp;
		file_put_contents('/home/u8276450/fuel-spot.com/uploads/bills/' . $username . '-'. $timeStamp, base64_decode($billPhoto));
		
		$sql = "UPDATE purchases SET billPhoto = '$actualpath' WHERE id= '" . $id . "'";
		
		if ($conn->query($sql) === TRUE) {
			echo "Success";
		} else {
			echo "Fail";
		}
    }
    mysqli_close($conn);
}
?>