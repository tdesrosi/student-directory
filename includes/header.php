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
                <form class="form-inline mt-2 mt-md-0" style="margin: auto 0;" action="search.php" method="POST" name="search_form">
                    <input name="search" placeholder="Search..." autocomplete="off" class="form-control mr-sm-2" type="text" aria-label="Search">
                    <div class="button_holder">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="submit-search">Search</button>
                    </div>
                </form>

            </div>
        </nav>
    </header>

    <script>
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';

        $(document).ready(function() {

            $('#loading').show();

            //Original ajax request for loading first posts 
            $.ajax({
                url: "includes/handlers/ajax_load_posts.php",
                type: "POST",
                data: "page=1&userLoggedIn=" + userLoggedIn,
                cache: false,

                success: function(data) {
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });

            $(window).scroll(function() {
                var height = $('.posts_area').height(); //Div containing posts
                var scroll_top = $(this).scrollTop();
                var page = $('.posts_area').find('.nextPage').val();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();

                if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                    $('#loading').show();

                    var ajaxReq = $.ajax({
                        url: "includes/handlers/ajax_load_posts.php",
                        type: "POST",
                        data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                        cache: false,

                        success: function(response) {
                            $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                            $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

                            $('#loading').hide();
                            $('.posts_area').append(response);
                        }
                    });

                } //End if 

                return false;

            }); //End (window).scroll(function())


        });
    </script>

    <div class="wrapper">