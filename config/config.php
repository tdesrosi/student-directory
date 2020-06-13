<?php
declare(strict_types=1);
require __DIR__ . "../../vendor/autoload.php";
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-1',
]);
$bucket = $_SERVER["BUCKETEER_BUCKET_NAME"]?: die('No "S3_BUCKET" config var in found in env!');



ob_start(); //Turns on output buffering
session_start();

$timezone = date_default_timezone_set("America/Chicago");
$con = mysqli_connect($_SERVER["HOST"], $_SERVER["USERNAME"], $_SERVER["PASSWORD"], $_SERVER["DATABASE"]);
$order_by = 'id';

if(mysqli_connect_errno()){
    echo "failed to connect: " . mysqli_connect_errno(); 
}
?>