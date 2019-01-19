<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Mandatory
    $username  = $_POST['username'];
    $car_brand = $_POST['carBrand'];
    $car_model = $_POST['carModel'];
    $plate_no  = $_POST['plateNo'];
    $fuel_pri  = $_POST['fuelPri'];
    $car_km    = $_POST['kilometer'];
    $userKey   = $_POST['AUTH_KEY'];
    
    // Optional
    $fuel_sec  = $_POST['fuelSec'];
    $car_photo = $_POST['carPhoto'];
    
    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
    
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
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($car_photo != null) {
        $actualpath = 'https://fuel-spot.com/uploads/automobiles/' . $username . '-' . $plate_no . '.jpg';
        file_put_contents('/home/u8276450/fuel-spot.com/uploads/automobiles/' . $username . '-' . $plate_no . '.jpg', base64_decode($car_photo));
    } else {
		$actualpath = '';
    }
	
    $sql = "INSERT INTO automobiles(owner,car_brand,car_model,fuelPri,fuelSec,kilometer,carPhoto,plateNo) VALUES ('$username','$car_brand','$car_model','$fuel_pri','$fuel_sec','$car_km','$actualpath','$plate_no')";
    
    $result  = mysqli_query($conn, $sql);
    $last_id = $conn->insert_id;
    
    $sql2 = "SELECT * FROM automobiles WHERE id = '" . $last_id . "'";
    $result2 = $conn->query($sql2) or die(mysqli_connect_error());
    if (!empty($result2)) {
        // check for empty result
        if (mysqli_num_rows($result2) > 0) {
            while ($row = $result2->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode($myArray);
        }
    }
    mysqli_close($conn);
}
?>