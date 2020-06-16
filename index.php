<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");




?>
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <div class="user_details column">
                    <!-- Profile Image -->
                    <a class="profile-sidebar-image cropped"> <img src="<?php echo $user['profile_pic']; ?>" alt=""> </a>
                </div>

                <!-- Sidebar -->

                <!-- Shows up only if user is logged in -->
                <?php if (isset($_SESSION['username'])) {
                    echo '
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <div class="nav-link">
                            <h5>
                                Welcome, ' . $user['first_name'] . ' ' . $user['last_name'] . '
                            </h5>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="' . $userLoggedIn . '">
                            <span data-feather="home"></span>
                            My Profile <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">
                            <span data-feather="file"></span>
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="includes/handlers/logout.php">
                            <span data-feather="file"></span>
                            Log Out
                        </a>
                    </li>
                </ul> ';
                } else {
                    echo '
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <div class="nav-link">
                                <h5>
                                    Welcome, Guest!
                                </h5>
                                <p>
                                    If you are a student, be sure to register and create your account. To everyone else, hello and welcome to our site! If you have any issues, be sure to contact us to report any bugs you may run into.
                                </p>
                            </div>
                        </li>
                    </ul>
                    
                    ';
                }


                ?>

                <!-- Shows up anytime -->
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Sort By:</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link reorder" href="#" onclick="changeOrder('last_name')">
                            <span data-feather="file-text"></span>
                            Name
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link reorder" href="#" onclick="changeOrder('owen_classof')">
                            <span data-feather="file-text"></span>
                            Class
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link reorder" href="#" onclick="changeOrder('owen_program')">
                            <span data-feather="file-text"></span>
                            Program
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Profiles -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mt-5" id="main-platform">
                <div class="container-fluid mt-1 mb-1">
                    <div class="search-dropdown">
                        <div class="search_results">
                        </div>
                        <div class="search_results_footer_empty">
                        </div>
                    </div>
                </div>
                <!-- <h1 class="h2">Dashboard</h1> -->
            </div>
            <div class="table-responsive row pl-3 pr-3 justify-content-md-center posts_area">
                <div class="posts_area">
                    <img style="text-align: center;" src="assets/images/icons/loading.gif" alt="" id="loading">
                </div>
            </div>

            <script>
                var order_by = 'id';

                function changeOrder(value) {
                    order_by = value;
                    console.log(order_by);
                }

                $(function() {
                    var loadCards = function() {
                        $('#loading').show();

                        //Original ajax request for loading first posts 
                        $.ajax({
                            url: "includes/handlers/ajax_load_posts.php",
                            type: "POST",
                            data: "page=1&order_by=" + order_by,
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
                                    data: "page=" + page + "&order_by=" + order_by,
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


                        $('.reorder').on('click', loadCards);

                    };
                    $(document).ready(loadCards);




                });
            </script>

        </main>
    </div>
</div>



<?php
require "includes/footer.php";
?>