<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
	// Mandatory
    $location  = $_POST['location'];
	$radius  = $_POST['radius'];
	$userKey   = $_POST['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
    if (strlen($location) == 0) {
        echo "location required";
        return;
    }
	
    if (strlen($radius) == 0) {
        echo "radius required";
        return;
    }
   
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
	
	$user_lat  = explode(";", $location)[0];
	$user_lon  = explode(";", $location)[1];
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT *, ( 6371000 * acos( cos( radians('" . $user_lat . "') ) * cos( radians( SUBSTRING_INDEX(location, ';', 1) ) ) * cos( radians( SUBSTRING_INDEX(location, ';', -1) ) - radians('" . $user_lon . "') ) + sin( radians('" . $user_lat . "') ) * sin( radians( SUBSTRING_INDEX(location, ';', 1) ) ) ) ) AS distance FROM stations WHERE isActive='1' HAVING distance < '" . $radius . "' ORDER BY distance LIMIT 0, 33";
	
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