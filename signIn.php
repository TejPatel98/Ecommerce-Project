<?php

$servername = "localhost";
$username = "tej";
$password = "hellophpworld";
$dbname = "eCommerce";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection 
if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
}

$userName = $_POST["username"];
$passWord = $_POST["password"];

$sql = "select * from Individual where username='".$userName."' and password='".$passWord."';";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	//echo "You are in the system!";
	header("Location: http://172.31.148.24/Ecommerce-Project/homepage.php");
} else {
    echo "Cannot find you, please go back and sign up.";
}

mysqli_close($conn);



?>
