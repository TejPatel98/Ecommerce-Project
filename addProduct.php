<?php
include ('connect.php')
$id = $_GET['id'];
$foobar = explode("\"",$id);;

 $val = "select max(productId) as newId from Product;";
      $value = mysqli_query($conn, $val);
      $bar = intval(mysqli_fetch_assoc($value)["newId"]) + 1;
      $productAddition = "insert into Product values (" . $bar . ", '" . $_POST["name"] . "', '" . $_POST["keywords"] . "', NULL, " . $_POST["cost"] . ", 5, '" . $_POST["image"] . "');";
      $foo = mysqli_query($conn, $productAddition);
      if ($foo) {
	      header("Location: http://172.31.148.24/Ecommerce-Project/Employee.php?identification=".$foobar[3]);
        echo "The product has been Added!";
      }
?>
