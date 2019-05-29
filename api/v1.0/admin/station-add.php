<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    include('../../token-validator.php');

    // Parameters
    $name = $_POST['name'];
    $vicinity = $_POST['vicinity'];
    $country = $_POST['country'];
    $location = $_POST['location'];
    $googleID = $_POST['googleID'];
    $logoURL = $_POST['logoURL'];
    $facilities = '[{"WC":"1","Market":"1","CarWash":"1","TireRepair":"0","Mechanic":"0","Restaurant":"0","ParkSpot":"0","ATM":"0","Motel":"0"}]'; // Just assign pre-assumed facilities. This behavior will be changed in the future.
    $outPutArray = [];

    if (strlen($name) == 0) {
        echo "name required";
        exit;
    }

    if (strlen($vicinity) == 0) {
        echo "vicinity required";
        exit;
    }

    if (strlen($country) == 0) {
        echo "country required";
        exit;
    }

    if (strlen($location) == 0) {
        echo "location required";
        exit;
    }

    if (strlen($googleID) != 27) {
        echo "googleID is null or corrupt";
        exit;
    }

    if (strlen($logoURL) == 0) {
        echo "logoURL required";
        exit;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $sql = "INSERT INTO stations(name,vicinity,country,location,googleID,facilities,logoURL) VALUES('$name', '$vicinity', '$country', '$location', '$googleID', '$facilities', '$logoURL')";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM stations WHERE googleID = '" . $googleID . "' AND isActive='1'";
    $result2 = $conn->query($sql2);

    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($outPutArray, $row);
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
