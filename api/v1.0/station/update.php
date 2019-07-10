<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');
    
    // Parameters
    $stationID     = $_POST['stationID'];
    $stationName   = $_POST['stationName'];
    $country       = $_POST['country'];
    $address       = $_POST['address'];
    $facilities    = $_POST['facilities'];
    $gasolinePrice = $_POST['gasolinePrice'];
    $dieselPrice   = $_POST['dieselPrice'];
    $LPGPrice      = $_POST['lpgPrice'];
    $elecPrice     = $_POST['electricityPrice'];
	$otherFuels      = $_POST['otherFuels'];
    
    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        exit;
    }
    
    if (strlen($stationName) == 0) {
        echo "stationName required";
        exit;
    }
    
    if (strlen($country) == 0) {
        echo "country required";
        exit;
    }
    
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "UPDATE stations SET";
    
    if (strlen($address) > 0) {
        $var = " vicinity='$address',";
        $sql = $sql . $var;
    }
    
    if (strlen($facilities) > 0) {
        $var1 = " facilities='$facilities',";
        $sql  = $sql . $var1;
    }
    
    if (strlen((string) $gasolinePrice) > 0) {
        $var2 = " gasolinePrice='$gasolinePrice',";
        $sql  = $sql . $var2;
    } else {
        $gasolinePrice = 0;
    }
    
    if (strlen((string) $dieselPrice) > 0) {
        $var3 = " dieselPrice='$dieselPrice',";
        $sql  = $sql . $var3;
    } else {
        $dieselPrice = 0;
    }
    
    if (strlen((string) $LPGPrice) > 0) {
        $var4 = " lpgPrice='$LPGPrice',";
        $sql  = $sql . $var4;
    } else {
        $LPGPrice = 0;
    }
    
    if (strlen((string) $elecPrice) > 0) {
        $var5 = " electricityPrice='$elecPrice',";
        $sql  = $sql . $var5;
    } else {
        $elecPrice = 0;
    }
	
    if (strlen($otherFuels) > 0) {
        $var6 = " otherFuels='$otherFuels',";
        $sql   = $sql . $var6;
        
        $arr  = json_decode($otherFuels, true);
        $gas2 = $arr[0]["gasoline2"];
        $die2 = $arr[0]["diesel2"];
    }
    
    if ($sql == "UPDATE stations SET") {
        echo "At least 1 optional parameter required.";
        exit;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $stationID . "'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Success";
            if ($gasolinePrice != 0 || $dieselPrice != 0 || $LPGPrice != 0 || $elecPrice != 0 || $gas2 != 0 || $die2 != 0) {
                $query0  = "SELECT * FROM finance WHERE stationID = '" . $stationID . "' ORDER BY date DESC LIMIT 1";
                $result0 = $conn->query($query0);
                if (mysqli_num_rows($result0) > 0) {
                    $row = mysqli_fetch_assoc($result0);
                    if ($row["gasolinePrice"] != $gasolinePrice || $row["dieselPrice"] != $dieselPrice || $row["lpgPrice"] != $LPGPrice || $row["electricityPrice"] != $elecPrice || $row["gasoline2"] != $gas2 || $row["diesel2"] != $die2) {
						$sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice,gasolinePrice2,dieselPrice2,provider) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice', '$gas2', '$die2', 'admin')";
                        mysqli_query($conn, $sql2);
                    }
                } else {
                    // No record found. Add it.
                    $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice,gasolinePrice2,dieselPrice2,provider) VALUES('$stationID', '$stationName', '$country', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice', '$gas2', '$die2', 'admin')";
                    mysqli_query($conn, $sql2);
                }
            }
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}