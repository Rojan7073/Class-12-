<?php
$host   = "127.0.0.1";
$user   = "root";
$pass   = "";
$dbname = "sales_purchase_db";
$port   = 3307;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>