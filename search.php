<?php
include("includes/header.php");
?>


<div class="article-container container-fluid">
    <h1>Search Results</h1>
    <?php
    if (isset($_POST['submit-search'])) {
        $search = mysqli_real_escape_string($con, $_POST['search']);
        $sql = "SELECT * FROM users WHERE
            first_name LIKE '%$search%' OR
            last_name LIKE '%$search%' OR
            hometown LIKE '%$search%' OR
            owen_classof LIKE '%$search%' OR
            owen_program LIKE '%$search%' OR
            undergrad_institution LIKE '%$search%' OR
            undergrad_major LIKE '%$search%' OR
            fun_fact LIKE '%$search%' OR
            personal_statement LIKE '%$search%'

        ";
        $result = mysqli_query($con, $sql);
        $queryResult = mysqli_num_rows($result);
        $str = "";

        if ($queryResult > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $profile_pic = $row['profile_pic'];
                $name = $row['first_name'] . ' ' . $row['last_name'];
                $username = $row['username'];
                $owen_classof = $row['owen_classof'];
                $owen_program = $row['owen_program'];

                $owen_classof_string = "";
                if ($owen_classof != 0) {
                    $owen_classof_string = "Class of " . $owen_classof;
                } else {
                    $owen_classof_string = "";
                }

                $personal_statement_string = "";
                if ($row['personal_statement'] != "") {
                    $personal_statement_string = substr($row['personal_statement'], 0, 120) . ". . .";
                }

                $str .= "
                        <div class='col-lg-4 col-md-6' >
                            <div class='card' style='width: auto; margin: 1rem;'>
                                <div class='card-body' style='padding: 0;' >
                                    <div class='post_profile_pic'>
                                        <a href='" . $username . "'>
                                            <img class='card-img-top' style='border-radius: 0; max-width: 100%; border: none;' src='$profile_pic' >
                                        </a>
                                    </div>
                                    <div style='padding: 1rem;'>
                                        <div class='poster_info'>
                                            <a href='" . $username . "'> $name </a>
                                            <br>
                                            <p>$owen_program</p>
                                            <p>$owen_classof_string</p>
                                        </div>
                                        <div class='card_body'>
                                            <p>$personal_statement_string</p> 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        ";
            }
            echo " <div class='profile_post row'> $str </div>";
        } else {
            echo "<h1>No results found.</h1>";
        }
    }
    ?>
</div>