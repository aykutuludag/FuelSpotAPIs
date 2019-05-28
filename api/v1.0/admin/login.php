<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    // Parameters
    $username = $_POST['username'];
    $password = $_POST['password'];
	$deviceType = $_POST['deviceType'];
    $tempArray = [];
    $outPutArray = [];

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

    if (strlen($password) == 0) {
        echo "password required";
        return;
    }

 	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    $sql = "SELECT * FROM admins WHERE username = '" . $username . "' AND password = '" . $password . "' AND isVerified=1";

    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tempArray[] = $row;
        }
        include('../../token-creator.php');
        $outPutArray[] = array_merge($tempArray[0], array("token" => $jwt));
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
