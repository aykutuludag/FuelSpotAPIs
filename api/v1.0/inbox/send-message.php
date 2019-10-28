<?php
function sendNotification($firebase_token)
{
    // Set POST variables
    $firebase_api = 'AAAAEzFQC08:APA91bHmQe1rwNULfKJSsojkmEoNCUbxyhQpOTQ4UUaSaWlPfgLbHhUHrrVqjXZEAZ8bgAo3RS52pd9OM6DsFDig_nI5I_xRg6ufhI67kjqAzg1Uw7KVt0oxiqNAR0Sgy9Kii2iGflsKnEy63-2pEig_BxfmxF5DFw';
    $titleBody    = array(
        'title' => 'FuelSpot',
        'body' => 'Mesajınız var!'
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
        die('Curl failed: ' . curl_error($ch));
    }
    
    // Close connection
    curl_close($ch);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');
    
    // Parameters
    $username       = $_POST['username'];
    $senderPhoto    = $_POST['senderPhoto'];
    $conversationID = $_POST['conversationID'];
    $receiver       = $_POST['receiver'];
    $receiverPhoto  = $_POST['receiverPhoto'];
    $topic          = $_POST['topic'];
    $message        = $_POST['message'];
    
    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }
    
    if (strlen($conversationID) == 0 || $conversationID == 0) {
        echo "conversationID required";
        exit;
    }
    
    if (strlen($receiver) == 0) {
        echo "receiver required";
        exit;
    }
    
    if (strlen($topic) == 0) {
        echo "topic required";
        exit;
    }
    
    require_once('../../credentials.php');
    $conn = connectFSDatabase();
    
    $topic   = mysqli_real_escape_string($conn, $topic);
    $message = mysqli_real_escape_string($conn, $message);
    
    $sql = "INSERT INTO inbox(conversationID,sender,senderPhoto,receiver,receiverPhoto,topic,message) VALUES ('$conversationID', '$username', '$senderPhoto', '$receiver', '$receiverPhoto', '$topic' , '$message')";
    
    if (mysqli_query($conn, $sql)) {
		echo "Success";
        // Send notification over firabase
        $sqlUser    = "SELECT * FROM users WHERE username = '" . $receiver . "'";
        $resultUser = $conn->query($sqlUser);
        
        if (mysqli_num_rows($resultUser) > 0) {
            while ($row2 = mysqli_fetch_assoc($resultUser)) {
                $token = $row2['token'];
            }
            if (strlen($token) > 0) {
                sendNotification($token);
            }
        }
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}