<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Post.php");
include("../classes/Profile.php");

$limit = 24;    //number of profiles to be loaded per call
$posts = new Post($con, $_REQUEST['order_by']);
$posts->loadPosts($_REQUEST, $limit);



?>