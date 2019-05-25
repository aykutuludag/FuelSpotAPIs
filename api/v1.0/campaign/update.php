<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$AUTH_KEY  = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
	$campaignID     = $_POST['campaignID'];
	$stationID      = $_POST['stationID'];
	$campaignName  = $_POST['campaignName'];
    $campaignDesc  = $_POST['campaignDesc'];
    $campaignStart = $_POST['campaignStart'];
    $campaignEnd   = $_POST['campaignEnd'];
	$campaignPhoto = $_POST['campaignPhoto'];
	$userKey   = $_POST['AUTH_KEY'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }
	
	if (strlen($campaignID) == 0 || $campaignID == 0) {
        echo "campaignID required";
        return;
    }
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql  = "UPDATE campaigns SET";
    
	if (strlen($campaignName) > 0) {
        $var1 = " campaignName='$campaignName',";
        $sql  = $sql . $var1;
    }
	
    if (strlen($campaignDesc) > 0) {
        $var2 = " campaignDesc='$campaignDesc',";
        $sql  = $sql . $var2;
    }
	
    if (strlen($campaignStart) > 0) {
        $var3 = " campaignStart='$campaignStart',";
        $sql  = $sql . $var3;
    }
    
    if (strlen($campaignEnd) > 0) {
        $var4 = " campaignEnd='$campaignEnd',";
        $sql  = $sql . $var4;
    }
    
    if (strlen($campaignPhoto) > 0) {
        $actualpath = 'https://fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $campaignName . '.jpg';
		
        $var5 = " campaignPhoto='$actualpath',";
        $sql  = $sql . $var5;

        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $campaignName . '.jpg', base64_decode($campaignPhoto));
    }
	
    if ($sql == "UPDATE campaigns SET") {
        echo "At least 1 optional parameter required.";
        return;
    } else {
		$dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
          $sql=  substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $campaignID . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}