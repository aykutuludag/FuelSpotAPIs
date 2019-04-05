<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
	// Mandatory
    $stationID = $_POST['stationID'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }

    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM finance WHERE stationID = '" . $stationID . "' ORDER BY date DESC LIMIT 0, 10";
    
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