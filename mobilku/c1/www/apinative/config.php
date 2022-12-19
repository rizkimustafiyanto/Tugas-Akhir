<?php
header('Access-Control-Allow-Origin: *');
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "dbao";

$koneksi = mysqli_connect($dbhost, $dbusername, $dbpassword,  $dbname);
