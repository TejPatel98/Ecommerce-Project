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



?>
