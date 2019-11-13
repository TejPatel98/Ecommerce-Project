<?php
//session_start();
include("connect.php");
/*
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
*/
$userName = $_POST["username"];
$passWord = $_POST["password"];

$sql = "select * from Individual where username='".$userName."' and password='".$passWord."';";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
	$row = mysqli_fetch_assoc($result);
	if($row["permissionLevel"] == "E"){
		$identification = $row["username"];
		$_SESSION['identification'] = $identification;
		header("Location: http://172.31.148.24/Ecommerce-Project/Employee.php?identification=".$identification);
	}
	elseif($row["permissionLevel"] == "M"){
		$identification = $row["username"];
		$_SESSION['identification'] = $identification;
		header("Location: http://172.31.148.24/Ecommerce-Project/Manager.php?identification=".$identification);
	}
	else{
		$identification = $row["username"];
		$_SESSION['identification'] = $identification;
		header("Location: http://172.31.148.24/Ecommerce-Project/homepage.php?identification=".$identification);
	exit();
	}	
} else {
    echo "Cannot find you, please go back and sign up.";
}
mysqli_close($conn);



?>
