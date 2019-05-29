<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $stationID = $_POST['stationID'];
    $licenseNo = $_POST['licenseNo'];
    $owner = $_POST['owner'];

    if (strlen($stationID) == 0 || $stationID == 0) {
        echo "stationID required";
        exit;
    }

    if (strlen($licenseNo) == 0) {
        echo "licenseNo required";
        exit;
    }

    if (strlen($owner) == 0) {
        echo "owner required";
        exit;
    }

    require_once('../../credentials.php');
    $conn = connectFSDatabase();

    $sqlVerify = "SELECT * FROM stations WHERE id = '" . $stationID . "' AND isActive='1'";
    $result = $conn->query($sqlVerify);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['isVerified'] == 1) {
                echo "Station verified already";
                exit;
            }
        }
    }

    $sql = "UPDATE stations SET";

    if (strlen($licenseNo) > 0) {
        $var0 = " licenseNo='$licenseNo',";
        $sql = $sql . $var0;
    }

    if (strlen($owner) > 0) {
        $var1 = " owner='$owner',";
        $sql = $sql . $var1;
    }

    if ($sql == "UPDATE stations SET") {
        echo "At least 1 optional parameter required.";
        exit;
    } else {
        $dummy = substr($sql, -1);
        if (strcmp($dummy, ',') == 0) {
            $sql = substr_replace($sql, '', -1);
        }

        $sql = $sql . " WHERE id= '" . $stationID . "'";

        if ($conn->query($sql) === TRUE) {
            echo "Success";
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}