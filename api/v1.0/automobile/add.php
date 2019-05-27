<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
    $car_brand = $_POST['carBrand'];
    $car_model = $_POST['carModel'];
    $plate_no = $_POST['plateNo'];
    $fuel_pri = $_POST['fuelPri'];
    $car_km = $_POST['kilometer'];

    // Optional
    $fuel_sec = $_POST['fuelSec'];
    $car_photo = $_POST['carPhoto'];

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

    if (strlen($car_brand) == 0) {
        echo "carBrand required";
        return;
    }

    if (strlen($car_model) == 0) {
        echo "carModel required";
        return;
    }

    if (strlen($plate_no) == 0) {
        echo "plateNo required";
        return;
    }

    if (strlen($fuel_pri) == 0 || $fuel_pri == -1) {
        echo "fuelPri required";
        return;
    }

    if (strlen($car_km) == 0) {
        echo "kilometer required";
        return;
    }

    if ($car_photo != null) {
        $actualpath = 'https://fuelspot.com.tr/uploads/automobiles/' . $username . '-' . $plate_no . '.jpg';
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/automobiles/' . $username . '-' . $plate_no . '.jpg', base64_decode($car_photo));
    } else {
        $actualpath = '';
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    // Check plateNo exist
    $sql_plate = "SELECT * FROM automobiles WHERE plateNo = '" . $plate_no . "'";
    $result_plate = $conn->query($sql_plate);
    if (mysqli_num_rows($result_plate) > 0) {
        echo "plateNo exist";
        return;
    }

    // Insert automobile
    $sql = "INSERT INTO automobiles(owner,car_brand,car_model,fuelPri,fuelSec,kilometer,carPhoto,plateNo) VALUES ('$username','$car_brand','$car_model','$fuel_pri','$fuel_sec','$car_km','$actualpath','$plate_no')";
    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}