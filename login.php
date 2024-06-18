<?php 
    session_start();
    ob_start(); // Start output buffering
    include './connection.php'; 

    if (isset($_COOKIE['unameCookie'])) {
        $name = $_COOKIE['unameCookie'];
        $_SESSION['userId'] = $_COOKIE['uidCookie'];
        $_SESSION['roleId'] = $_COOKIE['roleCookie'];
        $_SESSION['username'] = $_COOKIE['unameCookie'];
    }

    if (isset($_POST['login'])) {
        $username = $_POST['uname'];
        $pwd = md5($_POST['password']);

        $user_query = mysqli_query($dbConnect, "SELECT * FROM Users WHERE username = '$username' and password = '$pwd'");
        $res_user = mysqli_num_rows($user_query);
        if ($res_user > 0) {
            $userData = mysqli_fetch_assoc($user_query);
            // echo "user_id: " . $userData['user_id'] . ",  role_id: " . $userData['role_id'] . ",  username: " . $userData['username'];
            $_SESSION['userId'] = $userData['user_id'];
            $_SESSION['roleId'] = $userData['role_id'];
            $_SESSION['username'] = $userData['username'];

            if (isset($_POST['rememberMe'])) {
                // cookie expire in 120 seconds (2 minute)
                setcookie("uidCookie", $_SESSION['userId'], time() + 60);
                setcookie("unameCookie", $_SESSION['username'], time() + 60);
                setcookie("roleCookie", $_SESSION['roleId'], time() + 60);
            }
            // else {
            //     cookie detroy.
            //     setcookie("uidCookie", $_SESSION['userId'], time() - 10);
            //     setcookie("unameCookie", $_SESSION['username'], time() - 10);
            //     setcookie("roleCookie", $_SESSION['roleId'], time() - 10);
            // }
            

            header("Location: ./home.php");
            exit;
        }
        else {
            $msgErr = "Incorrect username or password.";
        }
    }
    ob_end_flush(); // End output buffering
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee help You</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="style/stylelogin.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h4 {
            font-family: system-ui;
            font-weight: bold;
            color: azure !important;
            font-size: 40px !important;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: lightblue; 
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark" style="background-color: #e3f2fd; padding: 20px 0;">
        <div class="container">
            <h4 class="navbar-brand me-2">coffee&drink</h4>
        </div>
    </nav>
    <!-- <div class="container-lg"> -->
    <section class="">
        <div class="px-4 py-5 px-md-4 text-center text-lg-start">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-4 display-3 fw-bold ls-tight" style="color: tomato;">
                            <svg width="165px" height="165px"viewBox="0 0 512 512" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#3B4652;} .st1{fill:#2B79C2;} </style> <g> <path class="st1" d="M95.3,433v1.9c0,32.4,26.2,58.6,58.6,58.6h239.4c32.4,0,58.6-26.2,58.6-58.6V433H95.3z"></path> <path class="st0" d="M127.4,343.8c1.9,27.9,11.6,53.7,26.9,75.2H393c17.2-24,27.3-53.4,27.3-85.1v-116H127v28.4 c-5-1.6-10.3-2.4-15.7-2.4c-28.3,0-51.3,23-51.3,51.3c0,28.3,23,51.3,51.3,51.3C116.9,346.4,122.3,345.5,127.4,343.8z M74.1,295.1 c0-20.6,16.7-37.3,37.3-37.3c5.5,0,10.8,1.2,15.7,3.4v67.7c-4.9,2.3-10.2,3.5-15.7,3.5C90.8,332.4,74.1,315.7,74.1,295.1z"></path> <path class="st1" d="M156.2,127.8c14.5-0.4,27.1-8.5,32.1-20.4c2.9-7,3.2-15.2,0.8-22.4c-2-5.9-5.7-10.6-10.4-13.1 c-6.5-3.5-14.5-2.5-19.4,2.4c-2.7,2.7-2.7,7.2,0,9.9c2.7,2.7,7.2,2.7,9.9,0c0.3-0.3,1.6-0.5,2.8,0.1c1.6,0.8,2.9,2.8,3.8,5.3 c1.4,4,1.2,8.6-0.4,12.5c-2.9,6.9-10.6,11.6-19.6,11.9c-13.2,0.4-26.4-9.4-30.8-22.8c-4.3-13-0.7-28.7,9.1-39.9 c9.2-10.6,23.6-17.4,39.3-18.5c16.3-1.1,32,4.1,42.1,14c12.7,12.5,16.9,31.5,19.1,46.7c4.1,27.7,3.8,55.8-0.8,83.4 c-0.6,3.8,1.9,7.4,5.8,8.1c0.4,0.1,0.8,0.1,1.2,0.1c3.4,0,6.3-2.4,6.9-5.9c4.8-29.1,5.1-58.6,0.8-87.7c-2.3-16-7.3-39.1-23.1-54.7 c-12.9-12.7-32.7-19.4-52.9-18c-19.4,1.4-37.2,9.8-48.9,23.2c-13,14.9-17.6,35.9-11.8,53.5C118.1,114.8,136.8,128.4,156.2,127.8z"></path> <path class="st1" d="M311.8,185c0.4,0,0.8,0,1.2-0.1c3.8-0.6,6.4-4.2,5.8-8.1c-4.6-27.6-4.9-55.7-0.8-83.4 c2.2-15.2,6.4-34.3,19.1-46.7c10.1-9.9,25.9-15.2,42.1-14c15.7,1.1,30.1,7.8,39.3,18.5c9.8,11.3,13.3,26.9,9.1,39.9 c-4.4,13.4-17.7,23.2-30.8,22.8c-9-0.3-16.7-4.9-19.6-11.9c-1.6-3.9-1.8-8.5-0.4-12.5c0.9-2.5,2.2-4.5,3.8-5.3 c1.1-0.6,2.5-0.4,2.8-0.1c2.7,2.7,7.2,2.8,9.9,0c2.7-2.7,2.8-7.2,0-9.9c-4.9-4.9-12.8-5.9-19.4-2.4c-4.7,2.5-8.4,7.2-10.4,13.1 c-2.4,7.2-2.2,15.4,0.8,22.4c5,12,17.6,20,32.1,20.4c19.4,0.6,38.1-13.1,44.5-32.4c5.8-17.6,1.2-38.6-11.8-53.5 c-11.7-13.4-29.5-21.9-48.9-23.2c-20.2-1.4-40,5.3-52.9,18c-15.8,15.6-20.8,38.7-23.1,54.7c-4.3,29.2-4,58.7,0.8,87.7 C305.5,182.6,308.4,185,311.8,185z"></path> </g> </g></svg>
                            <br />Delicious coffee <br />
                            <span class="text-primary">of the town</span>
                        </h1>
                        <p style="color: hsl(217, 10%, 50.8%)">
                        Join us for a delightful experience with our finest selection of refreshing beverages!
                        </p>
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card" style="background-color: #f2f2f3;">
                            <div class="card-body py-5 px-md-5">
                                <form method="POST" action="login.php">
                                    <h1>Login</h1>
                                    <p style="color: red;"><?php if(!empty($msgErr)){ echo $msgErr; } ?></p>
                                    
                                    <div class="form-outline mb-4">
                                        <label for="uname" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="uname" name="uname" value="<?php if(!empty($name)){ echo $name; } ?>" required>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" maxlength="10" required>
                                    </div>

                                    <div class="form-check d-flex justify-content-left mb-4">
                                        <input type="checkbox" class="form-check-input me-2" name="rememberMe" id="rememberMe-checkbox">
                                        <label class="form-check-label" for="rememberMe-text">Remember Me</label>
                                    </div>
                                    <div class="d-grid">
                                        <input type="submit" name="login" class="btn btn-primary btn-block mt-3" value="Login">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- </div> -->
    <footer class="bg-dark text-center text-lg-start text-white fixed-bottom">
        <div class="container p-4"></div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <p>© 2024 DEVELOPER BY: naphatsawan sukuntapree</p>
        </div>
    </footer>
</body>
</html>