<!DOCTYPE html>

<html>
<title>Employee Page</title>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body class='container'>
  <?php
  include('connect.php');

  $sql = "select * from Product;";
  $result = mysqli_query($conn, $sql);
  $data = array();
  ?>
  <div style="margin: 5px; padding: 5px;">
    <h1>Employee Page</h1>
    <p>Welcome valued employee! Go ahead and start work! </p>
    <form action='/Ecommerce-Project/index.html' method='post'><input type="submit" class="btn btn-secondary" name="logout" value="Log Out"></input></form>
  </div>

  <div style="margin: 5px; padding: 5px;">
    <h2>Inventory</h2>
    <table class='table table-dark' id="inventory" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td>
          <font face="Arial">ProductId</font>
        </td>
        <td>
          <font face="Arial">Name</font>
        </td>
        <td>
          <font face="Arial">Cost</font>
        </td>
        <td>
          <font face="Arial">Quantity</font>
        </td>
        <td> </td>
      </tr>
      <?php

      while ($row = mysqli_fetch_assoc($result)) {

        echo '<tr>
                <td>' . $row['productId'] . '</td>
                <td>' . $row['name'] . '</td>
                      <td>$' . $row['cost'] . '</td>
                <form action="" method="post"><td>
                <input type="text" placeholder="' . $row['Quantity'] . '" name="temp" maxlength="3" size="3"/>
                <input type="submit" class="btn btn-success" name="update" value="Update"/>
                <input type="hidden" name="productId" value="' . $row['productId'] . '"/>
                </td></form>
              </tr>';
      }

      ?>
    </table>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['update'])) {

      $result = mysqli_query($conn, "select * from Product where productId = " . $_POST['productId'] . "");
      while ($row = mysqli_fetch_assoc($result)) {

        $string = $_POST['temp'];
        $num = (int) $string;
        $result = mysqli_query($conn, "update Product set quantity = " . $string . " where productId = " . $row['productId'] . ";");
        $row['quantity'] = $num;
      }
    }
    ?>
  </div>


  <div style="margin: 5px; padding: 5px;">
    <h2>Pending Orders</h2>
    <form action='' method='post'>
      <input type="submit" class="btn btn-secondary" name="orders" value="View Pending Orders" />
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['orders'])) {
      //	$result = mysqli_query($conn, "select * from Cart where orderStatus = 'P'");
      $result = mysqli_query($conn, "select * from Transaction T natural join Cart C join Product on T.ProductId=Product.productId  where orderStatus='P';");
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<p><b>Order ID</b>: ' . $row['OrderId'] . '<b>Transaction Date</b>: ' . $row['TransactionDate'] . '   <b>Customer Id</b>: ' . $row["Username"] . '   <b>Product Name</b>: ' . $row["name"] . '   <b>Quantity</b>: ' . $row['quantity'] . '   <b>Cost</b>: ' . $row['cost'] . '</p>';
      }
    }
    ?>
  </div>

  <div style="margin: 5px; padding: 5px;">
    <h2>Ship Orders</h2>
    <form action='' method='post'>
      Order ID: <input type="text" class="form-control" name="orderID" size="15">
      <input type="submit" class="btn btn-success" name="ship" value="Submit">
    </form>


    <?php
    if (isset($_POST['ship'])) {
      $bar = "update Cart set orderStatus='S' where orderId=" . $_POST["orderID"] . ";";
      $value = mysqli_query($conn, $bar);
      $temp = mysqli_fetch_assoc($value);

      if ($value) {
        echo "The product status changed to shipped!";
      }
    }
    ?>
  </div>

  <div style="margin: 5px; padding: 5px;">
    <h2>Add Inventory Item</h2>
    <form action='' class="form-group" method='post'>
      Product Name: <input type="text" class="form-control" name="name" size="15">
      Keyword: <input type="text" class="form-control" name="name" size="15">
      <!-- Product Status: <input type="text" name="productStatus" size="1" maxlength="1">-->
      Cost: <input type="text" class="form-control" name="cost" size="6">
      Image Name: <input type="text" class="form-control" name="image" placeholder="Include file-type (ex. .jpg)" size="15">
      <input type="submit" class="btn btn-success" name="submit" value="Submit">
    </form>


    <?php
    if (isset($_POST['submit'])) {
      $val = "select max(productId) as newId from Product;";
      $value = mysqli_query($conn, $val);
      $temp = mysqli_fetch_assoc($value);
      $newVal = $temp["newId"] + 1;
      $productAddition = "insert into Product values (" . $newVal . ", '" . $_POST["name"] . "', '" . $_POST["keywords"] . "', NULL, " . $_POST["cost"] . ", 1, '" . $_POST["image"] . "');";
      $foo = mysqli_query($conn, $productAddition);
      if ($foo) {
        echo "The product has been Added!";
      }
    }
    ?>
  </div>
</body>

</html>
