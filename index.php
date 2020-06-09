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
                <?php if (isset($_SESSION['username'])) echo '
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
                        <a class="nav-link" href="includes/handlers/logout.php">
                            <span data-feather="file"></span>
                            Log Out
                        </a>
                    </li>
                </ul> ' ?>

                <!-- Shows up anytime -->
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Sort By:</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Class Low to High
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Class High to Low
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Program A-Z
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Program Z-A
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Profiles -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom mt-5" id="main-platform">
                <div class="container-fluid">


                </div>
                <!-- <h1 class="h2">Dashboard</h1> -->
            </div>
            <div class="table-responsive row pl-3 pr-3 justify-content-md-center">
                <?php
                $post = new Post($con);
                $post->loadPosts();
                ?>
            </div>
        </main>
    </div>
</div>



<?php
require "includes/footer.php";
?>