<?php
include('connect.php');
$result = mysqli_query($conn, "select Username, OrderId, transactionId, ProductId, quantity, orderStatus from Transaction natural join Cart;");
                $delim = ",";
                $filename = "data.csv";
                $f = fopen('php://output', 'w');
                $fields = array('Username', 'OrderId', 'transactionId', 'ProductId', 'quantity');
                fputcsv($f, $fields, $delim);

                while ($row = mysqli_fetch_assoc($result)){
                        $line = array($row['Username'], $row['OrderId'], $row['transactionId'], $row['ProductId'], $row['quantity']);
                        fputcsv($f, $line, $delim);
                }

                fseek($f, 0);
                header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		fpassthru($f);

		exit;
?>
