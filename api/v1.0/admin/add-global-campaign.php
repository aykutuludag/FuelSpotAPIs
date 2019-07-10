<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
	$companyName     = $_POST['companyName'];
    $campaignName  = $_POST['campaignName'];
    $campaignDesc  = $_POST['campaignDesc'];
    $campaignStart = $_POST['campaignStart'];
    $campaignEnd   = $_POST['campaignEnd'];
	$campaignPhoto = $_POST['campaignPhoto'];
	
	if (strlen($companyName) == 0) {
        echo "companyName required";
        exit;
    }
	
	if (strlen($campaignName) == 0) {
        echo "campaignName required";
        exit;
    }
	
	if (strlen($campaignDesc) == 0) {
        echo "campaignDesc required";
        exit;
    }
	
	if (strlen($campaignStart) == 0) {
        echo "campaignStart required";
        exit;
    }
	
	if (strlen($campaignEnd) == 0) {
        echo "campaignEnd required";
        exit;
    }
	
	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $campaignName = mysqli_real_escape_string($conn, $campaignName);
    $campaignDesc = mysqli_real_escape_string($conn, $campaignDesc);
	
    if ($campaignPhoto != null) {
        $actualpath = 'https://fuelspot.com.tr/uploads/campaigns/global/' . $companyName . '-' . $campaignName . '.jpg';
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/campaigns/global/' . $companyName . '-' . $campaignName . '.jpg', base64_decode($campaignPhoto));
		$sql  = "INSERT INTO campaigns_global(companyName,campaignName,campaignDesc,campaignPhoto,campaignStart,campaignEnd) VALUES('$companyName', '$campaignName', '$campaignDesc', '$actualpath', '$campaignStart', '$campaignEnd')";
    } else {
		$sql  = "INSERT INTO campaigns_global(companyName,campaignName,campaignDesc,campaignStart,campaignEnd) VALUES('$companyName', '$campaignName', '$campaignDesc', '$campaignStart', '$campaignEnd')";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
