<?php
ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Chicago");

$con = mysqli_connect("localhost", "root", "", "owen-students");

if(mysqli_connect_errno()){
    echo "failed to connect: " . mysqli_connect_errno(); 
}
?>