<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die ("connection failed:" . mysqli_connect_error());
}
//echo "Connected successfully" . PHP_EOL;
?>