<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
	
	// Mandatory
    $username  = $_POST['username'];
	$userKey   = $_POST['AUTH_KEY'];
	
	// Optional but at least one required.
	$name     = $_POST['name'];
    $email    = $_POST['email'];
	$photo = $_POST['photo'];
    $gender   = $_POST['gender'];
    $birthday = $_POST['birthday'];
	$phoneNumber = $_POST['phoneNumber'];
    $location = $_POST['location'];
	$country = $_POST['country'];
	$language = $_POST['language'];
	$vehicles = $_POST['vehicles'];
	$favStations = $_POST['favStations'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($username) == 0) {
        echo "username required";
        return;
    }
	
	define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql  = "UPDATE users SET";
    
	if (strlen($name) > 0) {
        $var1 = " name= '$name',";
        $sql  = $sql . $var1;
    }
	
    if (strlen($email) > 0) {
        $var2 = " email= '$email',";
        $sql  = $sql . $var2;
    }
	
	if (strlen($phoneNumber) > 0) {
        $var3 = " phoneNumber='$phoneNumber',";
        $sql  = $sql . $var3;
    }
	
    if (strlen($photo) > 0) {
		$actualpath       = 'https://fuel-spot.com/uploads/users/' . $username . '.jpg';

        $var4 = " photo = '$actualpath',";
        $sql  = $sql . $var4;
		
		file_put_contents('/home/u8276450/fuel-spot.com/uploads/users/' . $username . '.jpg', base64_decode($photo));
    }
    
    if (strlen($gender) > 0) {
        $var5 = " gender= '$gender',";
        $sql  = $sql . $var5;
    }
    
    if (strlen($birthday) > 0) {
        $var6 = " birthday = '$birthday',";
        $sql  = $sql . $var6;
    }
	
    if (strlen($location) > 0) {
        $var7 = " location = '$location',";
        $sql  = $sql . $var7;
    }
    
    if (strlen($country) > 0) {
        $var8 = " country='$country',";
        $sql  = $sql . $var8;
    }
    
    if (strlen($language) > 0) {
        $var9 = " language='$language',";
        $sql  = $sql . $var9;
    }
	
    if (strlen($vehicles) > 0) {
        $var10 = " vehicles='$vehicles',";
        $sql  = $sql . $var10;
    }
	
	if (strlen($favStations) > 0) {
        $var11 = " favStations='$favStations',";
        $sql  = $sql . $var11;
    }
	
    if ($sql == "UPDATE users SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
		$dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
          $sql=  substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE username= '" . $username . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}
?>