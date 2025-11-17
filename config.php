<?php
$host = "sql100.infinityfree.com"; 
$user = "if0_40402756"; 
$pass = "Tati2025le!";
$db   = "if0_40402756_hefacebook";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Error de conexión: " . mysqli_connect_error());
}

session_start();
?>
