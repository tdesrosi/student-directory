<!-- This file is subject to the terms and conditions defined in the file README.txt -->

<?php
ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Chicago");

$con = mysqli_connect("localhost", "root", "", "owen-students");
$order_by = 'id';

if(mysqli_connect_errno()){
    echo "failed to connect: " . mysqli_connect_errno(); 
}
?>