<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $name    = $_POST['name'];
	$vicinity  = $_POST['vicinity'];
	$country  = $_POST['country'];
	$location  = $_POST['location'];
	$googleID  = $_POST['googleID'];
	$logoURL = $_POST['logoURL'];
	$userKey   = $_POST['AUTH_KEY'];
	
	// Optional
	$facilities = '[{"WC":"1","Market":"1","CarWash":"1","TireRepair":"0","Mechanic":"0","Restaurant":"0","ParkSpot":"0"}]'; // Just assign pre-assumed facilities. This behavior will be changed in the future.
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($name) == 0) {
        echo "name required";
        return;
    }
	
	if (strlen($vicinity) == 0) {
        echo "vicinity required";
        return;
    }
	
	if (strlen($country) == 0) {
        echo "country required";
        return;
    }
	
	if (strlen($location) == 0) {
        echo "location required";
        return;
    }
	
	if (strlen($googleID) != 27) {
        echo "googleID is null or corrupt";
        return;
    }
	
	if (strlen($logoURL) == 0) {
        echo "logoURL required";
        return;
    }
	
	$myArray = array();
	
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
	
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		
	$sql    = "INSERT INTO stations(name,vicinity,country,location,googleID,facilities,logoURL) VALUES('$name', '$vicinity', '$country', '$location', '$googleID', '$facilities', '$logoURL')";
	$result = mysqli_query($conn, $sql);
		
	$sql2 = "SELECT * FROM stations WHERE googleID = '" . $googleID . "' AND isActive='1'";
	$result2 = $conn->query($sql2) or die(mysqli_connect_error());
		
	if (!empty($result2)) {
		if (mysqli_num_rows($result2) > 0) {
			while ($row = $result2->fetch_array(MYSQL_ASSOC)) {
				array_push($myArray, $row);
			}
			echo json_encode($myArray);
		}
	}
	mysqli_close($conn);
}
?>