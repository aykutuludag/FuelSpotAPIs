<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    include('../../token-validator.php');
    
    // Parameters
    $username = $_POST['username'];
    $product  = $_POST['product'];
    $price    = $_POST['price'];
    $name     = $_POST['name'];
    $address  = $_POST['address'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
	$currency = $_POST['currency'];
	$country   = $_POST['country'];

    if (strlen($username) == 0) {
        echo "username required";
        exit;
    }
    
    if (strlen($product) == 0) {
        echo "product required";
        exit;
    }
    
    if (strlen($price) == 0) {
        echo "price required";
        exit;
    }
    
    if (strlen($name) == 0) {
        echo "name required";
        exit;
    }
    
    if (strlen($address) == 0) {
        echo "address required";
        exit;
    }
    
    if (strlen($phone) == 0) {
        echo "phone required";
        exit;
    }
    
    if (strlen($email) == 0) {
        echo "email required";
        exit;
    }
    
	require_once('../../credentials.php');
	$conn = connectFSDatabase();
    
    $sql = "SELECT * FROM banking WHERE username = '" . $username . "' ORDER BY time DESC LIMIT 0, 1";
    
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $balance = $row['current_balance'];
            if ($balance >= $price) {
                $sql2 = "INSERT INTO orders(username,product,price,name,address,phone,email) VALUES('$username', '$product', '$price', '$name', '$address', '$phone', '$email')";
                if (mysqli_query($conn, $sql2)) {
					$new_balance = $balance - $price;
					$product_price = $price * -1;
					
                    $sql3 = "INSERT INTO banking(username,processType,currency,country,amount,previous_balance,current_balance,notes) VALUES('$username', 'purchase', '$currency', '$country', '$product_price', '$balance', '$new_balance', '$product')";
                    if (mysqli_query($conn, $sql3)) {
                        echo "Success";
                    } else {
                        echo "Fail";
                    }
                } else {
                    echo "Fail";
                }
            } else {
                echo "Insufficient fund";
            }
        }
    }
    mysqli_close($conn);
}