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

    $myuserId = $_SESSION['userId'];

    $ItemsCart = mysqli_query($dbConnect, "SELECT COUNT(*) AS total_items FROM Basket WHERE user_id = '$myuserId'");
    // $num_item = mysqli_num_rows($ItemsCart);
    if ($ItemsCart) {
        $item = mysqli_fetch_assoc($ItemsCart);
        $total = $item['total_items'];
        if (intval($total) == 0) {
            $basket_msg = "'Add to Cart'";
        }
    }

    if (isset($_POST['search-btn'])) {
        $_SESSION['dataSearch'] = $_POST['search'];
    }

    // echo "session search -> " . $_SESSION['dataSearch'];
    
    if (isset($_POST['add-to-cart'])) {
        $coffeeId = $_POST['product-id'];
        $coffeeName = $_POST['product-name'];

        $addItem_on_basket = "INSERT INTO Basket(user_id,product_id) VALUES ('$myuserId','$coffeeId')";
        $res_additem = mysqli_query($dbConnect, $addItem_on_basket);
        if($res_additem) {
            echo '<script>alert("' . $coffeeName . ' has been added to the cart.");</script>';
            header("Refresh:0");
        }
        else {
            echo "Error: " . mysqli_error($dbConnect);
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
            background-color: #f2f2f3; 
        }
        div.card-in-cart {
            display: flex;
            justify-content: flex-end;
            padding-right: 50px;
        }
        div.card-body {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
        }
        div.card-body > * {
            margin-right: 10px; /* Adjust the value to set the desired gap */
        }

        div.card-body > *:last-child {
            margin-right: 0; /* To remove margin from the last item */
        }

    </style>
</head>
<body>
    <div class="container-lg">
        <?php 
            if (!empty($basket_msg)) {
                echo '<div style="margin: 10px 50px;">';
                echo '<div class="alert alert-dark" role="alert" > ';
                echo 'Click the <strong>' . $basket_msg . '</strong> for purchase!';
                echo '</div></div>';
            } else {
                // echo "<p>In cart: <span>" . $total . "</span> drinks</p>";
        ?>
                <form method="POST" action="client/orders.php">
                    <div class="card-in-cart">
                        <div class="card my-4 mb-3">
                            <div class="card-body">
                                <h5 class="card-title">In Cart : <?php echo "<span style='color:red;'>" . $total . "</span>";?> drinks!</h5>
                                <input type="submit" class="btn btn-primary" name="see-cart" id="see-btn" value="Confirm order >>">
                            </div>
                        </div>
                    </div>
                </form>
        <?php }   ?>

        

        <form method="POST" action="home.php">
            <div class="input-group input-group-lg mt-2 mb-4 px-5">
                <span class="input-group-text">Search</span>
                <input type="text" class="form-control" placeholder="drink you're looking for..." name="search" value="<?php if(!empty($_SESSION['dataSearch'])){echo $_SESSION['dataSearch'];}?>">
                <input type="submit" class="btn btn-primary" id="search-btn" name="search-btn" value="Search"><br><br>
            </div>
        </form>
        <div class="items-container">
    <?php 
        if (!empty($_SESSION['dataSearch'])) {
            $search_text = $_SESSION['dataSearch'];
            $search_item = "SELECT * FROM Products WHERE product_name LIKE '%$search_text%' OR price LIKE '%$search_text%'";
            $res_search = mysqli_query($dbConnect, $search_item);
            if (mysqli_num_rows($res_search) > 0) {
                while($product_row = mysqli_fetch_row($res_search)) {
                    echo "<div>";
                    echo "<img src='image/" . $product_row[3] . "' alt='" . $product_row[1] . "' width='300' height='400'><br>";
                    echo "<p class='nameitem'>" . $product_row[1] . "</p>";
                    echo "<p class='priceitem'> ฿" . $product_row[2] . "</p>";
    ?>  
                    <form method="POST" action="home.php">
                        <input type="hidden" name="product-id" value="<?php echo $product_row[0]; ?>">
                        <input type="hidden" name="product-name" value="<?php echo $product_row[1]; ?>">
                        <input type="submit" class="btn btn-dark" name="add-to-cart" id="add-btn" value="Add to Cart">
                    </form>
                    </div>
    <?php       }
            } else {
                echo '<div style="display:flex; flex-direction: column; justify-content: center; align-items: center; margin: 20px 0 0 200px;">';
                echo '<svg width="215px" height="215px" viewBox="0 0 32.00 32.00" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#f6f5f4" stroke-width="1.28"> <g id="search_x2C__magnifier_x2C__magnifying_x2C__emoji_x2C__No_results"> <g id="XMLID_1857_"> <g id="XMLID_1791_"> <path d="M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z " fill="#dfdfdf" id="XMLID_1797_"></path> <path d="M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="#dfdfdf" id="XMLID_1794_"></path> </g> </g> <g id="XMLID_1764_"> <g id="XMLID_4103_"> <line fill="none" id="XMLID_4109_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_4108_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_4107_" r="11.5" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,15.521c0-0.55,0.45-1,1-1s1,0.45,1,1" fill="none" id="XMLID_4106_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_4105_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_4104_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> <g id="XMLID_4096_"> <line fill="none" id="XMLID_4102_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_4101_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_4100_" r="11.5" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,15.521c0-0.55,0.45-1,1-1s1,0.45,1,1" fill="none" id="XMLID_4099_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_4098_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_4097_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> </g> </g> </g><g id="SVGRepo_iconCarrier"> <g id="search_x2C__magnifier_x2C__magnifying_x2C__emoji_x2C__No_results"> <g id="XMLID_1857_"> <g id="XMLID_1791_"> <path d="M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z " fill="#dfdfdf" id="XMLID_1797_"></path> <path d="M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="#dfdfdf" id="XMLID_1794_"></path> </g> </g> <g id="XMLID_1764_"> <g id="XMLID_4103_"> <line fill="none" id="XMLID_4109_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_4108_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_4107_" r="11.5" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,15.521c0-0.55,0.45-1,1-1s1,0.45,1,1" fill="none" id="XMLID_4106_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_4105_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_4104_" stroke="#f6f5f4" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> <g id="XMLID_4096_"> <line fill="none" id="XMLID_4102_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="23.43" x2="21.214" y1="23.401" y2="21.186"></line> <path d=" M29.914,27.086l-3.5-3.5c-0.756-0.756-2.072-0.756-2.828,0C23.208,23.964,23,24.466,23,25s0.208,1.036,0.586,1.414l3.5,3.5 c0.378,0.378,0.88,0.586,1.414,0.586s1.036-0.208,1.414-0.586S30.5,29.034,30.5,28.5S30.292,27.464,29.914,27.086z" fill="none" id="XMLID_4101_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <circle cx="13" cy="13" fill="none" id="XMLID_4100_" r="11.5" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></circle> <path d=" M12,15.521c0-0.55,0.45-1,1-1s1,0.45,1,1" fill="none" id="XMLID_4099_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M17.5,13c0.27,0,0.5,0.23,0.5,0.5S17.77,14,17.5,14S17,13.77,17,13.5S17.23,13,17.5,13z" fill="none" id="XMLID_4098_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> <path d=" M8.5,13C8.77,13,9,13.23,9,13.5S8.77,14,8.5,14S8,13.77,8,13.5S8.23,13,8.5,13z" fill="none" id="XMLID_4097_" stroke="#dfdfdf" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"></path> </g> </g> </g> </g></svg>';
                echo "<h3 style='margin: 40px;'>Sorry, we couldn't find the drink you're looking for.</h3>";
                echo "</div>";
            }
        }
        else {
            $res_products = mysqli_query($dbConnect, "SELECT * FROM Products");
            if ($res_products) {
                while ($product_row = mysqli_fetch_row($res_products)) {
                    echo "<div>";
                    echo "<img src='image/" . $product_row[3] . "' alt='" . $product_row[1] . "' width='300' height='400'><br>";
                    echo "<p class='nameitem'>" . $product_row[1] . "</p>";
                    echo "<p class='priceitem'> ฿" . $product_row[2] . "</p>";
   
    ?>
                    <form method="POST" action="home.php">
                        <input type="hidden" name="product-id" value="<?php echo $product_row[0]; ?>">
                        <input type="hidden" name="product-name" value="<?php echo $product_row[1]; ?>">
                        <input type="submit" class="btn btn-dark" name="add-to-cart" id="add-btn" value="Add to Cart" style="margin-bottom: 15px;">
                    </form>
                    </div>
    <?php       }
            }
        }
    echo "</div>"; # items-container
    echo "</div>"; # container-lg

        
    ?>
</body>
</html>