<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Parameters
    $stationID        = $_POST['stationID'];
    $stationName      = $_POST['stationName'];
    $stationVicinity  = $_POST['stationVicinity'];
    $country          = $_POST['country'];
    $location         = $_POST['location'];
    $facilities       = $_POST['facilities'];
    $stationLogo      = $_POST['stationLogo'];
    $gasolinePrice    = $_POST['gasolinePrice'];
    $dieselPrice      = $_POST['dieselPrice'];
    $LPGPrice         = $_POST['lpgPrice'];
    $elecPrice        = $_POST['electricityPrice'];
    $licenseNo        = $_POST['licenseNo'];
    $owner            = $_POST['owner'];
    $isVerified       = $_POST['isVerified'];
    $hasMobilePayment = $_POST['mobilePayment'];
    $hasFuelDelivery  = $_POST['fuelDelivery'];
    $isActive         = $_POST['isActive'];
    $userKey          = $_POST['AUTH_KEY'];
    
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
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql  = "UPDATE stations SET";
    
    if (strlen($stationName) > 0) {
        $var0 = " name='$stationName',";
        $sql  = $sql . $var0;
    }
    
    if (strlen($stationVicinity) > 0) {
        $var1 = " vicinity='$stationVicinity',";
        $sql  = $sql . $var1;
    }
    
    if (strlen($country) > 0) {
        $var2 = " country='$country',";
        $sql  = $sql . $var2;
    }
    
    if (strlen($location) > 0) {
        $var3 = " location='$location',";
        $sql  = $sql . $var3;
    }
    
    if (strlen($facilities) > 0) {
        $var4 = " facilities='$facilities',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($stationLogo) > 0) {
        $var5 = " logoURL='$stationLogo',";
        $sql  = $sql . $var5;
    }
    
    if (strlen((string) $gasolinePrice) > 0) {
        $var6 = " gasolinePrice='$gasolinePrice',";
        $sql  = $sql . $var6;
    } else {
        $gasolinePrice = 0;
    }
    
    if (strlen((string) $dieselPrice) > 0) {
        $var7 = " dieselPrice='$dieselPrice',";
        $sql  = $sql . $var7;
    } else {
        $dieselPrice = 0;
    }
    
    if (strlen((string) $LPGPrice) > 0) {
        $var8 = " lpgPrice='$LPGPrice',";
        $sql  = $sql . $var8;
    } else {
        $LPGPrice = 0;
    }
    
    if (strlen((string) $elecPrice) > 0) {
        $var9 = " electricityPrice='$elecPrice',";
        $sql  = $sql . $var9;
    } else {
        $elecPrice = 0;
    }
    
    if (strlen($licenseNo) > 0) {
        $var10 = " licenseNo='$licenseNo',";
        $sql   = $sql . $var10;
    }
    
    if (strlen($owner) > 0) {
        $var11 = " owner='$owner',";
        $sql   = $sql . $var11;
    }
    
    if (strlen((string) $isVerified) > 0) {
        $var12 = " isVerified='$isVerified',";
        $sql   = $sql . $var12;
    }
    
    if (strlen((string) $hasMobilePayment) > 0) {
        $var13 = " isMobilePaymentAvailable='$hasMobilePayment',";
        $sql   = $sql . $var13;
    }
    
    if (strlen((string) $hasFuelDelivery) > 0) {
        $var14 = " isDeliveryAvailable='$hasFuelDelivery',";
        $sql   = $sql . $var14;
    }
    
    if (strlen((string) $isActive) > 0) {
        $var15 = " isActive='$isActive'";
        $sql   = $sql . $var15;
    }
    
    if ($sql == "UPDATE stations SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $stationID . "'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Success";
            if ($gasolinePrice != 0 || $dieselPrice != 0 || $LPGPrice != 0 || $elecPrice != 0) {
                $query0  = "SELECT * FROM finance WHERE stationID = '" . $stationID . "' ORDER BY date DESC LIMIT 1";
                $result0 = $conn->query($query0);
                if (mysqli_num_rows($result0) > 0) {
                    $row = mysqli_fetch_assoc($result0);
                    if ($row["gasolinePrice"] != $gasolinePrice || $row["dieselPrice"] != $dieselPrice || $row["lpgPrice"] != $LPGPrice || $row["electricityPrice"] != $elecPrice) {
                         $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice')";
						 mysqli_query($conn, $sql2);
                    }
                } else {
                    // No record found. Add it.
                     $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice')";
					 mysqli_query($conn, $sql2);
                }
            }
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}