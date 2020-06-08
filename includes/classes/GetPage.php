<?php


class GetPage
{
    private $con;
    private $user;

    public function __construct($con, $username)
    {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function loadUser()
    {
        $str = ""; //string to return
        // $data = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
        // $row = mysqli_fetch_array($data);

        // Defining Vars to prevent errors
        $profile_pic = "";
        $name = "";
        $username = "";
        $personal_statement = "";
        $owen_classof = 0;
        $owen_program = "";
        $undergrad_institition = "";
        $undergrad_major = "";
        $fun_fact = "";
        $social_media = "";
        $resume_ = "";
        $phone_number = "";   
        $hometown = "";     


        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);

        $profile_pic =  "../" . $row['profile_pic'];
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $firstname = $row['first_name'];
        $personal_statement = $row['personal_statement'];
        $owen_classof = $row['owen_classof'];
        $owen_program = $row['owen_program'];
        $undergrad_institition = $row['undergrad_institution'];
        $undergrad_major = $row['undergrad_major'];
        $fun_fact = $row['fun_fact'];
        $social_media = $row['social_media'];
        $resume_ = "../" . $row['resume_'];
        $phone_number = $row['phone_number'];
        $hometown = $row['hometown'];




        //Conditional Loading of Certain Fields (Depending on if they're filled or not)
        //Owen Class Formatter
        $owen_classof_string = "";
        if ($owen_classof != 0) {
            $owen_classof_string = "Class of " . $owen_classof;
        } 
        $owen_program_string = "";
        if ($owen_program != "") {
            $owen_program_string = $owen_program;
        } 

        //Hometown Formatter
        $hometown_string = "";
        if($hometown != ""){
            $hometown_string = 
            '<h6><i>Where are you from?</i></h6>
            <p>' . $hometown . '</p>
            <br>';
        }

        //Undergraduate Institution Formatter
        $undergrad_major_string = "";
        if ($undergrad_major != "") {
            $undergrad_major_string = 
            '<h6><i>What did you study before Owen?</i></h6>
            <p>' . $undergrad_major . '</p>
            <br>';
        }
        $undergrad_inst_string = "";
        if ($undergrad_institition != "") {
            $undergrad_inst_string = 
            '<h6><i>Where did you study before Owen?</i></h6>
            <p>' . $undergrad_institition . '</p>
            <br>';
        }
        $fun_fact_string = "";
        if($fun_fact != ""){
            $fun_fact_string = 
            '<h6><i>Fun Fact?</i></h6>
            <p>' . $fun_fact . '</p>
            <br>';
        } 

        //Contact info conditional formatters
        $social_media_string = "";
        if($social_media != ""){
            $social_media_string= "<a href=https://" . $social_media . " target='_blank'>Visit Me on Linkedin!</a>";
        }
        $resume_string = "";
        if($resume_ != "") {
            $resume_string = "<a href=" . $resume_ . ">Download my resume!</a>";
        }
        $tel_string = "";
        if($phone_number != "") {
            $tel_string = "<a href=tel:" . $phone_number . ">Give me a phone call!</a>";
        }


        //final string
        $str .= "
            <div style='margin: 4% 7%'>
                <div class='container-fluid row'>
                    <div class='col-md-4' >
                        <div class='card' >
                            <div class='card-body' style='padding: 0;' >
                                <div class='post_profile_pic'>
                                    <img class='card-img-top'  src='$profile_pic' >
                                </div>
                                <div style='padding: 1rem;'>
                                    <div class='poster_info'>
                                        <h3>$name</h3>
                                        <br>
                                        <h5><i>$owen_program_string</h5>
                                        <p>$owen_classof_string</i></p>
                                        <br>
                                        <h6>$social_media_string</h6>
                                        <h6>$tel_string</h6>
                                        <h6>$resume_string</h6>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class='col-md-8'>
                        <div class='card' >
                            <div class='card-body' style='padding: 0;' >
                                <div style='padding: 1rem;'>
                                    <div class='poster_info'>
                                        <h1>Hi! I'm $firstname </h1>
                                        <br>
                                    </div>
                                 <div class='card_body'>
                                    <p>$personal_statement</p>
                                    <br> 
                                    $hometown_string
                                    $undergrad_inst_string
                                    $undergrad_major_string
                                    $fun_fact_string
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
                ";

        echo " <div class='profile_page'> $str </div>";
    }
}