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
	
    $var3 = " lpgPrice='$LPGPrice',";
    $sql  = $sql . $var3;	
    
    $otherFuels = '[{"gasoline2":"' . $gasolinePrice2 . '","diesel2":"' . $dieselPrice2 . '"}]';
    
    $var4 = " otherFuels='$otherFuels'";
    $sql  = $sql . $var4;
    
    $sql = $sql . " WHERE id= '" . $stationID . "'";
    
    if ($conn->query($sql) === TRUE) {
        echo 'BAŞARILI: ' . $stationID . "<br>";
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
        echo 'HATA: ' . $EPDK . "<br>";
    }
}

function controlName($sName)
{
    global $distName;
    global $EPDK;
    
    $Alpet        = "ALTINBAŞ PETROL VE TİCARET ANONİM ŞİRKETİ";
    $Aytemiz      = "AYTEMİZ AKARYAKIT DAĞITIM ANONİM ŞİRKETİ";
    $Best         = "KALELİ BEST OİL PETROLCÜLÜK TİCARET ANONİM ŞİRKETİ";
    $BP           = "BP PETROLLERİ ANONİM ŞİRKETİ";
    $Bpet         = "BALPET PETROL ÜRÜNLERİ TAŞIMACILIK SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Das          = "MFD AKARYAKIT NAKLİYAT TURİZM İNŞAAT TAŞIMACILIK SANAYİ VE TİCARET LİMİTED ŞİRKETİ";
    $Energy       = "ENERJİ PETROL ÜRÜNLERİ PAZARLAMA ANONİM ŞİRKETİ";
    $Euroil       = "EUROİL ENERJİ DAĞITIM ANONİM ŞİRKETİ";
    $GO           = "İPRA ENERJİ ANONİM ŞİRKETİ";
    $Gulf         = "DELTA AKARYAKIT TİCARET ANONİM ŞİRKETİ";
    $Hypco        = "HYPCO PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Kadoil       = "KADOOĞLU PETROLCÜLÜK TAŞIMACILIK TİCARET SANAYİ İTHALAT VE İHRACAT ANONİM ŞİRKETİ";
    $Kpet         = "KENTOİL AKARYAKIT ÜRÜNLERİ SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Lukoil       = "AKPET AKARYAKIT DAĞITIM ANONİM ŞİRKETİ";
    $Memoil       = "MEMOİL AKARYAKIT DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Moil         = "MİLAN PETROL SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Mola         = "MOLAVER AKARYAKIT DAĞITIM TAŞIMACILIK İNŞAAT İTHALAT İHRACAT SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Opet         = "OPET PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Pacific      = "PASİFİK PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Petline      = "PETLİNE PETROL ÜRÜNLERİ TİCARET ANONİM ŞİRKETİ";
    $Petrol_Ofisi = "PETROL OFİSİ ANONİM ŞİRKETİ";
    $Qplus        = "VTM AKARYAKIT PETROL ÜRÜNLERİ DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Sanoil       = "RPET PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Shell        = "SHELL & TURCAS PETROL ANONİM ŞİRKETİ";
    $S_Oil        = "SİYAM PETROLCÜLÜK SANAYİ VE TİC. A.Ş .(S OIL)";
    $Teco         = "TECO PETROLCÜLÜK SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Termo        = "TERMOPET AKARYAKIT NAKLİYAT VE TİCARET LİMİTED ŞİRKETİ";
    $Total        = "TOTAL OIL TÜRKİYE ANONİM ŞİRKETİ";
    $TP           = "TP PETROL DAĞITIM ANONİM ŞİRKETİ";
    
    if ($sName === "Alpet") {
        if ($distName === $Alpet) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Aytemiz") {
        if ($distName === $Aytemiz) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Best") {
        if ($distName === $Best) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Bpet") {
        if ($distName === $Bpet) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "BP") {
        if ($distName === $BP) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Das") {
        if ($distName === $Das) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Energy") {
        if ($distName === $Energy) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Euroil") {
        if ($distName === $Euroil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "GO") {
        if ($distName === $GO) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Gulf") {
        if ($distName === $Gulf) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Hypco") {
        if ($distName === $Hypco) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Kadoil") {
        if ($distName === $Kadoil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "K-Pet") {
        if ($distName === $Kpet) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Lukoil") {
        if ($distName === $Lukoil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Memoil") {
        if ($distName === $Memoil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Moil") {
        if ($distName === $Moil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Mola") {
        if ($distName === $Mola) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Opet" || $sName === "Sunpet") {
        if ($distName === $Opet) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Pacific") {
        if ($distName === $Pacific) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Petline") {
        if ($distName === $Petline) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Petrol Ofisi") {
        if ($distName === $Petrol_Ofisi) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Qplus") {
        if ($distName === $Qplus) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Sanoil") {
        if ($distName === $Sanoil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Shell") {
        if ($distName === $Shell) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "S-Oil") {
        if ($distName === $S_Oil) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Teco") {
        if ($distName === $Teco) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Termo") {
        if ($distName === $Termo) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Total") {
        if ($distName === $Total) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Türkiye Petrolleri") {
        if ($distName === $TP) {
            updateStation();
        } else {
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else {
        // MARKA SİSTEMDE KAYITLI DEĞİL
        echo 'BİLİNMEYEN MARKA: ' . $distName . " - ";
        updateStation();
    }
}

function arrangeLPGPrice($lpgFiyat)
{
    global $LPGPrice;
    
    // We accept 3.00 and and random arbitrage
    $LPGPrice = 3.00;
    $min      = 0.17;
    $max      = 0.49;
    // Random between 0.17 ₺ - 0.49 ₺ (23.10.2019)
    
    $decimals = 2;
    $divisor  = pow(10, $decimals);
    
    $fiyatMarji = mt_rand($min * $divisor, $max * $divisor) / $divisor;
    $LPGPrice   = $LPGPrice + $fiyatMarji;
    
    return number_format($LPGPrice, 2);
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
        
        if ($LPGPrice != 0.00 && $LPGPrice < 3.00) {
            arrangeLPGPrice($LPGPrice);
        }
        
        controlName($stationName);
    } else {
        echo 'İSTASYON BULUNAMADI:' . $EPDK . "<br>";
    }
}

function controlPrices()
{
    global $EPDK;
    global $gasolinePrice;
    global $dieselPrice;
    global $gasolinePrice2;
    global $dieselPrice2;
    
    if ($gasolinePrice < $gasolinePrice2) {
        $pahaliBenzin   = $gasolinePrice2;
        $gasolinePrice2 = $gasolinePrice;
        $gasolinePrice  = $pahaliBenzin;
    }
    
    if ($dieselPrice < $dieselPrice2) {
        $pahaliMazot  = $dieselPrice2;
        $dieselPrice2 = $dieselPrice;
        $dieselPrice  = $pahaliMazot;
    }
    
    if ($gasolinePrice < 6.25 || $gasolinePrice >= 7.30) {
        $gasolinePrice = 0.00;
    }
    
    if ($gasolinePrice2 < 6.25 || $gasolinePrice2 >= 7.25) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice < 5.50 || $dieselPrice >= 6.80) {
        $dieselPrice = 0.00;
    }
    
    if ($dieselPrice2 < 5.50 || $dieselPrice2 >= 6.75) {
        $dieselPrice2 = 0.00;
    }
    
    if ($gasolinePrice === $gasolinePrice2) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice === $dieselPrice2) {
        $dieselPrice2 = 0.00;
    }
	
	if ($gasolinePrice == 0.00 && $gasolinePrice2 != 0){
		$gasolinePrice = $gasolinePrice2;
		$gasolinePrice2 = 0.00;
	}
    
	if ($dieselPrice == 0.00 && $dieselPrice2 != 0){
		$dieselPrice = $dieselPrice2;
		$dieselPrice2 = 0.00;
	}
	
    $gasolinePrice  = number_format($gasolinePrice, 2);
    $dieselPrice    = number_format($dieselPrice, 2);
    $gasolinePrice2 = number_format($gasolinePrice2, 2);
    $dieselPrice2   = number_format($dieselPrice2, 2);
    
    if ($gasolinePrice != 0 || $dieselPrice != 0 || $gasolinePrice2 != 0 || $dieselPrice2 != 0) {
        findStation();
    } else {
        echo 'FİYAT YOK: ' . $EPDK . "<br>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');
    
    // Pre-defined values
    $stationID      = 0;
    $stationName    = "";
    $stationCountry = "TR"; // Default
    $EPDK           = "";
    $distName       = "";
    $gasolinePrice  = 0.00;
    $dieselPrice    = 0.00;
    $gasolinePrice2 = 0.00;
    $dieselPrice2   = 0.00;
    $LPGPrice       = 0.00;
    $elecPrice      = 0.00;
    
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
    
    echo $rows->length . ' İSTASYON BULUNDU.' . "<br>";
    
    for ($i = 0; $i < $rows->length; $i++) {
        $veriler = $rows->item($i)->getElementsbyTagName("td");
        
        $tempEPDK = $veriler->item(0)->nodeValue;
        $dummy    = explode(')', $tempEPDK);
        $dummy2   = explode("(", strtoupper($dummy[0]));
        $EPDK     = $dummy2[1];
        
        $dummyBenzin = $veriler->item(1)->nodeValue;
        if (strlen($dummyBenzin) > 0) {
            $gasolinePrice = $dummyBenzin;
        } else {
            $gasolinePrice = 0.00;
        }
        
        $dummyDizel = $veriler->item(2)->nodeValue;
        if (strlen($dummyDizel) > 0) {
            $dieselPrice = $dummyDizel;
        } else {
            $dieselPrice = 0.00;
        }
        
        $dummyBenzin2 = $veriler->item(3)->nodeValue;
        if (strlen($dummyBenzin2) > 0) {
            $gasolinePrice2 = $dummyBenzin2;
        } else {
            $gasolinePrice2 = 0.00;
        }
        
        $dummyDizel2 = $veriler->item(4)->nodeValue;
        if (strlen($dummyDizel2) > 0) {
            $dieselPrice2 = $dummyDizel2;
        } else {
            $dieselPrice2 = 0.00;
        }
        
        $dummyDist = $veriler->item(5)->nodeValue;
        if (strlen($dummyDist) > 0) {
            $distName = html_entity_decode($dummyDist);
            $distName = str_replace("Ä°", "İ", $distName);
            $distName = str_replace("Å", "Ş", $distName);
            $distName = str_replace("Ä", "Ğ", $distName);
        } else {
            $distName = "";
        }
        
        controlPrices();
    }
    mysqli_close($conn);
}