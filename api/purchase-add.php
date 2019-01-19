﻿<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Mandatory
    $username        = $_POST['username'];
    $vehicleID       = $_POST['vehicleID'];
    $plateNO         = $_POST['plateNO'];
    $kilometer       = $_POST['kilometer'];
    $stationID       = $_POST['stationID'];
    $stationName     = $_POST['stationNAME'];
    $stationLocation = $_POST['stationLOC'];
    $stationIcon     = $_POST['stationICON'];
    $fuelType        = $_POST['fuelType'];
    $fuelPrice       = $_POST['fuelPrice'];
    $fuelLiter       = $_POST['fuelLiter'];
    $fuelTax         = $_POST['fuelTax'];
    $totalPrice      = $_POST['totalPrice'];
    $country         = $_POST['country'];
    $unit            = $_POST['unit'];
    $currency        = $_POST['currency'];
    $userKey         = $_POST['AUTH_KEY'];
    
    // Optional
    $fuelType2  = $_POST['fuelType2'];
    $fuelPrice2 = $_POST['fuelPrice2'];
    $fuelLiter2 = $_POST['fuelLiter2'];
    $fuelTax2   = $_POST['fuelTax2'];
    $billPhoto  = $_POST['billPhoto'];
    
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
    
    if (strlen($kilometer) == 0 || $kilometer == 0) {
        echo "kilometer required";
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
    
    if (strlen($stationLocation) == 0) {
        echo "stationLOC required";
        return;
    }
    
    if (strlen($stationIcon) == 0) {
        echo "stationICON required";
        return;
    }
    
    if (strlen($fuelType) == 0 || $fuelType == -1) {
        echo "fuelType required";
        return;
    }
    
    if (strlen($fuelPrice) == 0) {
        echo "fuelPrice required";
        return;
    }
    
    if (strlen($fuelLiter) == 0) {
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
    
    if (strlen($country) == 0) {
        echo "country required";
        return;
    }
    
    if (strlen($unit) == 0) {
        echo "unit required";
        return;
    }
    
    if (strlen($currency) == 0) {
        echo "currency required";
        return;
    }
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($billPhoto != null) {
        $timeStamp  = time() . '.jpg';
        $actualpath = 'https://fuel-spot.com/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuel-spot.com/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp, base64_decode($billPhoto));
    } else {
        $actualpath = '';
    }
    
    $sql = "INSERT INTO purchases(username,vehicleID,plateNo,kilometer,stationID,stationName,stationLocation,stationIcon,fuelType,fuelPrice,fuelLiter,fuelTax,fuelType2,fuelPrice2,fuelLiter2,fuelTax2,totalPrice,country,unit,currency,billPhoto) VALUES ('$username', '$vehicleID', '$plateNO', '$kilometer' , '$stationID', '$stationName', '$stationLocation', '$stationIcon', '$fuelType', '$fuelPrice', '$fuelLiter', '$fuelTax', '$fuelType2', '$fuelPrice2', '$fuelLiter2', '$fuelTax2', '$totalPrice', '$country', '$unit', '$currency', '$actualpath')";
    
    if (mysqli_query($conn, $sql)) {
		$sqlVehicle = "UPDATE automobiles SET kilometer='$kilometer' WHERE id= '" . $vehicleID . "'";
        if ($conn->query($sqlVehicle) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
?>