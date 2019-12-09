<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    // Parameters
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }

    if (strlen($password) == 0) {
        echo "password required";
        exit;
    }

    require_once('../../credentials.php');
    $conn = connectFSDatabase();

    // Remove special chars
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $isCorrect = "SELECT username, name, logo, email FROM distributors WHERE username = '" . $username . "' AND password= '" . $password . "'";
    $result0 = $conn->query($isCorrect);

    // email does exist. Logged in.
    if (mysqli_num_rows($result0) > 0) {
        while ($row = mysqli_fetch_assoc($result0)) {
            $tempArray[] = $row;
        }
        include('../../token-creator.php');
        $outPutArray[] = array_merge($tempArray[0], array("token" => $jwt));
        echo json_encode($outPutArray);
    }
    mysqli_close($conn);
}