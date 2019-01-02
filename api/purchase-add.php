<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $username    = $_POST['username'];
	$vehicleID   = $_POST['vehicleID'];
	$plateNO     = $_POST['plateNO'];
    $stationID   = $_POST['stationID'];
    $stationName = $_POST['stationNAME'];
    $stationIcon = $_POST['stationICON'];
    $stationLocation = $_POST['stationLOC'];
    $fuelType    = $_POST['fuelType'];
    $fuelPrice   = $_POST['fuelPrice'];
    $fuelLiter   = $_POST['fuelLiter'];
	$fuelTax     = $_POST['fuelTax'];
    $totalPrice  = $_POST['totalPrice'];
    $kilometer = $_POST['kilometer'];
	$unit     = $_POST['unit'];
    $currency = $_POST['currency'];
	$paymentType = "Manuel"; // For now...
	$bonus    = $_POST['bonus'];
	$userKey   = $_POST['AUTH_KEY'];
	
	// Optional
    $fuelType2   = $_POST['fuelType2'];
    $fuelPrice2  = $_POST['fuelPrice2'];
    $fuelLiter2  = $_POST['fuelLiter2'];
	$fuelTax2    = $_POST['fuelTax2'];
	$billPhoto   = $_POST['billPhoto'];
	
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($vehicleID) == 0 || $vehicleID == 0) {
        echo "vehicleID required";
        return;
    }
	
	if (strlen($plateNO) == 0) {
        echo "plateNO required";
        return;
    }
	
	if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        return;
    }
	
	if (strlen($stationName) == 0) {
        echo "stationNAME required";
        return;
    }
	
	if (strlen($stationIcon) == 0) {
        echo "stationICON required";
        return;
    }
	
	if (strlen($stationLocation) == 0) {
        echo "stationLOC required";
        return;
    }
	
	if (strlen($fuelType) == 0 || $fuelType == -1) {
        echo "fuelType required";
        return;
    }
	
	if (strlen($fuelPrice) || $fuelPrice == 0) {
        echo "fuelPrice required";
        return;
    }
	
	if (strlen($fuelLiter) == 0 || $fuelLiter == 0) {
        echo "fuelLiter required";
        return;
    }
	
	if (strlen($fuelTax) == 0) {
        echo "fuelTax required";
        return;
    }
	
	if (strlen($totalPrice) == 0 || $totalPrice == 0) {
        echo "totalPrice required";
        return;
    }
	
	if (strlen($kilometer) == 0) {
        echo "totalPrice required";
        return;
    }
	
	if (strlen($unit) == 0) {
        echo "unit required";
        return;
    }
	
	if (strlen($currency) == 0){
		echo "currency required";
		return;
	}
	
	if (strlen($bonus) == 0) {
        echo "bonus required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	
	if ($billPhoto != null) {
		$timeStamp = new DateTime()->getTimestamp() . '.jpg';
        $actualpath = 'https://fuel-spot.com/uploads/bills/' . $username . '-' . $timeStamp;
		file_put_contents('/home/u8276450/fuel-spot.com/uploads/bills/' . $username . '-' . $timeStamp . $fileExt, base64_decode($screenshot));
	    $sql = "INSERT INTO purchases(username,vehicleID,plateNo,stationID,stationName,stationIcon,stationLocation,fuelType,fuelPrice,fuelLiter,fuelTax,fuelType2,fuelPrice2,fuelLiter2,fuelTax2,totalPrice,billPhoto,kilometer,unit,currency) VALUES ('$username', '$vehicleID', '$plateNO', '$stationID', '$stationName', '$stationIcon', '$stationLocation', '$fuelType', '$fuelPrice', '$fuelLiter', '$fuelTax', '$fuelType2', '$fuelPrice2', '$fuelLiter2', '$fuelTax2', '$totalPrice', '$actualpath', '$kilometer', '$unit', '$currency')";
    } else {
        $sql = "INSERT INTO purchases(username,vehicleID,plateNo,stationID,stationName,stationIcon,stationLocation,fuelType,fuelPrice,fuelLiter,fuelTax,fuelType2,fuelPrice2,fuelLiter2,fuelTax2,totalPrice,kilometer,unit,currency) VALUES ('$username', '$vehicleID', '$plateNO', '$stationID', '$stationName', '$stationIcon', '$stationLocation', '$fuelType', '$fuelPrice', '$fuelLiter', '$fuelTax', '$fuelType2', '$fuelPrice2', '$fuelLiter2', '$fuelTax2', '$totalPrice', '$kilometer', '$unit', '$currency')";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
		 echo "Fail";
	}
    mysqli_close($conn);
}
?>