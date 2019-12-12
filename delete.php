<?php
include ('connect.php');
$id = $_GET['id'];
$foobar = explode("\"",$id);
echo $foobar[1];
echo $foobar[3];

$bar="SET FOREIGN_KEY_CHECKS = 0;";
$bar1="delete from Cart where orderId=".$foobar[1].";";
$bar2="delete from Transaction where orderId=".$foobar[1].";";
$bar3="SET FOREIGN_KEY_CHECKS = 1;";
$value = mysqli_query($conn, $bar);
$value1 = mysqli_query($conn, $bar1);
$value2 = mysqli_query($conn, $bar2);
$value3 = mysqli_query($conn, $bar3);


if ($value and $value1 and $value2 and $value3){
	echo "Your Order has been Cancelled!";
	header("Location: http://172.31.148.24/Ecommerce-Project/orderPlaced.php?identification=".$foobar[3]);	
	exit;
}
else{
	echo $value;
	echo $value1;
	echo $value2;
	echo $value3;

	echo "ERROR !";
}

