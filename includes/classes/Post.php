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

        $data_query = mysqli_query($this->con, "SELECT * FROM users WHERE disabled_='no' AND user_closed='no' ORDER BY CASE WHEN $this->order_by = '' THEN 1 ELSE 0 END, $this->order_by ASC");

        if (mysqli_num_rows($data_query) > 0) {

            $num_iterations = 0; //number of results checked
            $count = 1;


            while ($row = mysqli_fetch_array($data_query)) {
                if ($num_iterations++ < $start) {
                    continue;
                }

                //once enough have been loaded, break
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
                    if (strlen($row['personal_statement']) >= 80) {
                        $personal_statement_string = substr($row['personal_statement'], 0, 80) . "...";
                    } else {
                        $personal_statement_string = $row['personal_statement'];
                    }
                }

                $str .= "
                    <div class='col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6' style='padding: 0;'>
                        <div class='card' style='width: auto; margin: 1rem;'>
                            <div class='card-body' style='padding: 0;' >
                                <div class='post_profile_pic'>
                                    <a href='" . $username . "'>
                                        <img class='card-img-top' style='border-radius: 0; max-width: 100%;' src='$profile_pic' >
                                    </a>
                                </div>
                                <div class='card-info'>
                                    <div class='poster_info'>
                                        <a href='" . $username . "'> $name </a>
                                        <br>
                                        <small>$owen_program</small>
                                        <br>
                                        <small>$owen_classof_string</small>
                                        <br>
                                        <br>
                                    </div>
                                    <div class='card_body'>
                                        <small>$personal_statement_string</small> 
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
                <div class='card' style='width: 100%; margin: 1rem;'>
                    <div class='card-body' style='padding: 0;' >
                        <div class='post_profile_pic'>
                            <div style='padding: 1rem;'>
                                <div class='poster_info' style='text-align: center;'>
                                    <h4>That's all we have (For now...)</h4>
                                    <p> No more people to show! </p>
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
