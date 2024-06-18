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

    if (!isset($_SESSION['userId'])) {
        header("Location: ../home.php");
        exit;
    }

    if (isset($_SESSION['roleId']) && $_SESSION['roleId'] == '02') {
        header("Location: ../error.php");
        exit;
    } else {
        $username = $_SESSION['username'];
    }

    if (isset($_POST['edit-product'])) {
        $itemId = $_POST['product-id'];
    }

    if (!isset($_SESSION['img'])) {
        # get data of product by product_id
        $res_product = mysqli_query($dbConnect, "SELECT * FROM Products WHERE product_id = '$itemId'");
        if ($res_product) {
            $drinkData = mysqli_fetch_assoc($res_product);
            $drink_name = $drinkData['product_name'];
            $drink_price = $drinkData['price'];
            $img_name = $drinkData['image_path'];
            // echo "<br>id: " . $drinkData['product_id'] . ", " . $drinkData['product_name'] . ", " . $drinkData['price'] . ", " . $drinkData['image_path'];
        }
    }

    if (isset($_POST['click'])) {
        $_SESSION['itemId'] = $_POST['id-product'];
        $_SESSION['name'] = $_POST['name-product'];
        $_SESSION['price'] = $_POST['price-product'];
        $_SESSION['img']++;
        header("Refresh:0");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee help You</title>
    <!-- Link to external CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styleadmin.css">
    <style>
        body {
            /* font-family: 'Trebuchet MS', sans-serif; */
            font-family: system-ui;
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
                    echo "<a href='logout.php' class='btn btn-outline-primary px-3'>Logout</a>";
                } else {
                    echo "<a href='login.php' class='btn btn-outline-primary px-3'>Login</a>";
                }
            ?>
            </form>
        </div>
    </nav>
    <div class="container-lg">
        <div class="card border-primary w-75 mx-auto mt-5" style="padding-top: 20px;">
            <h5 class="card-header" >Edit Information of Drinks</h5>
            <div class="card-body mt-4">
                <form enctype="multipart/form-data" method="POST" action="editItem.php">
                    <input type="hidden" name="id-product" value="<?php if(!isset($_SESSION['itemId'])){ echo $itemId; } else { echo $_SESSION['itemId']; } ?>">
                    <div class="mb-3 row">
                        <label for="name-product" class="col-sm-2 col-form-label" style="font-size: large;">Drinks name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name-product" name="name-product" value="<?php if(!isset($_SESSION['name'])){ echo $drink_name; } else { echo $_SESSION['name']; } ?>">
                        </div>
                    </div><br>
                    <div class="mb-3 row">
                        <label for="price-product" class="col-sm-2 col-form-label" style="font-size: large;">Price</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="price-product" name="price-product" placeholder="00.00" value="<?php if(!isset($_SESSION['price'])){ echo $drink_price; } else { echo $_SESSION['price']; } ?>">
                        </div>
                    </div><br>
                    <div class="mb-3 row">
                    <?php   if(!isset($_SESSION['img'])) { ?>
                        <label for="img-product" class="col-sm-2 col-form-label" style="font-size: large;">Drinks image</label>
                        <div class="col-sm-10">
                            <div class="alert alert-light" role="alert" style="display:flex; flex-direction:column;">
                                <img src="../image/<?php echo $img_name; ?>" class="rounded" alt="<?php echo $drink_name; ?>" width='300' height='400'>
                                <input type="submit" class="btn btn-outline-primary mt-2" id="click-btn" name="click" value="Change your Image!" style="width: 40%;">
                            </div>
                        </div>
            <?php   } else { 
                        echo '<label for="formFile" class="col-sm-2 col-form-label" style="font-size: large;">Upload image</label>'; 
                        echo '<div class="col-sm-10">';
                        echo '<input type="file" class="form-control" name="file1">';
                        echo '</div>';
                    } ?>
                    </div><br>
                    <div class="d-grid gap-4 d-md-flex justify-content-md-center">
                        <input type="submit" class="btn btn-primary w-100" name="save-info" id="confirm-btn" value="Save">
                        <input type="submit" class="btn btn-outline-secondary w-100" name="cancel-adding" id="cancel-btn" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br><br>
    <?php if(!isset($_SESSION['img'])) { ?>
            <footer class="bg-dark text-center text-lg-start text-white">
                <div class="container p-4"></div>
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    <p>© 2024 DEVELOPER BY: naphatsawan sukuntapree</p>
                </div>
            </footer>
    <?php } else {?>
            <footer class="bg-dark text-center text-lg-start text-white fixed-bottom">
                <div class="container p-4"></div>
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                    <p>© 2024 DEVELOPER BY: naphatsawan sukuntapree</p>
                </div>
            </footer>
    <?php 
        }

        if (isset($_POST['save-info'])) {
            $productId = $_POST['id-product'];
            $productName = $_POST['name-product'];
            $productPrice = $_POST['price-product'];

            if($_SESSION['img'] == 0) {
                $editProduct = "UPDATE Products SET product_name='$productName', price='$productPrice' WHERE product_id = $productId";
                $res_editing = mysqli_query($dbConnect, $editProduct);
                if($res_editing) {
                    unset($_SESSION['name'], $_SESSION['price'], $_SESSION['img'], $_SESSION['itemId']);
                    echo '<script>alert("Edit information successfully!");</script>';
                    echo '<script>setTimeout(function(){ window.location.href = "../home.php"; }, 0);</script>';
                    exit;
                } else {
                    echo "Product addition failed [Error adding record: " . mysqli_error($res_editing); 
                }

            }

            if($_FILES['file1']['name'] != "") {
                if(!move_uploaded_file($_FILES["file1"]["tmp_name"], "../image/" . $_FILES["file1"]["name"])) {
                    die("Upload error with code " . $_FILES["file1"]["error"]);
                }
            } else {
                die("You did not specify an input file or file exceeded the form limit");
            }

            $imageName = $_FILES['file1']['name'];
            // echo "<br>productId: " . $productId . ", productName: " . $productName . ", productPrice: " . $productPrice . ", img: " . $imageName;
            $editProduct = "UPDATE Products SET product_name='$productName', price='$productPrice', image_path='$imageName' WHERE product_id = $productId";
            $res_editing = mysqli_query($dbConnect, $editProduct);
            if($res_editing) {
                unset($_SESSION['name'], $_SESSION['price'], $_SESSION['img'], $_SESSION['itemId']);
                echo '<script>alert("Edit information successfully!");</script>';
                echo '<script>setTimeout(function(){ window.location.href = "../home.php"; }, 0);</script>';
                exit;
            } else {
                echo "Product addition failed [Error adding record: " . mysqli_error($res_editing); 
            }
        }

        if (isset($_POST['cancel-adding'])) {
            unset($_SESSION['name'], $_SESSION['price'], $_SESSION['img'], $_SESSION['itemId']);
            header("Location: ../home.php");
            exit;
        }
    ?>
</body>
</html>