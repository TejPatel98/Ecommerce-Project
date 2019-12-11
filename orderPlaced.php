<?php
include ('connect.php');

$identification = $_GET['identification'];
?>


<html>
<head>

<title>Shopping Cart</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav input[type=text] {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  border: none;
  font-size: 17px;
}
.topnav-right {
  float: right;
}

@media screen and (max-width: 600px) {
  .topnav a, .topnav input[type=text] {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }

  .topnav input[type=text] {
    border: 1px solid #ccc;
  }
}
</style>
</head>
<body>
<div class="topnav">
  <a href=>Toys</a>
  <a class="active" href="http://172.31.148.24/Ecommerce-Project/homepage.php?identification=<?php echo $identification; ?>">Home</a>
  <a href="http://172.31.148.24/Ecommerce-Project/orderPlaced.php?identification=<?php echo $identification;?>">Order History</a>
  <div class="topnav-right">
        <a href="./index.html">Log Out</a>
  </div>
</div>

<h1>Congrtulations!</h1>
<img src="keep-calm-your-order-has-been-placed.png" alt="Simply Easy Learning"  width="200"
	 height="200" align="middle">
<form action = ""  method = "post">
<input type="submit" name="History" value="History"/>
<input type="submit" name="LogOut" value="LogOut"/>
<input type="submit" name="Cancel" value="Orders that could be cancelled"/>
  Order ID To be cancelled: <input type="text" name="orderID" size="15"/>
<input type="submit" name"cancelOrder" value="cancelOrder"/>
</form>

<h3>Username - <?php echo $identification; ?></h3>

<?php

if(isset($_POST['History'])){
	$history = "select * from Transaction T natural join Product P join Cart on T.OrderId=Cart.OrderId where T.Username='".$identification."';";
	$result = mysqli_query($conn, $history);
	echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Order Id</font> </td> 
          <td> <font face="Arial">Name of the Product</font> </td> 
	  <td> <font face="Arial">Quantity</font> </td> 
          <td> <font face="Arial">Total Cost</font> </td> 
          <td> <font face="Arial">Status</font> </td> 
      </tr>';


	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['orderStatus'] == "P") { $os = "Placed";} 
		else if ($row['orderStatus'] == "S"){ $os = "Shipped";}
		echo '<tr> 
			<td>'.$row['orderId'].'</td> 
			<td>'.$row['name'].'</td> 
			<td>'.$row['quantity'].'</td> 
                	<td>'.$row['cost']*$row['quantity'].'</td> 
			<td>'.$os.'</td> 
		</tr>';
	
	}
	echo "<p></p>";
}
elseif(isset($_POST['Cancel'])){
	echo "You can cancel any of the follwowing orders, just type in the order Id an hit \"submit\"";
	$one_day_sql="select * from Cart natural join Transaction where Username='".$identification."' and TransactionDate >= DATE_ADD(current_date(), interval -1 day);";
	$result = mysqli_query($conn, $one_day_sql);
	echo '<table border="0" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Order Id</font> </td> 
	  <td> <font face="Arial">Quantity</font> </td> 
          <td> <font face="Arial">Total Cost</font> </td> 
          <td> <font face="Arial">Status</font> </td> 
      </tr>';


	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['orderStatus'] == "P") { $os = "Placed";} 
		else if ($row['orderStatus'] == "S"){ $os = "Shipped";}
?>
		<tr> 
		<td><?php echo $row['orderId'];?></td> 
			<td><?php echo $row['quantity'];?></td> 
                	<td><?php echo $row['cost'] * $row['quantity'];?></td> 
			<td><?php echo $os;?></td> 
			<td><input type="submit" class = 'btn' name="cancelOrder"  value="cancelOrder" id="<?php echo $row['id'];?>"</td>
		</tr>;
<?php	
	}

	if(isset($_POST['cancelOrder'])){
		$orderid = $_GET['id'];
		echo "got it".$orderid;
		
	}
}
elseif(isset($_POST['cancelOrder'])){
	$val=intval($_POST['orderID']);
	$bar="SET FOREIGN_KEY_CHECKS = 0;";
	$bar1="delete from Cart where orderId=".$val.";";
	$bar2="delete from Transaction where OrderId=".$val.";";
       	$bar3="SET FOREIGN_KEY_CHECKS = 1;";
	$value = mysqli_query($conn, $bar);
	$value1 = mysqli_query($conn, $bar1);
	$value2 = mysqli_query($conn, $bar2);
	$value3 = mysqli_query($conn, $bar3);

        if ($value and $value1 and $value2 and $value3){
                echo "Your Order has been Cancelled!";
	}
	else{
		echo "didnt get in";
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
