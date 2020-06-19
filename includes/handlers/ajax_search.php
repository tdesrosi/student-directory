<?php
include("../../config/config.php");
include("../../includes/classes/User.php");

$query = $_POST['query'];

$names = explode(" ", $query);

//If query contains an underscore, assume user is search for usernames
if(strpos($query, '_') !== false) 
    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
//if there are two words, assume they are first and last names respectively
else if(count($names) == 2)
    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 8");
//if query has one word only, search first and last names
else 
    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 8");

if($query != "") {
    while($row = mysqli_fetch_array($usersReturnedQuery)) {

        echo "<div class='resultsDisplay row container-fluid'>
                <a class='search-result' href='" . $row['username'] . "'>
                    <div class='row container-fluid row-container'>
                        <div class='liveSearchProfilePic col-5'>
                            <img src='" . $row['profile_pic'] . "'>
                        </div>
                        <div class='liveSearchText col-7'>
                            " . $row['first_name'] . " " . $row['last_name'] . " 
                            <p style='text-decoration: none; color: #cccccc;'><i>" . $row['owen_program'] . "</i></p>
                        </div>
                    </div>
                </a>
            </div>";
        
    }
}

?>