<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $id            = $_POST['purchaseID'];
	$username      = $_POST['username'];
	$plateNO         = $_POST['plateNO'];
	$billPhoto   = $_POST['billPhoto'];

	if (strlen($id) == 0 || $id == 0) {
        echo "purchaseID required";
        exit;
    }
	
	if (strlen($username) == 0) {
        echo "username required";
        exit;
    }
	
	if (strlen($plateNO) == 0) {
        echo "plateNO required";
        exit;
    }
	
	if (strlen($billPhoto) == 0) {
        echo "billPhoto required";
        exit;
    }
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    
    if (strlen($billPhoto) > 0) {
		$timeStamp = time() . '.jpg';
        $actualpath = 'https://fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp;
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/bills/' . $username . '-' . $plateNO . '-' . $timeStamp, base64_decode($billPhoto));
		
		$sql = "UPDATE purchases SET billPhoto = '$actualpath' WHERE id= '" . $id . "'";
		
		if ($conn->query($sql) === TRUE) {
			echo "Success";
		} else {
			echo "Fail";
		}
    }
    mysqli_close($conn);
}