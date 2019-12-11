<?php
include('connect.php');
$identification = $_GET["identification"];

session_start();

$status="";
if (isset($_POST['productId']) && $_POST['productId']!=""){
$productId = $_POST['productId'];
$result = mysqli_query($conn,"SELECT * FROM Product WHERE productId='".$productId."'");
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
$temp = array();

if(empty($_SESSION["shopping_cart"])) {
	$_SESSION["shopping_cart"] = $cartArray;
	$temp[]=$productId;
	$status = "<div class='box'>Product is added to your cart!</div>";
}else{
	foreach($_SESSION["shopping_cart"] as $value){
		$temp[]=$value['productId'];
	}
	if(in_array($productId,$temp)) {
		$status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";	
	} else {
	//$temp[]=$productId;
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
	$status = "<div class='box'>Product is added to your cart!</div>";
	}
	}
}

$keyword_query = "SELECT DISTINCT keywords FROM Product;";
$keyword_data = mysqli_query($conn, $keyword_query);
$allkeywords = array();
while ($keywords = mysqli_fetch_array($keyword_data)){
	$allkeywords[] = $keywords;
}
$categories = array();
foreach($allkeywords as $keyword)
	$categories[] = $keyword[0];



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
  <div class='image' align="center"><img src='./logo.png' align="center"></div>

<form action='#' method=POST align="right">
<select name="chosenCategory">

	<option default value="all">All Categories</option>
   <?php    
	foreach($categories as $category){?>
	    <option value="<?php echo $category;?>"><?php echo $category;?></option>";
   <?php }
?>
</select>
<input type="submit" name="submit" value="Submit" />
</form>

<?php
if(isset($_POST['submit'])){
$select_val=NULL;	
$selected_val = $_POST['chosenCategory'];  // Storing Selected Value In Variable
if ($selected_val=="all"){

?>
</div>

<div style="width:700px; margin:50 auto;">

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php?identification=<?php echo $identification?>"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($conn,"SELECT * FROM Product;");
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
mysqli_close($conn);

}

elseif(in_array($selected_val, $categories)){

?>
</div>

<div style="width:700px; margin:50 auto;">

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php?identification=<?php echo $identification?>"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($conn,"SELECT * FROM Product where keywords='".$selected_val."';");
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
mysqli_close($conn);



}
}
else{

?>
</div>

<div style="width:700px; margin:50 auto;">

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php?identification=<?php echo $identification?>"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($conn,"SELECT * FROM Product;");
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
mysqli_close($conn);

}




?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>

<br /><br />
</div>
</body>
</html>
