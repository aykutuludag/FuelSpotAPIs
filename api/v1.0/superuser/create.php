<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';

    // Parameters
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $photo = $_POST['photo'];
    $userKey = $_POST['AUTH_KEY'];
    $outPutArray = [];

    if (strlen($userKey) == 0 || $userKey != $AUTH_KEY) {
        echo "AuthError";
        return;
    }

    if (strlen($username) == 0) {
        echo "username required";
        return;
    }

    if (strlen($name) == 0) {
        echo "name required";
        return;
    }

    if (strlen($email) == 0) {
        echo "email required";
        return;
    }

	require_once('../../credentials.php');
	$conn = connectFSDatabase();

    $query0 = "SELECT * FROM superusers WHERE email = '" . $email . "'";
    $result0 = $conn->query($query0);

    if (mysqli_num_rows($result0) > 0) {
        // email does exist. Return it.
        while ($row = mysqli_fetch_assoc($result0)) {
            $outPutArray[] = $row;
        }
        echo json_encode($outPutArray);
    } else {
        // email does not exist. create and return it.
		// BU NOKTADA username kontrolü yapılmalı. username var ise username1 yapılıp eklenecek.
        $query1 = "INSERT INTO superusers(username,name,email,photo) VALUES ('$username','$name','$email','$photo')";
        if (mysqli_query($conn, $query1)) {
            $fResult = $conn->query($query0);
            if (mysqli_num_rows($fResult) > 0) {
                while ($row = mysqli_fetch_assoc($fResult)) {
                    $outPutArray[] = $row;
                }
                echo json_encode($outPutArray);
            }
        }
    }
    mysqli_close($conn);
}