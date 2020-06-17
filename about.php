<?php
include("includes/header.php");

//Find my info
$query = mysqli_query($con, "SELECT * FROM users WHERE email='thomas.l.desrosiers@vanderbilt.edu'");
$row = mysqli_fetch_array($query);

$resume_ = $row['resume_'];
$profile_picture = $row['profile_pic'];

//Information Strings
$hometown_string =
    '<h6><i>Where are you from?</i></h6>
            <p>Chandler, AZ</p>
            <br>';


$undergrad_major_string =
    '<h6><i>What did you study before Owen?</i></h6>
            <p>Musical Arts</p>
            <br>';

$undergrad_inst_string =
    '<h6><i>Where did you study before Owen?</i></h6>
            <p>Vanderbilt University</p>
            <br>';
$fun_fact_string =
    "<h6><i>Fun Fact?</i></h6>
            <p>
                In my free time I can be found in the Wond'ry, usually working on something having to do with electronics. I'm really into audio engineering, and build and repair audio equipment. I also play clarinet and tuba!
            </p>
            <br>";
$resume_string = '';
if ($resume_ != '') {
    $resume_string = "<a href=" . $resume_ . ">Download my resume!</a>";
}

//Contact info conditional formatters
$social_media_string = "<a href='https://www.linkedin.com/in/thomas-desrosiers-407ab7162' target='_blank'>Visit Me on LinkedIn!</a>";
$tel_string = "<a href='tel:623-521-6596'>Give me a phone call!</a>";
$email_string = "<h6><a href=mailto:'thomas.l.desrosiers@vanderbilt.edu'>Send me an email!</a></h6>";

?>

<div class="wrapper">
    <div style="margin: 10% 7%;">
        <div class='container-fluid row'>
            <div class='col-md-4 mt-2 mb-2'>
                <div class='card' style="padding: 5px;">
                    <div class='card-body' style='padding: 0;'>
                        <div class='post_profile_pic'>
                            <img class='card-img-top' src='<?php echo $profile_picture ?>'>
                        </div>
                        <div style='padding: 1rem;'>
                            <div class='poster_info'>
                                <h3>Thomas Desrosiers</h3>
                                <br>
                                <h5><i>Master of Marketing</h5>
                                <p>Class of 2021</i></p>
                                <br>
                                <?php echo $email_string ?>
                                <h6><?php echo $social_media_string ?></h6>
                                <h6><?php echo $tel_string ?></h6>
                                <h6><?php echo $resume_string ?></h6>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-8 mt-2 mb-2'>
                <div class='card'>
                    <div class='card-body' style='padding: 0;'>
                        <div style='padding: 1rem;'>
                            <div class='poster_info'>
                                <h1>Hi! I'm Thomas</h1>
                                <br>
                            </div>
                            <div class='card_body'>

                                <p>
                                    Our current global predicament hampers our ability to engage with one another in meaningful ways. 
                                    It also obstructs personal and professional development. I built this website to be able to engage 
                                    with the community virtually. Here, students can learn about another and recruiters can read about and 
                                    appreciate our many talents and capabilities. If you run into any bugs or errors, please feel free to 
                                    send me an email!
                                    <br>
                                    <i><?php echo $email_string ?></i>
                                </p>
                                <br>
                                <h4 style="text-align: center;">About Me:</h4>
                                <br>
                                <?php echo $hometown_string .
                                    $undergrad_inst_string .
                                    $undergrad_major_string .
                                    $fun_fact_string ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>