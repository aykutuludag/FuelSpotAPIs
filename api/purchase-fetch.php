<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
    
	// Mandatory
    $vehicleID = $_POST['vehicleID'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($vehicleID) == 0 || $vehicleID == 0) {
        echo "vehicleID required";
        return;
    }

    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "SELECT * FROM purchases WHERE vehicleID = '" . $vehicleID . "' ORDER BY time DESC";
    
    $result = $conn->query($sql) or die(mysqli_connect_error());
    if (!empty($result)) {
        // check for empty result
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode($myArray);
        }
    }
	mysqli_close($conn);
}
?>