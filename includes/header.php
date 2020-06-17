<!-- This file is subject to the terms and conditions defined in the file README.txt -->

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/owen-student-page.js"></script>
    <script src="assets/js/phone.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/master.css">

    <title>Owen Student Directory</title>
</head>

<body>

    <header>

        <!-- ATTENTION - RE-ADD FIXED TOP TO CLASSES BELOW, I ONLY OMIT BECAUSE OF ERROR CHECKING -->
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
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
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link active" style="color: goldenrod;" href="' . $userLoggedIn . '">
                                    <span data-feather="home"></span>
                                    My Profile <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            ';
                        } else {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" style="color: goldenrod;" href="./register.php">Student Login/Register</a>
                            </li>
                            ';
                        }

                    ?>
                   
                </ul>
                <form class="form-inline mt-2 mt-md-0" style="margin: auto 0;" action="search.php" method="POST" name="search_form">
                    <input name="q" placeholder="Search..." autocomplete="off" class="form-control mr-sm-2" type="text" aria-label="Search" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn ?>')" onkeydown="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn ?>')" id="search_text_input">
                    <div class="button_holder">
                        <button id="nav_search_button" class="btn" style="display: none;"> </button>
                    </div>

                </form>



            </div>
        </nav>

    </header>
    <div class="wrapper">