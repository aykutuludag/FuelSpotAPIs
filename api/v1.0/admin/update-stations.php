<?php
function updateStation()
{
    global $conn;
    global $gasolinePrice;
    global $dieselPrice;
    global $gasolinePrice2;
    global $dieselPrice2;
    global $stationID;
    global $LPGPrice;
    global $elecPrice;
    global $EPDK;
    global $conn;
    global $stationName;
    global $stationCountry;
    
    $sql = "UPDATE stations SET";
    
    $var = " gasolinePrice='$gasolinePrice',";
    $sql = $sql . $var;
    
    $var2 = " dieselPrice='$dieselPrice',";
    $sql  = $sql . $var2;
    
    $otherFuels = '[{"gasoline2":"' . $gasolinePrice2 . '","diesel2":"' . $dieselPrice2 . '"}]';

    $var3 = " otherFuels='$otherFuels'";
    $sql  = $sql . $var3;
    
    $sql = $sql . " WHERE id= '" . $stationID . "'";

   if ($conn->query($sql) === TRUE) {
        echo 'BAŞARILI: ' . $stationID . '<br>';
        if ($gasolinePrice != 0 || $dieselPrice != 0 || $LPGPrice != 0 || $elecPrice != 0 || $gasolinePrice2 != 0 || $dieselPrice2 != 0) {
            $query0  = "SELECT * FROM finance WHERE stationID = '" . $stationID . "' ORDER BY date DESC LIMIT 1";
            $result0 = $conn->query($query0);
            if (mysqli_num_rows($result0) > 0) {
                $row = mysqli_fetch_assoc($result0);
                if ($row["gasolinePrice"] != $gasolinePrice || $row["dieselPrice"] != $dieselPrice || $row["lpgPrice"] != $LPGPrice || $row["electricityPrice"] != $elecPrice || $row["gasolinePrice2"] != $gasolinePrice2 || $row["dieselPrice2"] != $dieselPrice2) {
                    $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice,gasolinePrice2,dieselPrice2,provider) VALUES('$stationID', '$stationName', '$stationCountry', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice', '$gasolinePrice2', '$dieselPrice2', 'FuelBot')";
                    mysqli_query($conn, $sql2);
                }
            } else {
                // No record found. Add it.
                $sql2 = "INSERT INTO finance(stationID,stationName,country,gasolinePrice,dieselPrice,lpgPrice,electricityPrice,gasolinePrice2,dieselPrice2,provider) VALUES('$stationID', '$stationName', '$stationCountry', '$gasolinePrice', '$dieselPrice', '$LPGPrice', '$elecPrice', '$gasolinePrice2', '$dieselPrice2', 'FuelBot')";
                mysqli_query($conn, $sql2);
            }
        }
    } else {
		echo mysqli_error($conn);
        echo 'HATA: ' . $EPDK . '<br>';
    }
}

function findStation()
{
    global $conn;
    global $EPDK;
    global $stationID;
    global $stationName;
    global $stationCountry;
    global $LPGPrice;
    global $elecPrice;
    
    $sql    = "SELECT * FROM stations WHERE licenseNo = '" . $EPDK . "'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        $row            = mysqli_fetch_assoc($result);
        $stationID      = $row["id"];
        $stationName    = $row["name"];
        $stationCountry = $row["country"];
        $LPGPrice       = $row["lpgPrice"];
        $elecPrice      = $row["electricityPrice"];
        updateStation();
    } else {
        echo 'İSTASYON BULUNAMADI:' . $EPDK . '<br>';
    }
}

function controlPrices()
{
    global $EPDK;
    global $gasolinePrice;
    global $dieselPrice;
    global $gasolinePrice2;
    global $dieselPrice2;
    
    if ($gasolinePrice <= 6.00 || $gasolinePrice >= 8.00) {
        $gasolinePrice = 0.00;
    }
    
    if ($gasolinePrice2 < 6.00 || $gasolinePrice2 > 8.00) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice < 5.50 || $dieselPrice > 7.00) {
        $dieselPrice = 0.00;
    }
    
    if ($dieselPrice2 < 5.50 || $dieselPrice2 > 7.00) {
        $dieselPrice2 = 0.00;
    }
    
    if ($gasolinePrice == $gasolinePrice2) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice == $dieselPrice2) {
        $dieselPrice2 = 0.00;
    }
    
    if ($gasolinePrice < $gasolinePrice2) {
        $dummyBigger    = $gasolinePrice2;
        $gasolinePrice2 = $gasolinePrice;
        $gasolinePrice  = $dummyBigger;
    }
    
    if ($dieselPrice < $dieselPrice2) {
        $dummyBigger2 = $dieselPrice2;
        $dieselPrice2 = $dieselPrice;
        $dieselPrice  = $dummyBigger2;
    }
	
	$gasolinePrice = number_format($gasolinePrice, 2);
	$dieselPrice = number_format($dieselPrice, 2);
	$gasolinePrice2 = number_format($gasolinePrice2, 2);
	$dieselPrice2 = number_format($dieselPrice2, 2);
    
    if ($gasolinePrice != 0 || $dieselPrice != 0 || $gasolinePrice2 != 0 || $dieselPrice2 != 0) {
        findStation();
    } else {
        echo 'FİYAT YOK: ' . $EPDK . '<br>';
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');
    
    // Pre-defined values
    $stationID      = 0;
    $stationName    = "";
    $stationCountry = "TR"; // Default
    $EPDK           = "";
    $gasolinePrice  = 0.00;
    $dieselPrice    = 0.00;
    $gasolinePrice2 = 0.00;
    $dieselPrice2   = 0.00;
    $LPGPrice       = 0.00;
    $elecPrice      = 0.00;
    
    setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'tr', 'turkish');
    $opts = array(
        'http' => array(
            'header' => "User-Agent:MyAgent/1.0\r\n"
        )
    );
    
    require_once('../../credentials.php');
    $conn = connectFSDatabase();
    
    // Parameters
    $il      = $_POST['IL'];
    $ilce    = $_POST['ILCE'];
    $captcha = $_POST['CAPTCHA'];
    
    if (strlen($il) == 0) {
        echo "IL required";
        exit;
    }
    
    if (strlen($ilce) == 0) {
        echo "ILCE required";
        exit;
    }
    
    if (strlen($captcha) == 0) {
        echo "CAPTCHA required";
        exit;
    }
    
    $context     = stream_context_create($opts);
    $requestURL  = 'http://epdk.gov.tr/Detay/PompaFiyatlari?ddlIl=' . $il . '&ddlIlce=' . $ilce . '&txtCaptcha=' . $captcha;
    $content     = file_get_contents($requestURL, false, $context);
    $first_step  = explode('<tbody>', $content);
    $second_step = explode("</tbody>", $first_step[1]);
    
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $dom->loadHTML($second_step[0]);
    $rows = $dom->getElementsByTagName('tr');
    
    for ($i = 0; $i < $rows->length; $i++) {
        $veriler = $rows->item($i)->getElementsbyTagName("td");
        
        $tempEPDK = $veriler->item(0)->nodeValue;
        $dummy    = explode(')', $tempEPDK);
        $dummy2   = explode("(", strtoupper($dummy[0]));
        $EPDK     = $dummy2[1];
        
        $dummyBenzin = $veriler->item(1)->nodeValue;
        if (strlen($dummyBenzin) > 0) {
            $gasolinePrice = $dummyBenzin;
        }
        
        $dummyDizel = $veriler->item(2)->nodeValue;
        if (strlen($dummyDizel) > 0) {
            $dieselPrice = $dummyDizel;
        }
        
        $dummyBenzin2 = $veriler->item(3)->nodeValue;
        if (strlen($dummyBenzin2) > 0) {
            $gasolinePrice2 = $dummyBenzin2;
        }
        
        $dummyDizel2 = $veriler->item(4)->nodeValue;
        if (strlen($dummyDizel2) > 0) {
            $dieselPrice2 = $dummyDizel2;
        }
        
        controlPrices();
    }
}