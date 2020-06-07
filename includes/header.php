<?php
require 'config/config.php';
if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
    <script src="assets/js/owen-student-page.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/master.css">
    <!-- <link rel="stylesheet" href="assets/css/jquery.Jcrop.css"> -->



    <title>Owen Student Directory</title>
</head>

<body>

    <header>
        <!-- ATTENTION - RE-ADD FIXED TOP TO CLASSES BELOW, I ONLY OMIT BECAUSE OF ERROR CHECKING -->
        <nav class="navbar navbar-expand-md navbar-light  bg-light">
            <a class="navbar-brand" href="./index.php">Owen Student Directory</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: goldenrod;" href="./register.php">Student Login/Register</a>
                    </li>
                </ul>
                <form class="form-inline mt-2 mt-md-0" style="margin: auto 0;">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search for a Student" aria-label="Search">
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </header>

<div class="wrapper">    