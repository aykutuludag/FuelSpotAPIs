<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $photo = $_POST['photo'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $location = $_POST['location'];
    $country = $_POST['country'];
    $language = $_POST['language'];

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }

    if (strlen($password) == 0) {
        echo "password required";
        exit;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();
	$sql  = "UPDATE admins SET";

    if (strlen($name) > 0) {
        $var1 = " name='$name',";
        $sql = $sql . $var1;
    }

    if (strlen($email) > 0) {
        $var2 = " email='$email',";
        $sql = $sql . $var2;
    }

    if (strlen($password) > 0) {
        $var3 = " password='$password',";
        $sql = $sql . $var3;
    }

    if (strlen($phoneNumber) > 0) {
        $var4 = " phoneNumber='$phoneNumber',";
        $sql = $sql . $var4;
    }

    if (strlen($photo) > 0) {
        $actualpath = 'https://fuelspot.com.tr/uploads/admins/' . $username . '.jpg';

        $var5 = " photo='$actualpath',";
        $sql = $sql . $var5;
    }

    if (strlen($gender) > 0) {
        $var5 = " gender='$gender',";
        $sql = $sql . $var5;
    }

    if (strlen($birthday) > 0) {
        $var6 = " birthday='$birthday',";
        $sql = $sql . $var6;
    }

    if (strlen($location) > 0) {
        $var7 = " location='$location',";
        $sql = $sql . $var7;
    }

    if (strlen($country) > 0) {
        $var8 = " country='$country',";
        $sql = $sql . $var8;
    }

    if (strlen($language) > 0) {
        $var9 = " language='$language',";
        $sql = $sql . $var9;
    }

    if ($sql == "UPDATE admins SET") {
        echo "At least 1 optional parameter required.";
        exit;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }

        $sql = $sql . " WHERE username= '" . $username . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
            file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/admins/' . $username . '.jpg', base64_decode($photo));
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}
