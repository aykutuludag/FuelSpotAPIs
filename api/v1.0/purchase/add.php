<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
    $vehicleID = $_POST['vehicleID'];
    $plateNO = $_POST['plateNO'];
    $kilometer = $_POST['kilometer'];
    $stationID = $_POST['stationID'];
    $stationName = $_POST['stationNAME'];
    $stationLocation = $_POST['stationLOC'];
    $stationIcon = $_POST['stationICON'];
    $fuelType = $_POST['fuelType'];
    $fuelPrice = $_POST['fuelPrice'];
    $fuelLiter = $_POST['fuelLiter'];
    $fuelTax = $_POST['fuelTax'];
    $subTotal = $_POST['subTotal'];
    $totalPrice = $_POST['totalPrice'];
    $country = $_POST['country'];
    $unit = $_POST['unit'];
    $currency = $_POST['currency'];
    $fuelType2 = $_POST['fuelType2'];
    $fuelPrice2 = $_POST['fuelPrice2'];
    $fuelLiter2 = $_POST['fuelLiter2'];
    $fuelTax2 = $_POST['fuelTax2'];
    $subTotal2 = $_POST['subTotal2'];
    $billPhoto = $_POST['billPhoto'];

    if (strlen($vehicleID) == 0 || $vehicleID == 0) {
        echo "vehicleID required";
        exit;
    }

    if (strlen($plateNO) == 0) {
        echo "plateNO required";
        exit;
    }

    if (strlen($kilometer) == 0 || $kilometer == 0) {
        echo "kilometer required";
        exit;
    }

    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        exit;
    }

    if (strlen($stationName) == 0) {
        echo "stationNAME required";
        exit;
    }

    if (strlen($stationLocation) == 0) {
        echo "stationLOC required";
        exit;
    }

    if (strlen($stationIcon) == 0) {
        echo "stationICON required";
        exit;
    }

    if ((strlen($fuelType) == 0 || $fuelType == -1) && (strlen($fuelType2) == 0 || $fuelType2 == -1)) {
        echo "fuelType required";
        exit;
    }

    if (strlen($fuelPrice) == 0) {
        echo "fuelPrice required";
        exit;
    }

    if (strlen($fuelLiter) == 0) {
        echo "fuelLiter required";
        exit;
    }

    if (strlen($fuelTax) == 0) {
        echo "fuelTax required";
        exit;
    }

    if (strlen($subTotal) == 0) {
        echo "subTotal required";
        exit;
    }

    if (strlen($totalPrice) == 0 || $totalPrice == 0) {
        echo "totalPrice required";
        exit;
    }

    if (strlen($country) == 0) {
        echo "country required";
        exit;
    }

    if (strlen($unit) == 0) {
        echo "unit required";
        exit;
    }

    if (strlen($currency) == 0) {
        echo "currency required";
        exit;
    }

    if ($billPhoto != null) {
        $timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp, base64_decode($billPhoto));
    } else {
        $actualpath = '';
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "INSERT INTO purchases(username,vehicleID,plateNo,kilometer,stationID,stationName,stationLocation,stationIcon,fuelType,fuelPrice,fuelLiter,fuelTax,subTotal,fuelType2,fuelPrice2,fuelLiter2,fuelTax2,subTotal2,totalPrice,country,unit,currency,billPhoto) VALUES ('$username', '$vehicleID', '$plateNO', '$kilometer' , '$stationID', '$stationName', '$stationLocation', '$stationIcon', '$fuelType', '$fuelPrice', '$fuelLiter', '$fuelTax', '$subTotal', '$fuelType2', '$fuelPrice2', '$fuelLiter2', '$fuelTax2', '$subTotal2', '$totalPrice', '$country', '$unit', '$currency', '$actualpath')";

    if (mysqli_query($conn, $sql)) {
        $sqlVehicle = "UPDATE automobiles SET kilometer='" . $kilometer . "' WHERE id= '" . $vehicleID . "'";
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