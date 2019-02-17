<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
    // Mandatory
    $stationID = $_POST['stationID'];
	$stationName  = $_POST['stationName'];
	$country      = $_POST['country'];
	$userKey      = $_POST['AUTH_KEY'];
    
	// Optional but at least one required.
	$address          = $_POST['address'];
    $facilities       = $_POST['facilities'];
    $gasolinePrice    = $_POST['gasolinePrice'];
    $dieselPrice      = $_POST['dieselPrice'];
    $LPGPrice         = $_POST['lpgPrice'];
    $elecPrice        = $_POST['electricityPrice'];
    
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }
    
	if (strlen($stationName) == 0) {
		echo "stationName required";
        return;
    }
	
	if (strlen($country) == 0) {
		echo "country required";
        return;
    }
	
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "UPDATE stations SET";
	
	if (strlen($address) > 0) {
        $var = " vicinity='$address',";
        $sql  = $sql . $var;
    }
    
    if (strlen($facilities) > 0) {
        $var1 = " facilities='$facilities',";
        $sql  = $sql . $var1;
    }
    
    if (strlen($gasolinePrice) > 0) {
        $var2 = " gasolinePrice='$gasolinePrice',";
        $sql  = $sql . $var2;
    }
    
    if (strlen($dieselPrice) > 0) {
        $var3 = " dieselPrice='$dieselPrice',";
        $sql  = $sql . $var3;
    }
    
    if (strlen($LPGPrice) > 0) {
        $var4 = " lpgPrice='$LPGPrice',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($elecPrice) > 0) {
        $var5 = " electricityPrice='$elecPrice',";
        $sql   = $sql . $var5;
    }
    
    if ($sql == "UPDATE stations SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
		$dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
          $sql=  substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $stationID . "'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Success";
			if ($gasolinePrice != 0 || $dieselPrice != 0 || $LPGPrice != 0 || $elecPrice != 0) {
				$sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice')";
				mysqli_query($conn, $sql2);
			}
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}