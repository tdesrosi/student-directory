<?php
declare(strict_types=1);
require __DIR__ . "../../vendor/autoload.php";
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Chicago");
$con = mysqli_connect($_SERVER["HOST"], $_SERVER["USERNAME"], $_SERVER["PASSWORD"], $_SERVER["DATABASE"]);
$order_by = 'id';

if(mysqli_connect_errno()){
    echo "failed to connect: " . mysqli_connect_errno(); 
}
?>