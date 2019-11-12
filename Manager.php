<?php
$servername = "localhost";
$username = "tej";
$password = "hellophpworld";
$dbname = "eCommerce";

echo "You are manager!";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection 
if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
}

$sql = "select * from Product;";
$result = mysqli_query($conn, $sql);
$data = array();

echo '<table border="0" cellspacing="2" cellpadding="2">
      <tr>
          <td> <font face="Arial">Name</font> </td>
          <td> <font face="Arial">Cost</font> </td>
          <td> <font face="Arial">Quantity</font> </td>
      </tr>';


while ($row = mysqli_fetch_assoc($result)) {

	echo '<tr>
                  <td>'.$row['name'].'</td>
                  <td>'.$row['cost'].'</td>
              	  <td>'.$row['Quantity'].'</td>
              </tr>';

}



?>
