<?php
include('connect.php');
$id = $_GET['id'];
$foobar = explode("\"",$id);

$result = mysqli_query($conn, "select * from Transaction T natural join Cart C join Product on T.ProductId=Product.productId  where orderStatus='P';");
while ($row = mysqli_fetch_assoc($result)) {
        echo '<p><b>Order ID</b>: ' . $row['OrderId'] . '<b>Transaction Date</b>: ' . $row['TransactionDate'] . '   <b>Customer Id</b>: ' . $row["Username"] . '   <b>Product Name</b>: ' . $row["name"] . '   <b>Quantity</b>: ' . $row['quantity'] . '   <b>Cost</b>: ' . $row['cost'] . '</p>';
      }
	//header("Location: http://172.31.148.24/Ecommerce-Project/Employee.php?identification=".$foobar[3]);
        exit();
    ?>
