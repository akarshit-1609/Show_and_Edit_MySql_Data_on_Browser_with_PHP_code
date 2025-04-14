<?php

$server_mysql = "localhost";
$username_mysql = "root";
$password_mysql = "";

if (session_status() === PHP_SESSION_NONE){
    session_start();
}
if (!isset($_SESSION["database"])){
    $database_mysql = "mysql";
} else {
    $database_mysql = $_SESSION["database"];
}

$connection_mysql = mysqli_connect($server_mysql, $username_mysql, $password_mysql, $database_mysql);

if ($connection_mysql != true){
    die("Error!<br>");
}


?>