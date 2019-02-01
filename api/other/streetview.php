<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
	// Mandatory
    $location   = $_GET['location'];
	$userKey   = $_GET['AUTH_KEY'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($location) == 0) {
        echo "location required";
        return;
    }
	
	$station_lat  = explode(";", $location)[0];
	$station_lon  = explode(";", $location)[1];
	
	$url = "https://www.google.com/maps?cbll=" . $station_lat . "," . $station_lon . "&layer=c";
    header('Location: ' . $url);
    exit();
}
?>