<?php
include('connect.php');
$result = mysqli_query($conn, "select * from Transaction natural join Cart where TransactionDate >= DATE_ADD(current_date(), interval -7 day);");
                $delim = ",";
                $filename = "data_Week.csv";
                $f = fopen('php://output', 'w');
                $fields = array('Username', 'OrderId', 'transactionId', 'ProductId', 'quantity', 'TransactionDate');
                fputcsv($f, $fields, $delim);

                while ($row = mysqli_fetch_assoc($result)){
                        $line = array($row['Username'], $row['OrderId'], $row['transactionId'], $row['ProductId'], $row['quantity'], $row['TransactionDate']);
                        fputcsv($f, $line, $delim);
                }

                fseek($f, 0);
                header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		fpassthru($f);

		exit;
?>
