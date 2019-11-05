<?php 
$servername = "localhost"; 
$username = "tej"; 
$password = "hellophpworld"; 
$dbname = "eCommerce";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection 
if (!$conn){ 
	die("Connection failed: try a different User Id or email or User Name."); 
}
echo "hello";

$userName = $_POST["username"];
$passWord = $_POST["password"];
$email = $_POST["email"];
$permissionLevel = $_POST["permissionLevel"];



$sql="insert into Individual values (NULL,'".$userName."','".$email."','".$passWord."','".$permissionLevel."');";
//$sql = "select * from Individual";
//echo $sql;

if (mysqli_query($conn, $sql)){
	echo "You have been registered!";
}
else{
	echo mysqli_error($conn);
}
 
mysqli_close($conn);
?>
