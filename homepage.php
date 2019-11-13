<?php
include('connect.php');
$identification = $_GET["identification"];

session_start();

$status="";
if (isset($_POST['productId']) && $_POST['productId']!=""){
$productId = $_POST['productId'];
$result = mysqli_query($conn,"SELECT * FROM Product WHERE productId='$productId'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$productId = $row['productId'];
$cost = $row['cost'];
$image = $row['image'];

$cartArray = array(
	$productId=>array(
	'name'=>$name,
	'productId'=>$productId,
	'cost'=>$cost,
	'quantity'=>1,
	'image'=>$image)
);

if(count($_SESSION["shopping_cart"])===0) {
	$_SESSION["shopping_cart"] = $cartArray;
	$status = "<div class='box'>Product is added to your cart!</div>";
}else	
	$array_keys = array_keys($_SESSION["shopping_cart"]);
	if(in_array($productId,$array_keys)) {
		$status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";	
	} else {
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
	$status = "<div class='box'>Product is added to your cart!</div>";
	}

}

?>
<html>
<head>
<title>Demo Simple Shopping Cart using PHP and MySQL - AllPHPTricks.com</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2> Shopping Cart </h2>   

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"])) - 1;
?>
<div class="cart_div">
<a href="cart.php?identification=<?php echo $identification?>"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($conn,"SELECT * FROM Product");
while($row = mysqli_fetch_assoc($result)){
		echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='productId' value=".$row['productId']." />
			  <div class='image'><img src='./product-images/".$row['image']."' /></div>
			  <div class='name'>".$row['name']."</div>
		   	  <div class='cost'>$".$row['cost']."</div>
			  <button type='submit' class='buy'>Buy Now</button>
			  </form>
		   	  </div>";
        }
//mysqli_close($conn);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>

<br /><br />
</div>
</body>
</html>
