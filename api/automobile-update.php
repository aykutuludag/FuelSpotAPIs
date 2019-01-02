<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'FPh76g0MSZ2okeWQmShYDlXakjgjhbej';
	
	// Mandatory
    $id  = $_POST['vehicleID'];
	$userKey   = $_POST['AUTH_KEY'];
	
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

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($id) == 0 || $id == 0) {
        echo "vehicleID required";
        return;
    }
	
	define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
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
		$actualpath       = 'https://fuel-spot.com/uploads/automobiles/' . $username . '-' . $plateNo . '.jpg';
		
        $var6 = " carPhoto='$actualpath',";
        $sql  = $sql . $var6;
		
		file_put_contents('/home/u8276450/fuel-spot.com/uploads/automobiles/' . $username . '-' . $plateNo . '.jpg', base64_decode($car_photo));
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
?>