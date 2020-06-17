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
        $str = "";
        $profile_pic = "";
        $email = "";
        $name = "";
        $username = "";
        $personal_statement = "";
        $owen_classof = 0;
        $owen_program = "";
        $undergrad_institition = "";
        $undergrad_major = "";
        $fun_fact = "";
        $social_media = "";
        $facebook = "";
        $twitter = "";
        $instagram = "";
        $webpage = "";
        $resume_ = "";
        $phone_number = "";
        $hometown = "";

        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);

        $profile_pic = $row['profile_pic'];
        $email = $row['email'];
        $email_sharing = $row['email_sharing'];
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $firstname = $row['first_name'];
        $personal_statement = $row['personal_statement'];
        $owen_classof = $row['owen_classof'];
        $owen_program = $row['owen_program'];
        $undergrad_institition = $row['undergrad_institution'];
        $undergrad_major = $row['undergrad_major'];
        $fun_fact = $row['fun_fact'];
        $social_media = $row['social_media'];
        $facebook = $row['facebook'];
        $twitter = $row['twitter'];
        $instagram = $row['instagram'];
        $webpage = $row['webpage'];
        $resume_ = $row['resume_'];
        $phone_number = $row['phone_number'];
        $hometown = $row['hometown'];
        $signup_date = $row['signup_date'];

        //Conditional Loading of Certain Fields (Depending on if they're filled or not)
        //Picture Loading
        $profile_pic_dir = '';
        if (strpos($profile_pic, 'amazonaws') !== false) {
            $profile_pic_dir = $profile_pic;
        } else {
            $profile_pic_dir = '../' . $profile_pic;
        }

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
        if ($hometown != "") {
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
        if ($fun_fact != "") {
            $fun_fact_string =
                '<h6><i>Fun Fact?</i></h6>
            <p>' . $fun_fact . '</p>
            <br>';
        }

        //Contact info conditional formatters
        $social_media_string = "";
        if ($social_media != "") {
            if (strpos($social_media, 'https://') !== false) {
                $social_media_filtered = $social_media;
                $social_media_string = "<a href=" . $social_media_filtered . " target='_blank'>Visit Me on LinkedIn!</a>";
            } else {
                $social_media_filtered =  'https://' . $social_media;
                $social_media_string = "<a href=" . $social_media_filtered . " target='_blank'>Visit Me on LinkedIn!</a>";
            }
        }


        $facebook_string = "";
        if ($facebook != "") {
            if (strpos($facebook, 'https://') !== false) {
                $facebook_filtered = $facebook;
                $facebook_string = "<a href=" . $facebook_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/facebook.png' ></a>";
            } else {
                $facebook_filtered =  'https://' . $facebook;
                $facebook_string = "<a href=" . $facebook_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/facebook.png' ></a>";
            } 
        }
        $instagram_string = "";
        if ($instagram != "") {
            if (strpos($instagram, 'https://') !== false) {
                $instagram_filtered = $instagram;
                $instagram_string = "<a href=" . $instagram_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/instagram.png' ></a>";
            } else {
                $instagram_filtered =  'https://' . $instagram;
                $instagram_string = "<a href=" . $instagram_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/instagram.png' ></a>";
            } 
        }
        $twitter_string = "";
        if ($twitter != "") {
            if (strpos($twitter, 'https://') !== false) {
                $twitter_filtered = $twitter;
                $twitter_string = "<a href=" . $twitter_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/twitter.png' ></a>";
            } else {
                $twitter_filtered =  'https://' . $twitter;
                $twitter_string = "<a href=" . $twitter_filtered . " target='_blank'><img style='width: 32px; height: 32px; padding: 2px;' class='social-media' src='../assets/images/icons/twitter.png' ></a>";
            } 
        }
        
        $webpage_string = "";
        if ($webpage != "") {
            if (strpos($webpage, 'https://') !== false) {
                $webpage_filtered = $webpage;
                $webpage_string = "<a href=" . $webpage_filtered . " target='_blank'>Visit My Website!</a>";
            } else {
                $webpage_filtered =  'https://' . $webpage;
                $webpage_string = "<a href=" . $webpage_filtered . " target='_blank'>Visit My Website!</a>";
            } 
        }
        

        $resume_string = "";
        if ($resume_ != "") {
            $resume_string = "<a href=" . $resume_ . ">Download my resume!</a>";
        }
        $tel_string = "";
        if ($phone_number != "") {
            $tel_string = "<a href=tel:" . $phone_number . ">Give me a phone call!</a>";
        }
        $email_string = "";
        if ($email != "" && $email_sharing == 'yes') {
            $email_string = "<h6><a href=mailto:" . $email . ">Send me an email!</a></h6>";
        } else if ($email_sharing == 'no') {
            $email_string = "<h6><small><i> The user wishes not to share their email address. </i></small></h6> <br>";
        }

        // Social Media Section Formatting:
        $social_media_section = '
            <div style="display= inline-block;">
                ' . $facebook_string . '
                ' . $twitter_string .'
                ' . $instagram_string . '
            </div>
        ';

        //final string
        $str .= "
            <div style='margin: 4% 7%'>
                <div class='container-fluid row' style='margin-left: 0 !important; margin-left: 0 !important;'>
                    <div class='col-md-4 mt-4' >
                        <div class='card' >
                            <div class='card-body' style='padding: 0;' >
                                <div class='assets/images/profile_pics/defaults/profile_default.png'>
                                    <img class='card-img-top' src='$profile_pic_dir'>
                                </div>
                                <div style='padding: 1rem;'>
                                    <div class='poster_info'>
                                        <h3>$name</h3>
                                        <br>
                                        <h5><i>$owen_program_string</h5>
                                        <p>$owen_classof_string</i></p>
                                        <br>
                                        $email_string
                                        <h6>$social_media_string</h6>
                                        <h6>$tel_string</h6>
                                        <h6>$resume_string</h6>
                                        <h6>$webpage_string</h6>
                                        <br>
                                        $social_media_section
                                        <br>
                                        <h6><small style='opacity: 0.4;'><i> Account Created on $signup_date </i></small></h6>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class='col-md-8 mt-4'>
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
