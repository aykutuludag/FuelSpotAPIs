<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $stationID = $_POST['stationID'];
    $userKey = $_POST['AUTH_KEY'];
    
    // Optional but at least one required.
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
    $isVerified = $_POST['isVerified'];
    $hasMobilePayment = $_POST['mobilePayment'];
    $hasFuelDelivery  = $_POST['fuelDelivery'];
    $isActive         = $_POST['isActive'];
    
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

    if (strlen((string)$gasolinePrice) > 0) {
        $var6 = " gasolinePrice='$gasolinePrice',";
        $sql  = $sql . $var6;
    }

    if (strlen((string)$dieselPrice) > 0) {
        $var7 = " dieselPrice='$dieselPrice',";
        $sql  = $sql . $var7;
    }

    if (strlen((string)$LPGPrice) > 0) {
        $var8 = " lpgPrice='$LPGPrice',";
        $sql  = $sql . $var8;
    }

    if (strlen((string)$elecPrice) > 0) {
        $var9 = " electricityPrice='$elecPrice',";
        $sql = $sql . $var9;
    }
    
    if (strlen($licenseNo) > 0) {
        $var10 = " licenseNo='$licenseNo',";
        $sql   = $sql . $var10;
    }
    
    if (strlen($owner) > 0) {
        $var11 = " owner='$owner',";
        $sql   = $sql . $var11;
    }

    if (strlen((string)$isVerified) > 0) {
        $var12 = " isVerified='$isVerified',";
        $sql   = $sql . $var12;
    }

    if (strlen((string)$hasMobilePayment) > 0) {
        $var13 = " isMobilePaymentAvailable='$hasMobilePayment',";
        $sql   = $sql . $var13;
    }

    if (strlen((string)$hasFuelDelivery) > 0) {
        $var14 = " isDeliveryAvailable='$hasFuelDelivery',";
        $sql   = $sql . $var14;
    }

    if (strlen((string)$isActive) > 0) {
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
            if ($gasolinePrice != 0 || $dieselPrice != 0 || $LPGPrice != 0 || $elecPrice != 0) {
                $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice')";
                mysqli_query($conn, $sql2);
            }
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}
