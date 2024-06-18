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

    # Adding item
    if (isset($_POST['add-new-item'])) {
        // Get file size in bytes
        $fileSize = $_FILES['file1']['size'];
        $maxFileSize = 20 * 1024 * 1024; // 20 MB

        // Check if the file size exceeds the maximum allowed size
        if ($fileSize > $maxFileSize) {
            die("Error: File size exceeds the maximum allowed size of 20MB.");
        }

        if($_FILES['file1']['name'] != "") {
            if(!move_uploaded_file($_FILES["file1"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/image/" . $_FILES["file1"]["name"])) {
                die("\nUpload error with code " . $_FILES["file1"]["error"] . " path = " . $_SERVER['DOCUMENT_ROOT']);
            }
        } else {
            die("You did not specify an input file or file exceeded the form limit");
        }

        $productName = $_POST['name-product'];
        $productPrice = $_POST['price-product'];
        $imageName = $_FILES['file1']['name'];

        if ($dbConnect) {
            $addNewProduct = "INSERT INTO Products(product_name, price, image_path) VALUES ('$productName', '$productPrice', '$imageName')";
            $res_adding = mysqli_query($dbConnect, $addNewProduct);
            if($res_adding) {
                echo '<script>alert("Drink added successfully!");</script>';
                echo '<script>setTimeout(function(){ window.location.href = "../home.php"; }, 0);</script>';
            } else {
                echo "Product addition failed [Error adding record: " . mysqli_error($res_adding); 
            }
        }
        else {
            echo "Connection fail.";
        }
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
                    echo "<a href='../logout.php' class='btn btn-outline-primary px-3'>Logout</a>";
                } else {
                    echo "<a href='../login.php' class='btn btn-outline-primary px-3'>Login</a>";
                }
            ?>
            </form>
        </div>
    </nav>
    <div class="container-lg">
        <div class="card border-primary w-75 mx-auto mt-5" style="padding-top: 20px;">
            <h5 class="card-header" >Add New Drinks</h5>
            <div class="card-body mt-4">
                <form enctype="multipart/form-data" method="POST" action="./addItem.php">
                    <div class="mb-3 row">
                        <label for="name-product" class="col-sm-2 col-form-label" style="font-size: large;">Drinks name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="name-product" name="name-product" >
                        </div>
                    </div><br>
                    <div class="mb-3 row">
                        <label for="price-product" class="col-sm-2 col-form-label" style="font-size: large;">Price</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="price-product" name="price-product" placeholder="00.00" >
                        </div>
                    </div><br>
                    <div class="mb-3 row">
                        <label for="formFile" class="col-sm-2 col-form-label" style="font-size: large;">Upload image</label>
                        <div class="col-sm-10">
                        <input type="file" class="form-control" name="file1">
                        </div>
                    </div>
                    <br><br>
                    <div class="d-grid gap-4 d-md-flex justify-content-md-center">
                        <input type="submit" class="btn btn-primary w-100" name="add-new-item" id="confirm-btn" value="Add">
                        <!-- <input type="submit" class="btn btn-outline-secondary w-100" name="cancel-adding" id="cancel-btn" value="Cancel"> -->
                        <a href="../home.php" class="btn btn-outline-secondary w-100" id="cancel-btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
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