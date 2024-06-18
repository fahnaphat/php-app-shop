<?php
    session_start();
    include '../connection.php';

    if (!isset($_SESSION['userId']) || $_SESSION['roleId'] == '01') {
        header("Location: ../home.php");
        exit;
    }

    
    $myuserId = $_SESSION['userId'];
    $username = $_SESSION['username'];
    $role = $_SESSION['roleId'];
    
    if (isset($_POST['comfirm-order'])) {
        $res_inBasket = mysqli_query($dbConnect, "DELETE FROM Basket WHERE user_id = '$myuserId'");
        if ($res_inBasket) {
            echo '<script>alert("Thank you for the purchase!");</script>';
            echo '<script>setTimeout(function(){ window.location.href = "../home.php"; }, 0);</script>';
            exit;
        }
    }
    $current_date = date('Y-m-d');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee help You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/styleadmin.css">
    <style>
        .title-invoice {
            margin: 45px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark" style="background-color: #e3f2fd; padding: 20px 0;">
        <div class="container">
            <h4 class="navbar-brand me-2">coffee&drink</h4>
            <form class="form-inline">
            <?php 
                if (!empty($username)) {
                    echo "<span class='form-control px-4 me-3' style='font-weight: bold;' >Hello, " . $username . "</span>";
                    echo "<a href='../logout.php' class='btn btn-outline-primary px-3'>Logout</a>";
                } 
                else {
                    echo "<a href='login.php' class='btn btn-outline-primary px-3'>Login</a>";
                }
            ?>
            </form>
        </div>
    </nav>
    <div class="container-lg">
        <div class="title-invoice">
            <h2>INVOICE</h2>
            <p>PAYMENT INFO</p>
            <p>Cutomer name: <strong><?php echo $username; ?></strong></p>
            <p>Date: <?php echo $current_date; ?></p>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Beverage</th>
                <th scope="col">Qantity</th>
                <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php 
                    $getInfo = "SELECT Basket.user_id, Products.product_name, Products.price FROM Basket RIGHT JOIN Products ON Basket.product_id = Products.product_id";
                    $res_inCart = mysqli_query($dbConnect, $getInfo);
                    if ($res_inCart) {
                        $count = 0;
                        $total = 0;
                        while ($product_row = mysqli_fetch_row($res_inCart)) {
                            if ($product_row[0] == $myuserId){
                                $total += $product_row[2];
                                echo "<tr>";
                                echo "<th scope='row'>" . ++$count . "</th>";
                                echo "<td>" . $product_row[1] . "</td>";
                                echo "<td>1</td>";
                                echo "<td>" . $product_row[2] . "</td>";
                                echo "</tr>";
                            }
                        }
                    }
                    else {
                        echo "In cart FAIL.";
                    }
                ?>
                <tr>
                    <th scope='row'></th>
                    <td></td>
                    <td>Total</td>
                    <td><?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>
        <form method="POST" action="orders.php">            
            <div class="d-grid col-6 mx-auto mt-5">
                <input type="submit" class="btn btn-outline-primary" name="comfirm-order" value="Confirm Order">
            </div>
        </form>
    </div>
    <br><br>
    <footer class="bg-dark text-center text-lg-start text-white fixed-bottom">
        <div class="container p-4"></div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <p>© 2024 DEVELOPER BY: naphatsawan sukuntapree</p>
        </div>
    </footer>
</body>
</html>