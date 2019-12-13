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
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
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

<h1 align="middle">Congrtulations!</h1>
<img src="keep-calm-your-order-has-been-placed.png" width="200"
	 height="200" class="center">
<p></p>
<form action = ""  method = "post">
<input type="submit" name="History" value="History" class="center">
<input type="submit" name="Cancel" value="Orders that could be cancelled" class="center">
</form>

<h3 align="middle">Username - <?php echo $identification; ?></h3>

<?php

if(isset($_POST['History'])){
	$history = "select * from Transaction T natural join Product P join Cart on T.OrderId=Cart.OrderId where T.Username='".$identification."';";
	$result = mysqli_query($conn, $history);
	echo '<table border="1" cellspacing="1" cellpadding="4" align="center"> 
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
}
elseif(isset($_POST['Cancel'])){
	$one_day_sql="select * from Transaction natural join Cart join Product on Transaction.ProductId=Product.productId where Transaction.Username='".$identification."' and Transaction.TransactionDate >= DATE_ADD(current_date(), interval -1 day);";
	$result = mysqli_query($conn, $one_day_sql);
	echo '<table border="1" cellspacing="1" cellpadding="4" align="center"> 
      <tr> 
          <td> <font face="Arial">Order Id</font> </td> 
	  <td> <font face="Arial">Product Name</font> </td> 
	  <td> <font face="Arial">Quantity</font> </td> 
          <td> <font face="Arial">Total Cost</font> </td> 
          <td> <font face="Arial">Status</font> </td> 
      </tr>';


	while ($row = mysqli_fetch_assoc($result)) {
		if ($row['orderStatus'] == "P") { $os = "Placed";} 
		else if ($row['orderStatus'] == "S"){ $os = "Shipped";}
?>
		<tr> 
		<td><?php echo $row['OrderId'];?></td> 
			<td><?php echo $row['name'];?></td> 
			<td><?php echo $row['quantity'];?></td> 
                	<td><?php echo $row['cost'] * $row['quantity'];?></td> 
			<td><?php echo $os;?></td> 
			<td><a href='delete.php?id="<?php echo $row['OrderId'];?>"?identification="<?php echo $identification;?>"'>Cancel</a></td>
		</tr>
<?php	
	}

}

?>

</body>
</html>
