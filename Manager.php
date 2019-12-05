<!DOCTYPE html>
<html>
    <?php
        include('connect.php');
    ?>
    <head>
        <title>Manager Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <br>
            <h2>
                <?php 
                    $manager_name = $_GET["identification"];
                    echo "Welcome, ", $manager_name;
                ?>
            </h2>
            <p>View and update inventory, ship pending orders, and view sales statistics and promotions below.</p>
            <h5>Inventory</h5>
            <form method="POST">       
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Quantity</th>
                            <th>Promotions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "select * from Product;";
                            $result = mysqli_query($conn, $sql);
                            $data = array();

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['cost'].'</td>
                                            <td>'.$row['Quantity'].'</td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" name="promoDropdown'.$row['productId'].'">
                                                        <option value="1">None</option>
                                                        <option value=".95">5% off</option>
                                                        <option value=".90">10% off</option>
                                                        <option value=".50">50% off</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>';
                            }
                        ?>
                        <script>
                            $(".dropdown-menu li a").click(function(){
                                $(this).parents(".dropdown").find('.btn').html($(this).text());
                                $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
                            });
                        </script>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" name="updateBtn">Update Promotions</button>
            </form>
            <?php
                if (isset($_POST["updateBtn"])){
                    $result_refresh = mysqli_query($conn, $sql);
                    $product_names = array();
                    $new_costs = array();

                    while ($row_refresh = mysqli_fetch_assoc($result_refresh)) {
                        $old_cost = $row_refresh["cost"];
                        $dropdown_name = "promoDropdown" . $row_refresh["productId"];
                        $discount = $_POST[$dropdown_name];
                        $new_cost = $old_cost * $discount;

                        array_push($product_names, $row_refresh["name"]);
                        array_push($new_costs, $new_cost);

                        $product_id = $row_refresh["productId"];

                        $cost_query = "UPDATE Product SET cost=$new_cost WHERE productId=$product_id";
                        if ($conn->query($cost_query) != TRUE){
                            echo "Cost update failed: ". $conn->error;
                        }
                    }

                    echo "<br>
                        <button class='btn btn-default' data-toggle='modal' data-target='#promoModal'>Click to View Updates</button>
                            <div id='promoModal' class='modal' role='dialog'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Price after Promotions</h5>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    </div>
                                    <div class='modal-body'>";
                                        for ($i = 0; $i < count($product_names); $i++){
                                            echo $product_names[$i] . " price: $" . $new_costs[$i];
                                            echo "<br>";
                                        }
                                    echo "</div>
                                    <div class='modal-footer'>
                                        <h6>Reload page to view changes.</h6>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                    </div>
                                </div>";
                }
		?>
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
        //      $result = mysqli_query($conn, "select * from Cart where orderStatus = 'P'");
                $result = mysqli_query($conn, "select * from Transaction T natural join Cart C join Product on T.ProductId=Product.productId  where orderStatus='P';");
                while($row = mysqli_fetch_assoc($result)) {
                        echo '<p><b>Order ID</b>: '.$row['OrderId'].'   <b>Transaction Date</b>: '.$row['TransactionDate'].'   <b>Customer Id</b>: '.$row["Username"].'   <b>Product Name</b>: '.$row["name"].'   <b>Quantity</b>: '.$row['quantity'].'   <b>Cost</b>: '.$row['cost'].'</p>';
                }
        }
?>

<h2>Ship Orders</h2>
<form action='' method='post'>
  Order ID: <input type="text" name="orderID" size="15">
  <input type="submit" name="ship" value="Submit">
</form>



<?php
if(isset($_POST['ship'])){
        $bar= "update Cart set orderStatus='S' where orderId=".$_POST["orderID"].";";
        $value = mysqli_query($conn, $bar);
        $temp = mysqli_fetch_assoc($value);

        if ($value){
                echo "The product status changed to shipped!";
        }
}
?>







<h2>Add Inventory Item</h2>
<form action='' method='post'>
  Product Name: <input type="text" name="name" size="15">
  Keyword: <textarea name="keywords" rows="2" columns="10"></textarea>
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
        </div>
    </body>
</html>
