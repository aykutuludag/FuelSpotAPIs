<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    // Parameters
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $photo = $_POST['photo'];
    $deviceType = $_POST['deviceType'];
    $tempArray = [];
    $outPutArray = [];

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }

    if (strlen($name) == 0) {
        echo "name required";
        exit;
    }

    if (strlen($email) == 0) {
        echo "email required";
        exit;
    }

    if (strlen($deviceType) == 0) {
        echo "deviceType required";
        exit;
    }

    require_once('../../credentials.php');
    $conn = connectFSDatabase();

    // Remove special chars
    $name = mysqli_real_escape_string($conn, $name);
    $username = mysqli_real_escape_string($conn, $username);

    $queryCheckEmail = "SELECT * FROM superusers WHERE email = '" . $email . "'";
    $result0 = $conn->query($queryCheckEmail);

    // email does exist. Logged in.
    if (mysqli_num_rows($result0) > 0) {
        while ($row = mysqli_fetch_assoc($result0)) {
            $tempArray[] = $row;
        }
        include('../../token-creator.php');
        $outPutArray[] = array_merge($tempArray[0], array("token" => $jwt));
        echo json_encode($outPutArray);
    } else {
        $queryUserName = "SELECT * FROM superusers WHERE username = '" . $username . "'";
        $result1 = $conn->query($queryUserName);

        // username exist. Create random number and add to username
        if (mysqli_num_rows($result1) > 0) {
            $randomInt = mt_rand(1,999);
            $username = $username . $randomInt;
            $queryCreateUser = "INSERT INTO superusers(username,name,email,photo) VALUES ('$username','$name','$email','$photo')";

            // User created
            if (mysqli_query($conn, $queryCreateUser)) {
                $fResult = $conn->query($queryCheckEmail);
                if (mysqli_num_rows($fResult) > 0) {
                    while ($row = mysqli_fetch_assoc($fResult)) {
                        $tempArray[] = $row;
                    }
                    include('../../token-creator.php');
                    $outPutArray[] = array_merge($tempArray[0], array("token" => $jwt));
                    echo json_encode($outPutArray);
                }
            }
        }
    }
    mysqli_close($conn);
}