<!-- This file is subject to the terms and conditions defined in the file README.txt -->

<?php
ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Chicago");

$servername = getenv('HOST');
$dbuser = getenv('USERNAME');
$dbpass = getenv('PASSWORD');
$dbname = getenv('DATABASE');


$con = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
$order_by = 'id';

if(mysqli_connect_errno()){
    echo "failed to connect: " . mysqli_connect_errno(); 
}
?>