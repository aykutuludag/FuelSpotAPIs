<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $AUTH_KEY = 'Ph76g0MSZ2okeWQmShYDlXakjgjhbe';
    
    // Mandatory
    $username = $_POST['username'];
    $name     = $_POST['name'];
    $email = $_POST['email'];
    $userKey  = $_POST['AUTH_KEY'];
    
    // Optional
    $photo = $_POST['photo'];
    
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
    
    define('DB_USERNAME', 'u8276450_user');
    define('DB_PASSWORD', '^2c4C4@c)KSl');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'u8276450_fuelspot');
    
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $query0 = "SELECT * FROM superusers WHERE email = '" . $email . "'";
    $result0 = $conn->query($query0) or die(mysqli_connect_error());

    if (!empty($result0)) {
        if (mysqli_num_rows($result0) > 0) {
            // email exist. return it.
            while ($row = $result0->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
            echo json_encode($myArray);
        } else {
            echo "Error";
        }
    } else {
        // email does not exist. create and return it.
        $query1 = "INSERT INTO superusers(username,name,email,photo) VALUES ('$username','$name','$email','$photo')";
        $result1 = mysqli_query($conn, $query1);

        $result2 = $conn->query($query0) or die(mysqli_connect_error());

        if (!empty($result2)) {
            if (mysqli_num_rows($result2) > 0) {
                while ($row = $result2->fetch_array(MYSQL_ASSOC)) {
                    $myArray2[] = $row;
                }
                echo json_encode($myArray2);
            } else {
                echo "Error";
            }
        } else {
            echo "Error";
        }
    }
    mysqli_close($conn);
}
?>