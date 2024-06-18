<?php 
    # resources for connect to the database.
    $server = "db";
    $myuser = "phpmyadmin";
    $password_db = "mypassword";
    $database = "mydbshop";
    $dbConnect = mysqli_connect("$server", "$myuser", "$password_db", "$database");
    $select_db = mysqli_select_db($dbConnect, $database);
    if (!$select_db) {
        die("Database connection failed: " . mysqli_connect_error());
        // echo "Connection to database terminated";
    } 
    // else {
    //     echo "Conected to MySQL server successfully!";
    // }
?>