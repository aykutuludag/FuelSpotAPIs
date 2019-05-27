<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $id  = $_POST['vehicleID'];
    $username = $_POST['username'];
	
	// Optional but at least one required.
    $car_brand = $_POST['carBrand'];
    $car_model = $_POST['carModel'];
    $fuel_pri  = $_POST['fuelPri'];
    $fuel_sec  = $_POST['fuelSec'];
    $car_km    = $_POST['kilometer'];
    $car_photo = $_POST['carPhoto'];
	$plateNo   = $_POST['plate'];
	$avgCons   = $_POST['avgCons'];
	$carbon    = $_POST['carbonEmission'];
	
	if (strlen($id) == 0 || $id == 0) {
        echo "vehicleID required";
        return;
    }

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql  = "UPDATE automobiles SET";
    
	if (strlen($car_brand) > 0) {
        $var1 = " car_brand='$car_brand',";
        $sql  = $sql . $var1;
    }
	
    if (strlen($car_model) > 0) {
        $var2 = " car_model='$car_model',";
        $sql  = $sql . $var2;
    }
	
    if (strlen($fuel_pri) > 0) {
        $var3 = " fuelPri='$fuel_pri',";
        $sql  = $sql . $var3;
    }
    
    if (strlen($fuel_sec) > 0) {
        $var4 = " fuelSec='$fuel_sec',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($car_km) > 0) {
        $var5 = " kilometer='$car_km',";
        $sql  = $sql . $var5;
    }
	
	if (strlen($car_photo) > 0) {
        $actualpath = 'https://fuelspot.com.tr/uploads/automobiles/' . $username . '-' . $plateNo . '.jpg';
		
        $var6 = " carPhoto='$actualpath',";
        $sql  = $sql . $var6;

        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/automobiles/' . $username . '-' . $plateNo . '.jpg', base64_decode($car_photo));
    }
	
    if (strlen($plateNo) > 0) {
        $var7 = " plateNo='$plateNo',";
        $sql  = $sql . $var7;
    }
    
    if (strlen($avgCons) > 0) {
        $var8 = " avgConsumption='$avgCons',";
        $sql  = $sql . $var8;
    }
    
    if (strlen($carbon) > 0) {
        $var9 = " carbonEmission='$carbon',";
        $sql  = $sql . $var9;
    }
	
    if ($sql == "UPDATE automobiles SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
		$dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
          $sql=  substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $id . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}
