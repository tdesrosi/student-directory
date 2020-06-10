<?php
class Post
{
    private $con;
    private $order_by;

    public function __construct($con, $order_by)
    {
        $this->con = $con;
        $this->order_by = $order_by;
    }

    public function loadPosts($data, $limit)
    {

        $page = $data['page'];

        if ($page == 1) {
            $start = 0;
        } else {
            $start = ($page - 1) + $limit;
        }


        $str = ""; //string to return

        $data_query = mysqli_query($this->con, "SELECT * FROM users WHERE disabled_='no' ORDER BY $this->order_by ASC");

        if (mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //number of results checked
            $count = 1;


            while ($row = mysqli_fetch_array($data_query)) {
                if ($num_iterations++ < $start) {
                    continue;
                }

                //once 18 have been loaded, break
                if ($count > $limit) {
                    break;
                } else {
                    $count++;
                }

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
                    <div class='col-lg-4 col-md-6 col-xl-3' style='padding: 0;'>
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
            if ($count > $limit) {
                $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
                <input type='hidden' class='noMorePosts' value='false'>";
            } else {
                $str .= "<input type='hidden' class='nextPage' value='true'>
                <div class='card' style='width: auto; margin: 1rem;'>
                    <div class='card-body' style='padding: 0;' >
                        <div class='post_profile_pic'>
                            <div style='padding: 1rem;'>
                                <div class='poster_info'>
                                    <h4>That's all we have (For now...)</h4>
                                    <p style='text-align: center;'> No more people to show! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        }

        echo " <div class='profile_post row'> $str </div>";
    }
}
