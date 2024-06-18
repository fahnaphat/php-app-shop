<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'connection.php';

    if (isset($_SESSION['userId'])) {
        // echo "session username: " . $_SESSION['username'] . ", role: " . $_SESSION['roleId'] . "<br>";
        $username = $_SESSION['username'];
        $role = $_SESSION['roleId'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee help You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="stylehome.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark" style="background-color: #e3f2fd; padding: 20px 0;">
        <div class="container">
            <h4 class="navbar-brand me-2">coffee&drink</h4>
            <form class="form-inline">
            <?php 
                if (!empty($username)) {
                    echo "<span class='form-control px-4 me-3' style='font-weight: bold;' >Hello, " . $username . "</span>";
                    echo "<a href='logout.php' class='btn btn-outline-primary px-3'>Logout</a>";
                } 
                else {
                    echo "<a href='login.php' class='btn btn-outline-primary px-3'>Login</a>";
                }
            ?>
            </form>
        </div>
    </nav>



            <?php 
                if (!empty($role) && $role == '01') {
                    include 'admin/home.php';
                }
                else if (!empty($role) && $role == '02') {
                    include '/var/www/html/client/home.php';
                }
                else {
                    
            ?>
        <br>
    <div class="container-lg">
        <div class="items-container">
            <?php
                    # display all products.
                    $res_products = mysqli_query($dbConnect, "SELECT * FROM Products");
                    if ($res_products) {
                        while ($product_row = mysqli_fetch_row($res_products)) {
                            echo "<div>";
                            echo "<img src='image/" . $product_row[3] . "' alt='" . $product_row[1] . "' width='300' height='400'><br>";
                            echo "<p class='nameitem'>" . $product_row[1] . "</p>";
                            echo "<p class='priceitem'> ฿" . $product_row[2] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "Respone Error";
                    }
                }
            ?>
        </div>
    </div>
    <br><br>
    <footer class="bg-dark text-center text-lg-start text-white">
        <div class="container p-4"></div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <p>© 2024 DEVELOPER BY: naphatsawan sukuntapree</p>
        </div>
    </footer>

</body>
</html>