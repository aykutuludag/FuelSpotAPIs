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

function recordMismatch($stationID, $sName, $distName, $EPDK)
{
    global $conn;
    global $distName;
    global $EPDK;
    global $stationID;
    
    $sql3 = "INSERT INTO brand_mismatches(stationID,currentBrand,newBrand,epdkNO) VALUES('$stationID', '$sName', '$distName', '$EPDK')";
    mysqli_query($conn, $sql3);
}

function recordMissingLicense($distName, $EPDK, $il, $ilce)
{
    global $conn;
    global $distName;
    global $EPDK;
    
    $sql3 = "INSERT INTO missing_licenses(licenseNo,distributorName, il, ilce) VALUES('$EPDK', '$distName', '$il', '$ilce')";
    mysqli_query($conn, $sql3);
}

function insertCompany($distName)
{
    global $conn;
    global $distName;
    
    $sql4 = "INSERT INTO companies(companyName, companyTitle) VALUES('$distName', '$distName')";
    mysqli_query($conn, $sql4);
}

function controlName($sName, $stationID, $distName)
{
    global $distName;
    global $EPDK;
    global $stationID;
    
    $Kita7        = "7KITA PETROLCÜLÜK DAĞITIM VE PAZARLAMA ANONİM ŞİRKETİ";
    $Alpet        = "ALTINBAŞ PETROL VE TİCARET ANONİM ŞİRKETİ";
    $Aytemiz      = "AYTEMİZ AKARYAKIT DAĞITIM ANONİM ŞİRKETİ";
    $Best         = "KALELİ BEST OİL PETROLCÜLÜK TİCARET ANONİM ŞİRKETİ";
    $BP           = "BP PETROLLERİ ANONİM ŞİRKETİ";
    $Bpet         = "BALPET PETROL ÜRÜNLERİ TAŞIMACILIK SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Cekoil       = "DOĞAL KAYNAKLAR AKARYAKIT DAĞITIM VE GAZ İŞLETMELERİ SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Das          = "MFD AKARYAKIT NAKLİYAT TURİZM İNŞAAT TAŞIMACILIK SANAYİ VE TİCARET LTD ŞTİ";
    $Ecoxpet      = "ECOPET AKARYAKIT ÜRÜNLERİ DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Energy       = "ENERJİ PETROL ÜRÜNLERİ PAZARLAMA ANONİM ŞİRKETİ";
    $Enkoil       = "ENKO PETROLCÜLÜK NAKLİYE İNŞAAT TURİZM GIDA SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Euroil       = "EUROİL ENERJİ DAĞITIM A.Ş.";
    $Eva          = "KRC AKARYAKIT DAĞITIM DIŞ TİCARET ANONİM ŞİRKETİ";
    $GO           = "İPRA ENERJİ ANONİM ŞİRKETİ";
    $Goldoil      = "AS GOLDOİL AKARYAKIT DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Gulf         = "DELTA AKARYAKIT TİCARET ANONİM ŞİRKETİ";
    $Hemoil       = "HEMA AKARYAKIT DAĞITIM ULUSLARARASI NAKLİYE İNŞAAT GIDA İTHALAT İHRACAT SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Hypco        = "HYPCO PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Kadoil       = "KADOOĞLU PETROLCÜLÜK TAŞIMACILIK TİCARET SANAYİ İTHALAT VE İHRACAT ANONİM ŞİRKETİ";
    $Kpet         = "KENTOİL AKARYAKIT ÜRÜNLERİ SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Lionpet      = "LION PET LPG ÜRÜNLERİ DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Lukoil       = "AKPET AKARYAKIT DAĞITIM ANONİM ŞİRKETİ";
    $Maspet       = "MAS PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Memoil       = "MEMOİL AKARYAKIT DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Moil         = "GÜZEL ENERJİ AKARYAKIT ANONİM ŞİRKETİ";
    $Mola         = "MOLAVER AKARYAKIT DAĞITIM TAŞIMACILIK İNŞAAT İTHALAT İHRACAT SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Nasoil       = "NASOİL AKARYAKIT DAĞITIM TAŞIMACILIK SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Netoil       = "MAVİ GÖK-DENİZ AKARYAKIT DAĞITIM İTHALAT İHRACAT SANAYİ VE TİCARET LİMİTED ŞİRKETİ";
    $Opet         = "OPET PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Pacific      = "PASİFİK PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Petline      = "PETLİNE PETROL ÜRÜNLERİ TİCARET ANONİM ŞİRKETİ";
    $Petrol_Ofisi = "PETROL OFİSİ ANONİM ŞİRKETİ";
    $Remoil       = "RMG PETROL ÜRÜNLERİ DAĞITIM SANAYİ ANONİM ŞİRKETİ";
    $Qplus        = "VTM AKARYAKIT PETROL ÜRÜNLERİ DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Sanoil       = "RPET PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Seypet       = "SRF PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Shell        = "SHELL & TURCAS PETROL ANONİM ŞİRKETİ";
    $S_Oil        = "SİYAM PETROLCÜLÜK SANAYİ VE TİC. A.Ş .(S OIL)";
    $Teco         = "TECO PETROLCÜLÜK SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $Termo        = "TERMOPET AKARYAKIT ANONİM ŞİRKETİ";
    $Total        = "GÜZEL ENERJİ AKARYAKIT ANONİM ŞİRKETİ";
    $TP           = "TP PETROL DAĞITIM ANONİM ŞİRKETİ";
    $Turkis       = "SOFTOİL AKARYAKIT ÜRÜNLERİ SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    $United       = "BİRLEŞİK PETROL ANONİM ŞİRKETİ";
    $Welloil      = "ÇLB PETROLCÜLÜK ANONİM ŞİRKETİ";
    $Socar        = "SOCAR TURKEY PETROL ENERJİ DAĞITIM SANAYİ VE TİCARET ANONİM ŞİRKETİ";
    
    if ($sName === "7 Kıta") {
        if ($distName === $Kita7) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Alpet") {
        if ($distName === $Alpet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Aytemiz") {
        if ($distName === $Aytemiz) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Best") {
        if ($distName === $Best) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo 'MARKA UYUŞMAZLIĞI: ' . $EPDK . "<br>";
        }
    } else if ($sName === "Bpet") {
        if ($distName === $Bpet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "BP") {
        if ($distName === $BP) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Çekoil") {
        if ($distName === $Cekoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Das") {
        if ($distName === $Das) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Ecoxpet") {
        if ($distName === $Ecoxpet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Energy") {
        if ($distName === $Energy) {
            updateStation();
        } else {
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Enkoil") {
        if ($distName === $Enkoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Euroil") {
        if ($distName === $Euroil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Eva") {
        if ($distName === $Eva) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "GO") {
        if ($distName === $GO) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Goldoil") {
        if ($distName === $Goldoil) {
            updateStation();
        } else {
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Gulf") {
        if ($distName === $Gulf) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Hemoil") {
        if ($distName === $Hemoil) {
            updateStation();
        } else {
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Hypco") {
        if ($distName === $Hypco) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Kadoil") {
        if ($distName === $Kadoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "K-Pet") {
        if ($distName === $Kpet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Lionpet") {
        if ($distName === $Lionpet) {
            updateStation();
        } else {
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Lukoil") {
        if ($distName === $Lukoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Maspet") {
        if ($distName === $Maspet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Memoil") {
        if ($distName === $Memoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Moil") {
        if ($distName === $Moil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Mola") {
        if ($distName === $Mola) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Naspet") {
        if ($distName === $Nasoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Netoil") {
        if ($distName === $Netoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Opet" || $sName === "Sunpet") {
        if ($distName === $Opet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Pacific") {
        if ($distName === $Pacific) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Petline") {
        if ($distName === $Petline) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Petrol Ofisi") {
        if ($distName === $Petrol_Ofisi) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Remoil") {
        if ($distName === $Remoil) {
            updateStation();
        } else {
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Qplus") {
        if ($distName === $Qplus) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Sanoil") {
        if ($distName === $Sanoil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Seypet") {
        if ($distName === $Seypet) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Shell") {
        if ($distName === $Shell) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "S-Oil") {
        if ($distName === $S_Oil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Teco") {
        if ($distName === $Teco) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Termo") {
        if ($distName === $Termo) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Total") {
        if ($distName === $Total) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Türkiye Petrolleri") {
        if ($distName === $TP) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Türkiş") {
        if ($distName === $Turkis) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "United") {
        if ($distName === $United) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Welloil") {
        if ($distName === $Welloil) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else if ($sName === "Socar") {
        if ($distName === $Socar) {
            updateStation();
        } else {
            recordMismatch($stationID, $sName, $distName, $EPDK);
            echo "<b>MARKA UYUŞMAZLIĞI: " . $EPDK . "</b><br>";
        }
    } else {
        // MARKA SİSTEMDE KAYITLI DEĞİL
        echo 'BİLİNMEYEN MARKA: ' . $distName . " - ";
        //insertCompany($distName);
        updateStation();
    }
}

function controlLPGPrice($lpgFiyat)
{
    global $LPGPrice;
    
    // We accept 3.20 and give random arbitrage
    $LPGPrice = 3.20;
    $min      = 0.01;
    $max      = 0.50;
    // Random between 0.01 ₺ - 0.50 ₺ increase (09.09.2020)
    
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
    global $il;
    global $ilce;
	global $distName;
    
    $sql    = "SELECT * FROM stations WHERE licenseNo = '" . $EPDK . "'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        $row            = mysqli_fetch_assoc($result);
        $stationID      = $row["id"];
        $stationName    = $row["name"];
        $stationCountry = $row["country"];
        $LPGPrice       = $row["lpgPrice"];
        $elecPrice      = $row["electricityPrice"];
        
        if ($LPGPrice != 0.00 && $LPGPrice < 3.21) {
            controlLPGPrice($LPGPrice);
        }
        
        controlName($stationName, $stationID, $distName);
    } else {
        recordMissingLicense($EPDK, $distName, $il, $ilce);
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
    
    if ($gasolinePrice < 5.00 || $gasolinePrice >= 7.50) {
        $gasolinePrice = 0.00;
    }
    
    if ($gasolinePrice2 < 5.00 || $gasolinePrice2 >= 7.50) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice < 5.00 || $dieselPrice >= 7.50) {
        $dieselPrice = 0.00;
    }
    
    if ($dieselPrice2 < 5.00 || $dieselPrice2 >= 7.50) {
        $dieselPrice2 = 0.00;
    }
    
    if ($gasolinePrice === $gasolinePrice2) {
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice === $dieselPrice2) {
        $dieselPrice2 = 0.00;
    }
    
    if ($gasolinePrice == 0.00 && $gasolinePrice2 != 0) {
        $gasolinePrice  = $gasolinePrice2;
        $gasolinePrice2 = 0.00;
    }
    
    if ($dieselPrice == 0.00 && $dieselPrice2 != 0) {
        $dieselPrice  = $dieselPrice2;
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
        'https' => array(
            'method' => "GET",
            'header' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36\r\n"
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
    
    //if (strlen($ilce) == 0) {
    //    echo "ILCE required";
    //    exit;
    // }
    
    if (strlen($captcha) == 0) {
        echo "CAPTCHA required";
        exit;
    }
    
    $context     = stream_context_create($opts);
    $requestURL  = "https://www.epdk.gov.tr/Detay/PompaFiyatlari?ddlIl=" . $il . "&ddlIlce=" . $ilce . "&ddlDagitici=&txtBayi=&txtCaptcha=" . $captcha;
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
			$distName = str_replace("Ãœ", "Ü", $distName);
		
        } else {
            $distName = "";
        }
        
        controlPrices();
    }
    mysqli_close($conn);
}