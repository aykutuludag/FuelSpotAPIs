<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
	$campaignID     = $_POST['campaignID'];
	$userKey   = $_POST['AUTH_KEY'];
	
	// Optional but at least one required.
	$campaignName  = $_POST['campaignName'];
    $campaignDesc  = $_POST['campaignDesc'];
    $campaignStart = $_POST['campaignStart'];
    $campaignEnd   = $_POST['campaignEnd'];
	$campaignPhoto = $_POST['campaignPhoto'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($campaignID) == 0 || $campaignID == 0) {
        echo "campaignID required";
        return;
    }
	
	define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "UPDATE campaigns SET";
    
	if (strlen($campaignName) > 0) {
        $var1 = " campaignName='$campaignName',";
        $sql  = $sql . $var1;
    }
	
    if (strlen($campaignDesc) > 0) {
        $var2 = " campaignDesc='$campaignDesc',";
        $sql  = $sql . $var2;
    }
	
    if (strlen($campaignStart) > 0) {
        $var3 = " campaignStart='$campaignStart',";
        $sql  = $sql . $var3;
    }
    
    if (strlen($campaignEnd) > 0) {
        $var4 = " campaignEnd='$campaignEnd',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($campaignPhoto) > 0) {
		$actualpath       = 'https://fuel-spot.com/FUELSPOTAPP/campaigns/' . $stationID . '-' . $campaignName . '.jpg';
		
        $var5 = " campaignPhoto='$actualpath',";
        $sql  = $sql . $var5;
		
        file_put_contents('/home/u8276450/fuel-spot.com/FUELSPOTAPP/campaigns/' . $stationID . '-' . $campaignName . '.jpg', base64_decode($campaignPhoto));
    }
	
    if ($sql == "UPDATE campaigns SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
		$dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
          $sql=  substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $campaignID . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}
?>