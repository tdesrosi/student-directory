<?php
class Post
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function loadPosts()
    {
        $str = ""; //string to return
        $data = mysqli_query($this->con, "SELECT * FROM users WHERE disabled_='no' ORDER BY signup_date DESC");

        while ($row = mysqli_fetch_array($data)) {
            $profile_pic = $row['profile_pic'];
            $name = $row['first_name'] . ' ' . $row['last_name'];
            $username = $row['username'];
            $owen_classof = $row['owen_classof'];
            $owen_program = $row['owen_program'];

            $owen_classof_string = "";
            if($owen_classof != 0){
                $owen_classof_string = "Class of " . $owen_classof;
            } else {
                $owen_classof_string = "";
            }
            
            $personal_statement_string = "";
            if($row['personal_statement'] != "") {
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
    }
}
