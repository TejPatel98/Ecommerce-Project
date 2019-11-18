<?php
include('connect.php');
/*
$servername = "localhost";
$username = "tej";
$password = "hellophpworld";
$dbname = "eCommerce";

echo "You are employee!";

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection 
if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
}
 */
$sql = "select * from Product;";
$result = mysqli_query($conn, $sql);
$data = array();
?>
<h1>Employee Page</h1>
<form action='/Ecommerce-Project/index.html' method='post'><input type="submit" name="logout" value="Log Out"></input></form>
<h2>Inventory</h2>
<table id="inventory" border="0" cellspacing="2" cellpadding="2">
      <tr>
	<td> <font face="Arial">ProductId</font> </td>
	<td> <font face="Arial">Name</font> </td>
        <td> <font face="Arial">Cost</font> </td>
	<td> <font face="Arial">Quantity</font> </td>
      	<td> </td>
	</tr>
<?php

while ($row = mysqli_fetch_assoc($result)) {

	echo '<tr>
		<td>'.$row['productId'].'</td>
		<td>'.$row['name'].'</td>
        	<td>'.$row['cost'].'</td>
		<form action="" method="post"><td>
		<input type="text" placeholder="'.$row['quantity'].'" name="temp" maxlength="3" size="3"/>
		<input type="submit" name="update" value="Update"/>
		<input type="hidden" name="productId" value="'.$row['productId'].'"/>
		</td></form>
		</tr>';
	}

?>
</table>
<?php

	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['update'])){
	
		$result = mysqli_query($conn, "select * from Product where productId = ".$_POST['productId']."");
		while($row = mysqli_fetch_assoc($result)) { 

			$string = $_POST['temp'];
			$num = (int)$string;
			$result = mysqli_query($conn, "update Product set quantity = ".$string." where productId = ".$row['productId'].";");
			$row['quantity']=$num;
		}		

	}
?>
<h2>Pending Orders</h2>
<form action='' method='post'>
<input type="submit" name="orders" value="View Pending Orders"/>
</form>
<?php
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['orders'])){
		$result = mysqli_query($conn, "select * from Cart where orderStatus = 'P'");
		while($row = mysqli_fetch_assoc($result)) {
			echo '<p>Order ID: '.$row['orderId'].' | Quantity: '.$row['quantity'].' | Cost: '.$row['cost'].'</p>';
		}
	}
?>
<h2>Add Inventory Item</h2>
<form action='' method='post'>
  Product Name: <input type="text" name="name" size="15">
  Keywords: <textarea name="keywords" rows="2" columns="10"></textarea>
 <!-- Product Status: <input type="text" name="productStatus" size="1" maxlength="1">-->
  Cost: <input type="text" name="cost" size="6">
  Image Name: <input type="text" name="image" placeholder="Include .jpg" size="15">
  <input type="submit" name="submit" value="Submit">
</form>



<?php
if(isset($_POST['submit'])){
	$val = "select max(productId) as newId from Product;";
	$value = mysqli_query($conn, $val);
	$temp = mysqli_fetch_assoc($value);
	$newVal = $temp["newId"]+1;
	$productAddition = "insert into Product values (".$newVal.", '".$_POST["name"]."', '".$_POST["keywords"]."', NULL, ".$_POST["cost"].", 1, '".$_POST["image"]."');";
	$foo = mysqli_query($conn, $productAddition);
	if ($foo){
		echo "The product has been Added!";
	}
}
?>
