<?php
require 'config/config.js';
include("includes/classes/User.php");
include("includes/classes/Post.php");

if(isset($_POST['post_body'])){
    $post = new Post($con);
    $post->loadPosts();
}

?>