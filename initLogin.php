<?php 
$servername = "localhost"; 
$username = "tej"; 
$password = "hellophpworld"; 
$dbname = "Ecommerce";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection 
if (!$conn){ 
	die("Connection failed: try a different User Id or email or User Name."); 
}

$userName = $_POST["username"];
$passWord = $_POST["password"];
$id = $_POST["userId"];
$email = $_POST["email"];
$permissionLevel = $_POST["permissionLevel"];



$sql="insert into Individual values (".$id.",'".$userName."','".$email."','".$passWord."','".$permissionLevel."');";
//$sql = "select * from Individual";

if (mysqli_query($conn, $sql)){
	echo "You have been registered!";
}
else{
	echo mysqli_error($conn);
}

mysqli_close($conn);
?>
