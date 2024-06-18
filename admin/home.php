<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $path = $_SERVER['DOCUMENT_ROOT'] . '/connection.php'; // Update this path
    if (file_exists($path)) {
        include($path);
    } else {
        echo "Error: Connection file not found.";
    }

    if (!isset($_SESSION['userId']) || $_SESSION['roleId'] != '01') {
        header("Location: ../home.php");
        exit;
    }

    if(isset($_POST['del-product'])) {
        $productId = $_POST['product-id-del'];
        $delete_item = "DELETE FROM Products WHERE product_id = '$productId'";
        $res_mydelete = mysqli_query($dbConnect, $delete_item);
        if($res_mydelete) {
            echo '<script>alert("Product (code: ' . $productId . ') has been removed.");</script>';
            header("Refresh:0");
        } else {
            echo "Product deletion failed [Error deleting record: " . mysqli_error($res_mydelete);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee help You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            /* font-family: 'Trebuchet MS', sans-serif; */
            font-family: system-ui;
        }
    </style>
</head>
<body>
    <div class="container-lg">
        <div class="add-drink-btn">
            <form method="POST" action="admin/addItem.php">
                <div class="d-grid gap-2 col-6 mx-auto mb-4">
                    <input type="submit" class="btn btn-primary" data-toggle="button" aria-pressed="false" name="add-product" id="add-btn" value="Add New Drinks!">
                </div>
            </form>
        </div>

        <!-- list all products -->
        <div class="items-container">
        <?php 
            $res_products = mysqli_query($dbConnect, "SELECT * FROM Products");
            if ($res_products) {
                while ($product_row = mysqli_fetch_row($res_products)) {
                    echo "<div>";
                    echo "<img src='image/" . $product_row[3] . "' alt='" . $product_row[1] . "' width='300' height='400'><br>";
                    echo "<p class='nameitem'>" . $product_row[1] . "</p>";
                    echo "<p class='priceitem'> ฿" . $product_row[2] . "</p>";
        ?>
                        <div class="d-grid gap-2 my-auto" style="padding: 0 60px;">
                            <form method="POST" action="admin/editItem.php">
                                <input type="hidden" name="product-id" value="<?php echo $product_row[0]; ?>">
                                <input type="submit" class="btn btn-outline-primary w-100" name="edit-product" id="edit-btn" value="Edit">
                            </form>
                            <form method="POST" action="home.php">
                                <input type="hidden" name="product-id-del" value="<?php echo $product_row[0]; ?>">
                                <input type="submit" class="btn btn-outline-danger w-100" name="del-product" id="delete-btn" value="Delete"><br>
                            </form>
                        </div>
                    </div> <!-- echo -->
        <?php   }
            } else { echo "Respone Error"; } ?>

        </div> <!-- items-container -->
    </div> <!-- container-lg -->
</body>
</html>