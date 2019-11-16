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
                                            <div class="dropdown show">
                                                <button class="btn btn-secondary dropdown-toggle" href="#" type="button" id="promoDropdown'.$row['productId'].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    None
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="promoDropdown">
                                                    <li><a class="dropdown-item" data-value=".95" href="#">5% off</a></li>
                                                    <li><a class="dropdown-item" data-value=".90" href="#">10% off</a></li>
                                                    <li><a class="dropdown-item" data-value=".50" href="#">50% off</a></li>
                                                </ul>
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
            <button type="button" class="btn btn-default">Update Promotions</button>
        </div>
    </body>
</html>
