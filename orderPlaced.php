<?php
include ('connect.php');

echo "you have placed your order !";
echo "\n";
echo "ADD A PICTURE HERE !";
echo "\n";

$identification = $_GET['identification'];
	echo $identification;
?>


<html>
<body>

<form action = ""  method = "post">
<input type="submit" name="History" value="History"/>
<input type="submit" name="LogOut" value="LogOut"/>
</form>
<?php

if(isset($_POST['History'])){
//	echo "you chose History";
	$history = "select * from Transaction T natural join Product P join Cart on T.OrderId=Cart.OrderId where T.Username='".$identification."';";
//		echo $history;
	$result = mysqli_query($conn, $history);
	echo "\n User Name = ".$identification;
	echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Name of the Product</font> </td> 
          <td> <font face="Arial">Total Cost</font> </td> 
          <td> <font face="Arial">Status</font> </td> 
      </tr>';


	while ($row = mysqli_fetch_assoc($result)) {
		echo '<tr> 
			<td>'.$row['name'].'</td> 
                	<td>'.$row['cost']*$row['quantity'].'</td> 
			<td>'.$row['orderStatus'].'</td> 
        	      </tr>';
	
	}
}
elseif(isset($_POST['LogOut'])){
//	echo "you chose to Log Out";
	header("Location: http://172.31.148.24/Ecommerce-Project/index.html");
	exit();
}


?>

</body>
</html>
