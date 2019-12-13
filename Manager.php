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
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
      'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

      // Create the data table.
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');

      <?php

      $result_query = "select * from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval -7 day) group by ProductId) as t1 join Product on t1.ProductId = Product.productId;";
      $result = mysqli_query($conn, $result_query);
      $dat = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $dat[] = array($row['name'], intval($row['j1']));
      }
      echo "var temp = " . json_encode($dat) . ";";
      ?>
      console.log(temp);


      data.addRows(temp);

      // Set chart options
      var options = {
        'title': 'Products sold in the last week',
        'width': 400,
        'height': 300
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, options);

      // ------

      var data1 = new google.visualization.DataTable();
      data1.addColumn('string', 'Topping');
      data1.addColumn('number', 'Slices');

      <?php

      $result_query = "select * from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval -30 day) group by ProductId) as t1 join Product on t1.ProductId = Product.productId;";
      $result = mysqli_query($conn, $result_query);
      $dat1 = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $dat1[] = array($row['name'], intval($row['j1']));
      }
      echo "var temp1 = " . json_encode($dat1) . ";";
      ?>
      console.log(temp1);


      data1.addRows(temp1);

      // Set chart options
      var options = {
        'title': 'Products sold in the last month',
        'width': 400,
        'height': 300
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
      chart.draw(data1, options);



      // ------------


      var data2 = new google.visualization.DataTable();
      data2.addColumn('string', 'Topping');
      data2.addColumn('number', 'Slices');

      <?php

      $result_query = "select * from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval -365 day) group by ProductId) as t1 join Product on t1.ProductId = Product.productId;";
      $result = mysqli_query($conn, $result_query);
      $dat2 = array();
      while ($row = mysqli_fetch_assoc($result)) {
        $dat2[] = array($row['name'], intval($row['j1']));
      }
      echo "var temp2 = " . json_encode($dat2) . ";";
      ?>
      console.log(temp2);


      data2.addRows(temp2);

      // Set chart options
      var options = {
        'title': 'Products sold in the last year',
        'width': 400,
        'height': 300
      };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
      chart.draw(data2, options);


    }
  </script>
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
    <br />
    <form method="post" action="" align="center">
      <a href="exportWeek.php" type="submit" name="exportWeek" value="CSV Export week data" align="center" class="btn btn-success ">Download Past Week's Data</a>
      <a href="exportMonth.php" type="submit" name="exportMonth" value="CSV Export month data" align="center" class="btn btn-success ">Download Past Month's Data</a>
      <a href="exportYear.php" type="submit" name="exportYear" value="CSV Export year data" align="center" class="btn btn-success ">Download Past Year's Data</a>
      <a href="export.php" type="submit" name="exportAll" value="CSV Export all data" align="center" class="btn btn-success">Download All Data</a>
      <a href="http://172.31.148.24/Ecommerce-Project/index.html" type="submit" name="out" class="btn btn-success pull-right">Log Out</a>
    </form>
    <br />
    <?php
    /*	if (isset($_POST['exportAll'])) {
		$result = mysqli_query($conn, "select Username, OrderId, transactionId, ProductId, quantity, orderStatus from Transaction natural join Cart;");
		$delim = ",";
		$filename = "data.csv";		
		$f = fopen('php://output', 'w');
		$fields = array('Username', 'OrderId', 'transactionId', 'ProductId', 'quantity');
		fputcsv($f, $fields, $delim);

		while ($row = mysqli_fetch_assoc($result)){
			$line = array($row['Username'], $row['OrderId'], $row['transactionId'], $row['ProductId'], $row['line']);
			fputcsv($f, $line, $delim);
		}
		
		fseek($f, 0);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
	}	
 */


    /*   if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["exportAll"])){
			      $output = fopen("data.csv", "w");  
			      fputcsv($output, array('Username', 'OrderId', 'TransactionId', 'ProductId', 'quantity', 'OrderStatus'));  
			      $query="select Username, OrderId, transactionId, ProductId, quantity, orderStatus from Transaction natural join Cart;";
			      $result = mysqli_query($conn, $query);  
			      while($row = mysqli_fetch_assoc($result))  
			      {  
				   fputcsv($output, $row);  
			      }  
			      fclose($output);
			      header('Content-Type: text/csv; charset=utf-8');  
			      header('Content-Disposition: attachment; filename=data.csv');  
		    }
		    
		 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["exportAll"])){
		    $query=mysqli_query($conn,"select Username, OrderId, transactionId, ProductId, quantity, orderStatus from Transaction natural join Cart;");
		    $delimiter = ",";
		    $filename = "data_" . date('Y-m-d') . ".csv";

		    //create a file pointer
		    $f = fopen('php://memory', 'w');

		    //set column headers
		    $fields = array('Username', 'OrderId', 'TransactionId', 'ProductId', 'quantity', 'OrderStatus');
		    fputcsv($f, $fields, $delimiter);
		
		    //output each row of the data, format line as csv and write to file pointer
		    while($row = mysqli_fetch_assoc($query)){
			$lineData = array($row['Username'], $row['OrderId'], $row['transactionId'], $row['ProductId'], $row['quantity'], $row['orderStatus']);
			fputcsv($f, $lineData, $delimiter);
		    }

		    //move back to beginning of file
		    fseek($f, 0);

		    //set headers to download file rather than displayed
		    header('Content-Type: text/csv');
		    header('Content-Disposition: attachment; filename="' . $filename . '";');

		    //output all remaining data on a file pointer
		    fpassthru($f);
	}*/

    ?>

    <h3>Inventory</h3>
    <form method="POST">
      <table class="table">
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
                    <td>' . $row['name'] . '</td>
                    <td>$' . $row['cost'] . '</td>
                    <td>
                      <input type="text" placeholder="' . $row['quantity'] . '" name="temp'.$row['productId'].'" maxlength="3" size="3"/>
                    </td>

                    <td>
                        <div class="form-group">
                            <select class="form-control" name="promoDropdown' . $row['productId'] . '">
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
            $(".dropdown-menu li a").click(function() {
              $(this).parents(".dropdown").find('.btn').html($(this).text());
              $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
            });
          </script>
        </tbody>
      </table>
      <button type="submit" class="btn btn-secondary" name="updateBtn">Update Products</button>
    </form>
    <?php

    ?>
    <?php
    // if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['update'])) {

    //   $result = mysqli_query($conn, "select * from Product where productId = " . $_POST['productId'] . "");
    //   while ($row = mysqli_fetch_assoc($result)) {

    //     $string = $_POST['temp'];
    //     $num = (int) $string;
    //     $result = mysqli_query($conn, "update Product set quantity = " . $string . " where productId = " . $row['productId'] . ";");
    //     $row['quantity'] = $num;
    //   }
    // }
    if (isset($_POST["updateBtn"])) {
      $result_refresh = mysqli_query($conn, $sql);
      $product_names = array();
      $new_costs = array();

      while ($row_refresh = mysqli_fetch_assoc($result_refresh)) {
        $old_cost = $row_refresh["cost"];
        $dropdown_name = "promoDropdown" . $row_refresh["productId"];
        $input_name = "temp".$row_refresh["productId"];
        $discount = $_POST[$dropdown_name];
        $new_cost = $old_cost * $discount;
        $new_quantity = $_POST[$input_name];

        array_push($product_names, $row_refresh["name"]);
        array_push($new_costs, $new_cost);

        $product_id = $row_refresh["productId"];

        $cost_query = "UPDATE Product SET cost=$new_cost WHERE productId=$product_id";
        if ($conn->query($cost_query) != TRUE) {
          echo "Cost update failed: " . $conn->error;
        }
        $quantity_query = "UPDATE Product SET quantity=$new_quantity WHERE productId=$product_id";
        if ($conn->query($quantity_query) != TRUE && $new_quantity!=NULL) {
          echo "Quantity update failed: " . $conn->error;
        }
        header("Refresh:0");
      }
    }
    ?>

    <br></br>
    <h2>Pending Orders</h2>
    <form action='' method='post'>
      <input type="submit" class="btn btn-secondary" name="orders" value="View Pending Orders" />
    </form>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['orders'])) {
      //      $result = mysqli_query($conn, "select * from Cart where orderStatus = 'P'");
      $result = mysqli_query($conn, "select * from Transaction T natural join Cart C join Product on T.ProductId=Product.productId  where orderStatus='P';");
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<p><b>Order ID</b>: ' . $row['OrderId'] . ' |   <b>Transaction Date</b>: ' . $row['TransactionDate'] . ' |   <b>Customer Id</b>: ' . $row["Username"] . ' |   <b>Product Name</b>: ' . $row["name"] . ' |   <b>Quantity</b>: ' . $row['quantity'] . ' |   <b>Cost</b>: ' . $row['cost'] . '</p>';
      }
    }
    ?>
    <br></br>
    <h2>Ship Orders</h2>
    <form action='' class="form-group" method='post'>
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





    <br></br>

    <h2>Add Inventory Item</h2>
    <form action='' class="form-group" method='post'>
      Product Name: <input type="text" class="form-control" name="name" size="15">
      Keyword: <input type="text" class="form-control" name="name" size="15">
      <!-- Product Status: <input type="text" name="productStatus" size="1" maxlength="1">-->
      Cost: <input type="text" class="form-control" name="cost" size="6">
      Image Name: <input type="text" class="form-control" name="image" placeholder="Include .jpg" size="15">
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
    <br></br>


    <h2>Past Sales</h2>
    <?php
    $past = array(-7, -31, -365);
    ?>
    <form action='#' class="form-group" method=POST>
      <select class="form-control" name="past">

        <option default value="none">None</option>
        <option value="<?php echo $past[0]; ?>">Past Week</option>
        <option value="<?php echo $past[1]; ?>">Past Month</option>
        <option value="<?php echo $past[2]; ?>">Past Year</option>
      </select>
      <input type="submit" class="btn btn-success" name="submit" value="Submit" />
    </form>

    <?php
    if (isset($_POST['past'])) {
      $selected_val = NULL;
      $selected_val = $_POST['past'];  // Storing Selected Value In Variable
      if (in_array($selected_val, $past)) {
        $pastStats_query = "select * from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval " . $selected_val . " day);";
        $pastStats = mysqli_query($conn, $pastStats_query);
        while ($row = mysqli_fetch_array($pastStats)) {
          echo "<p><b>TransactionId</b>: " . $row['transactionId'] . "   <b>Customer's username</b>: " . $row['Username'] . "   <b>ProductId</b>: " . $row['ProductId'] . "   <b>Bought On</b>: " . $row['TransactionDate'] . "   <b>Cost</b>: " . $row['cost'] . "   <b>Quantity</b>: " . $row['quantity'] . "</p>";
        }
        $sql_most_sale = "select max(t1.j1) from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval " . $selected_val . " day) group by ProductId) as t1;";
        $temp = mysqli_query($conn, $sql_most_sale);
        $foo = mysqli_fetch_assoc($temp)['max(t1.j1)'];
        $most_sold_product_sql = "select * from (select t1.ProductId from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval " . $selected_val . " day) group by ProductId) as t1 where t1.j1=" . $foo . ") as t2 join Product on Product.productId=t2.ProductId;";
        $most_sold_product = mysqli_query($conn, $most_sold_product_sql);
        echo "<h3> Most popular product/s </h3>";
        while ($row = mysqli_fetch_assoc($most_sold_product)) {
          echo "<p><b>Product Id</b>: " . $row['productId'] . " , <b>Product Name</b>: " . $row['name'] . " , <b>Cost</b>: " . $row['cost'] . ", <b>Total Number of Orders</b>: " . $foo . "</p>";
        }
        $most_number_of_transactions = "select max(t1.j1) from (select Username, count(Username) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval " . $selected_val . " day) group by Username) as t1;";
        $temp2 = mysqli_query($conn, $most_number_of_transactions);
        $bar = mysqli_fetch_assoc($temp2)['max(t1.j1)'];
        $individual_with_most_transactions_sql = "select * from (select Username from (select Username, count(Username) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval " . $selected_val . " day) group by Username) as t1 where t1.j1 = " . $bar . ") as t2 join Individual on t2.Username=Individual.username;";
        $individual_with_most_transactions = mysqli_query($conn, $individual_with_most_transactions_sql);
        echo "<h3> Individual/s with most transactions </h3>";
        while ($row = mysqli_fetch_assoc($individual_with_most_transactions)) {
          echo "<p> <b>Customer Id</b>: " . $row['individualId'] . " , <b>Username</b>: " . $row['username'] . " , <b>Email Address</b>: " . $row['email'] . "</p>";
        }
      }
      /*
	$data = array();
        $data_sql = "select * from (select distinct ProductId, sum(quantity) as j1 from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval ".$selected_val." day) group by ProductId) as t1 join Product on t1.ProductId = Product.productId;";
        $get_data = mysqli_query($conn, $data_sql);
        while ($row = mysqli_fetch_assoc($get_data)){
                $temp = array();
                $temp["x"] = $row['name'];
                $temp["y"] = $row['j1'];
		$data[] = $temp;
	}*/
    }
    ?>

    <form method="post" action="" align="center">
      <input type="submit" class="btn btn-secondary" name="graphicalData" value="graphicalValue">
    </form>
    <?php
    if (isset($_POST['graphicalData'])) { ?>
      <div id="chart_div"></div>
      <div id="chart_div1"></div>
      <div id="chart_div2"></div>
    <?php
    }

    ?>

  </div>
</body>

</html>