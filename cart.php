<?php
session_start();

$status="";

if (isset($_POST['action']) && $_POST['action']=="remove"){
	if(count($_SESSION["shopping_cart"])===1){
		unset($_SESSION["shopping_cart"]);
	}
	elseif(!empty($_SESSION["shopping_cart"])) {
		$temp = array();
	//	echo $_POST['productId'];
		foreach($_SESSION["shopping_cart"] as $foo){
			$temp[] = $foo['productId'];
		}
	foreach($temp as $value) {
//		echo "...init val...".$value;
		if($_POST["productId"] == $value){
		//	foreach($_SESSION["shopping_cart"] as $val){
		//		echo " ".$val['productId']." ";
		//	}
//			echo "=============";
//			echo "val product id = ".$value;
		$indexValue = array_search($value, $temp);	
//		echo " index value is - ".$indexValue;	
		unset($_SESSION["shopping_cart"][$indexValue]);
		$status = "<div class='box' style='color:red;'>
		Product is removed from your cart!</div>";
		}
//		echo "---".count($_SESSION["shopping_cart"])."---";
			}		
	}
}


if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["shopping_cart"] as &$value){
    if($value['productId'] === $_POST["productId"]){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
}
  	
}
?>
<html>
<head>
<title>Shopping Cart</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">
<form action='/Ecommerce-Project/index.html' method='post'><input type="submit" name="logout" value="Log Out"></input></form>

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php">
<img src="cart-icon.png" /> Cart
<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
?>	
<table class="table">
<tbody>
<tr>
<td></td>
<td>ITEM NAME</td>
<td>QUANTITY</td>
<td>UNIT PRICE</td>
<td>ITEMS TOTAL</td>
</tr>	
<?php		
foreach (array_slice($_SESSION["shopping_cart"],0) as $product){
	
?>
<tr>
<td><img src='./product-images/<?php echo $product["image"]; ?>' width="50" height="40" /></td>
<td><?php echo $product["name"]; ?><br />
<form method='post' action=''>
<input type='hidden' name='productId' value="<?php echo $product["productId"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove'>Remove Item</button>
</form>
</td>
<td>
<form method='post' action=''>
<input type='hidden' name='productId' value="<?php echo $product["productId"]; ?>" />
<input type='hidden' name='action' value="change" />
<select name='quantity' class='quantity' onchange="this.form.submit()">
<option <?php if($product["quantity"]==1) echo "selected";?> value="1">1</option>
<option <?php if($product["quantity"]==2) echo "selected";?> value="2">2</option>
<option <?php if($product["quantity"]==3) echo "selected";?> value="3">3</option>
<option <?php if($product["quantity"]==4) echo "selected";?> value="4">4</option>
<option <?php if($product["quantity"]==5) echo "selected";?> value="5">5</option>
</select>
</form>
</td>
<td><?php echo "$".$product["cost"]; ?></td>
<td><?php echo "$".$product["cost"]*$product["quantity"]; ?></td>
</tr>
<?php
$total_price += ($product["cost"]*$product["quantity"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
</td>
</tr>
</tbody>
</table>		
  <?php
}else{
	echo "<h3>Your cart is empty!</h3>";
	}
?>
</div>
<br /><br />
<br><br>
<form action = ""  method = "post">
<input type="submit" name="Order" value="submit"/>
</form>
<?php
if(isset($_POST['Order'])){


	$transactionId = rand(0,20) * rand(1,20) * rand(0, 100)*rand(1,30);
	include('connect.php');
	$identification = $_GET["identification"];

	foreach($_SESSION["shopping_cart"] as $row){

//		echo $row['name']." is the name, ".$row['cost']."is the cost & ".$row['quantity']."is the quantity ";
		$orderId = rand(0,20) * rand(1,20) * rand(0, 100)*rand(0,99)*rand(0,18);	
		$order = "insert into Cart values (".$orderId.",".$row['quantity'].",'C','P',".$row['cost'].");";
		echo $order;
		include('connect.php');
		if ($conn->query($order) === TRUE) {
   			 echo "order for ".$row['name']." placed!";
		} else {
    			echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();

		
		include('connect.php');
		$date = date('Y-m-d');
		$transaction = "insert into Transaction values (".$orderId.", '".$identification."', ".$row['productId'].", ".$transactionId.", '".$date."');";
		echo $transaction;
		if($conn->query($transaction) === TRUE) {
               		echo "transaction completed";
	       	} else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();

	}
	header("Location: http://172.31.148.24/Ecommerce-Project/orderPlaced.php?identification=".$identification);	
}

?>
<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>
</div>
</body>
</html>
