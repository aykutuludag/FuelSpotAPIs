<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $comment = $_POST['comment'];
    $station_id = $_POST['stationID'];
    $username = $_POST['username'];
    $userStars = $_POST['stars'];
    $userKey = $_POST['AUTH_KEY'];
    $userphoto = $_POST['user_photo'];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($comment) == 0) {
        echo "comment required";
        return;
    }

    if (strlen($station_id) == 0 || $station_id == 0) {
        echo "stationID required";
        return;
    }

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

    if (strlen($userStars) == 0) {
        echo "stars required";
        return;
    }

    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO comments(comment,station_id,username,user_photo,stars) VALUES('$comment', '$station_id', '$username', '$userphoto', '$userStars')";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}
