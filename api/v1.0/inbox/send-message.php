<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../../token-validator.php');

    // Parameters
    $username = $_POST['username'];
	$senderPhoto = $_POST['senderPhoto'];
	$conversationID = $_POST['conversationID'];
    $receiver = $_POST['receiver'];
	$receiverPhoto = $_POST['receiverPhoto'];
    $topic = $_POST['topic'];
    $message = $_POST['message'];

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
	
	$topic = mysqli_real_escape_string($conn, $topic);
	$message = mysqli_real_escape_string($conn, $message);

    $sql = "INSERT INTO inbox(conversationID,sender,senderPhoto,receiver,receiverPhoto,topic,message) VALUES ('$conversationID', '$username', '$senderPhoto', '$receiver', '$receiverPhoto', '$topic' , '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Fail";
    }
    mysqli_close($conn);
}