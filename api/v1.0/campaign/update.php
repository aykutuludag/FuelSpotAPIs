<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');
    
    // Parameters
    $campaignID    = $_POST['campaignID'];
    $stationID     = $_POST['stationID'];
    $campaignName  = $_POST['campaignName'];
    $campaignDesc  = $_POST['campaignDesc'];
    $campaignStart = $_POST['campaignStart'];
    $campaignEnd   = $_POST['campaignEnd'];
    $campaignPhoto = $_POST['campaignPhoto'];
    
    if (strlen($campaignID) == 0 || $campaignID == 0) {
        echo "campaignID required";
        exit;
    }
    
    require_once('../../credentials.php');
    $conn = connectFSDatabase();
    
    $campaignName = mysqli_real_escape_string($conn, $campaignName);
    $campaignDesc = mysqli_real_escape_string($conn, $campaignDesc);
    
    $sql = "UPDATE campaigns SET";
    
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
        $dummy 		= str_replace(' ', '-', $campaignName);
        $fName      = preg_replace('/[^A-Za-z0-9\-\']/', '', $dummy)
		
        $actualpath = 'https://fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $fName . '.jpg';
        
        $var5 = " campaignPhoto='$actualpath',";
        $sql  = $sql . $var5;
        
        file_put_contents('/home/u8276450/fuelspot.com.tr/uploads/campaigns/' . $stationID . '-' . $fName . '.jpg', base64_decode($campaignPhoto));
    }
    
    if ($sql == "UPDATE campaigns SET") {
        echo "At least 1 optional parameter required.";
        exit;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }
        
        $sql = $sql . " WHERE id= '" . $campaignID . "'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
    
    function seo_friendly_url($string)
    {
        $string = str_replace(array(
            '[\', \']'
        ), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array(
            '/[^a-z0-9]/i',
            '/[-]+/'
        ), '-', $string);
        return strtolower(trim($string, '-'));
    }
}