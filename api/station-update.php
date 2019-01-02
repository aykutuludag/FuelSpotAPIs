<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
    // Mandatory
    $stationID = $_POST['stationID'];
	$userKey          = $_POST['AUTH_KEY'];
    
	// Optional but at least one required.
    $stationVicinity  = $_POST['stationVicinity'];
    $facilities       = $_POST['facilities'];
    $gasolinePrice    = $_POST['gasolinePrice'];
    $dieselPrice      = $_POST['dieselPrice'];
    $LPGPrice         = $_POST['lpgPrice'];
    $elecPrice        = $_POST['electricityPrice'];
    $licenseNo        = $_POST['licenseNo'];
    $owner            = $_POST['owner'];
    $hasFuelDelivery  = $_POST['fuelDelivery'];
    
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
    $sql  = "UPDATE stations SET";
    
    if (strlen($stationVicinity) > 0) {
        $var1 = " vicinity='$stationVicinity',";
        $sql  = $sql . $var1;
    }
    
    if (strlen($facilities) > 0) {
        $var2 = " facilities='$facilities',";
        $sql  = $sql . $var2;
    } else {
		$var3 = " facilities='',";
        $sql  = $sql . $var3;
	}
    
    if (strlen($gasolinePrice) > 0) {
        $var4 = " gasolinePrice='$gasolinePrice',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($dieselPrice) > 0) {
        $var5 = " dieselPrice='$dieselPrice',";
        $sql  = $sql . $var5;
    }
    
    if (strlen($LPGPrice) > 0) {
        $var6 = " lpgPrice='$LPGPrice',";
        $sql  = $sql . $var6;
    }
    
    if (strlen($elecPrice) > 0) {
        $var7 = " electricityPrice='$elecPrice',";
        $sql   = $sql . $var7;
    }
    
    if (strlen($licenseNo) > 0) {
        $var8 = " licenseNo='$licenseNo',";
        $sql   = $sql . $var8;
    } else {
		$var9 = " licenseNo='',";
        $sql   = $sql . $var9;
	}
    
    if (strlen($owner) > 0) {
        $var10 = " owner='$owner',";
        $sql   = $sql . $var10;
    } else {
		$var11 = " owner='',";
        $sql   = $sql . $var11;
	}
    
    if (strlen($hasFuelDelivery) > 0) {
        $var12 = " isDeliveryAvailable='$hasFuelDelivery',";
        $sql   = $sql . $var12;
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
?>