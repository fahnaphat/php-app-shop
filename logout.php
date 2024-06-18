<?php 
session_start();

# unset session of home page
unset($_SESSION['userId'], $_SESSION['roleId'], $_SESSION['username']);

# unset session of editItem page
unset($_SESSION['name'], $_SESSION['price'], $_SESSION['img'], $_SESSION['itemId']);

# unset session of client search data
unset($_SESSION['dataSearch']);

if (isset($_COOKIE['unameCookie'])) {
    header("Location: login.php");
}
else {
    header("Location: home.php");
}

?>