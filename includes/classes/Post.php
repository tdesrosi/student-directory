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
            $personal_statement = $row['personal_statement'];
            $owen_classof = $row['owen_classof'];
            $owen_program = $row['owen_program'];

            $str .= "
                    <div class='col-lg-4 col-md-6' >
                        <div class='card' style='width: auto; margin: 1rem;'>
                            <div class='card-body' style='padding: 0;' >
                                <div class='post_profile_pic'>
                                    <img class='card-img-top' style='border-radius: 0; max-width: 100%; border: none;' src='$profile_pic' >
                                </div>
                                <div style='padding: 1rem;'>
                                    <div class='poster_info'>
                                        <a href='" . $username . "'> $name </a>
                                        <p>$owen_program class of $owen_classof
                                    </div>
                                    <div class='card_body'>
                                        <p>$personal_statement</p> 
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
