<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $userKey = $_POST['AUTH_KEY'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $outPutArray = [];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

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
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}
