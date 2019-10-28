<?php

function sendNotification($firebase_token)
{
    // Set POST variables
    $firebase_api = 'AAAAEzFQC08:APA91bHmQe1rwNULfKJSsojkmEoNCUbxyhQpOTQ4UUaSaWlPfgLbHhUHrrVqjXZEAZ8bgAo3RS52pd9OM6DsFDig_nI5I_xRg6ufhI67kjqAzg1Uw7KVt0oxiqNAR0Sgy9Kii2iGflsKnEy63-2pEig_BxfmxF5DFw';
    $titleBody    = array(
        'title' => 'FuelSpot',
        'body' => 'Bonus hesabınıza yansıtıldı!'
    );
    $fields       = array(
        'to' => $firebase_token,
        'notification' => $titleBody
    );
    $url          = 'https://fcm.googleapis.com/fcm/send';
    
    $headers = array(
        'Authorization: key=' . $firebase_api,
        'Content-Type: application/json'
    );
    
    // Open connection
    $ch = curl_init();
    
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Disabling SSL Certificate support temporarily
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        echo "Bonus eklendi - Bildirim gönderilemedi";
        die('Curl failed: ' . curl_error($ch));
    }
    
    // Close connection
    curl_close($ch);
    echo $result;
	echo 'Bonus eklendi' . ' - Bildirim gönderildi.';
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    include('../../token-validator.php');
    
    // Parameters
    $username    = $_POST['username'];
    $processType = $_POST['processType'];
    $currency    = $_POST['currency'];
    $country     = $_POST['country'];
    $amount      = $_POST['amount'];
    $notes       = $_POST['notes'];
    
    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }
    
    if (strlen($processType) == 0) {
        echo "processType required";
        exit;
    }
    
    if (strlen($currency) == 0) {
        echo "currency required";
        exit;
    }
    
    if (strlen($country) == 0) {
        echo "country required";
        exit;
    }
    
    if (strlen($amount) == 0) {
        echo "amount required";
        exit;
    }
    
    if (strlen($notes) == 0) {
        echo "notes required";
        exit;
    }
    
    require_once('../../credentials.php');
    $conn = connectFSDatabase();
    
    $address = mysqli_real_escape_string($conn, $address);
    
    $sql    = "SELECT * FROM banking WHERE username = '" . $username . "' ORDER BY time DESC LIMIT 0, 1";
    $result = $conn->query($sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $previous_balance = $row['current_balance'];
            $new_balance      = $previous_balance + $amount;
        }
        
        $sql2 = "INSERT INTO banking(username,processType,currency,country,amount,previous_balance,current_balance,notes) VALUES('$username', '$processType', '$currency', '$country', '$amount', '$previous_balance', '$new_balance', '$notes')";
        
        if (mysqli_query($conn, $sql2)) {
            // Send notification over firabase
            $sqlUser    = "SELECT * FROM users WHERE username = '" . $username . "'";
            $resultUser = $conn->query($sqlUser);
            
            if (mysqli_num_rows($resultUser) > 0) {
                while ($row2 = mysqli_fetch_assoc($resultUser)) {
                    $token = $row2['token'];
                }
                if (strlen($token) > 0) {
                    sendNotification($token);
                } else {
                    echo 'Bonus eklendi' . ' - Bildirim gönderilemedi.';
                }
            } else {
                echo "Fail";
            }
        } else {
            echo "Fail";
        }
    } else {
        $sqlNew = "INSERT INTO banking(username,processType,currency,country,amount,previous_balance,current_balance,notes) VALUES('$username', '$processType', '$currency', '$country', '$amount', '0.00', '$amount', '$notes')";
        
        if (mysqli_query($conn, $sqlNew)) {
            // Send notification over firabase
            $sqlUser    = "SELECT * FROM users WHERE username = '" . $username . "'";
            $resultUser = $conn->query($sqlUser);
            
            if (mysqli_num_rows($resultUser) > 0) {
                while ($row2 = mysqli_fetch_assoc($resultUser)) {
                    $token = $row2['token'];
                }
                if (strlen($token) > 0) {
                    sendNotification($token);
                } else {
                    echo 'Bonus eklendi - Bildirim gönderilemedi.';
                }
            } else {
                echo "Fail";
            }
        } else {
            echo "Fail";
        }
    }
    mysqli_close($conn);
}