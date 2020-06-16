<?php
include('includes/header.php');
include('includes/form_handlers/profile_change_handler.php');
include("includes/classes/Profile.php");

if (isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    // $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    // $user_array = mysqli_fetch_array($user_details_query);

    if ($username != $userLoggedIn) {
        $headerRedirect = "Location: user.php/?profile_username=" . $username;
        header($headerRedirect);
    }
}


$username = $_SESSION['username'];
$user_data_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_array($user_data_query);

$name = $row['first_name'] . " " . $row['last_name'];
$email_sharing = $row['email_sharing'];
$profile_pic = $row['profile_pic'];
$hometown = $row['hometown'];
$owen_classof = $row['owen_classof'];
$owen_program = $row['owen_program'];
$undergrad_institution = $row['undergrad_institution'];
$undergrad_major = $row['undergrad_major'];
$fun_fact = $row['fun_fact'];
$social_media = $row['social_media'];
$resume_ = $row['resume_'];
$personal_statement = $row['personal_statement'];
$phone_number = $row['phone_number'];
$signup_date = $row['signup_date'];
$facebook = $row['facebook'];
$twitter = $row['twitter'];
$instagram = $row['instagram'];
$webpage = $row['webpage'];


?>

<div style='margin: 7% 7%'>
    <div class='container-fluid row'>
        <div class='col-md-4'>
            <div class='card'>
                <div class='card-body' style='padding: 0;'>
                    <div class='post_profile_pic'>
                        <a href="documents.php">
                            <img class='card-img-top' style="border-radius: 0;" src='<?php echo $profile_pic ?>'>
                        </a>
                    </div>
                    <div style='padding: 1rem;'>
                        <div class='poster_info'>
                            <h3><?php echo $name ?></h3>
                            <br>
                            <a class="btn btn-danger" href="settings.php">
                                <span data-feather="file"></span>
                                Advanced account settings
                            </a>
                            <br>
                            <br>
                            <h6><small style='opacity: 0.2;'><i> Account Created on <?php echo $signup_date ?></i></small></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-8'>
            <div class='card'>
                <div class='card-body' style='padding: 0;'>
                    <div style='padding: 1rem; text-align: center;'>
                        <div class='poster_info'>
                            <!-- Banner Message -->
                            <?php
                            if (isset($_REQUEST['uploadsuccess'])) {
                                if ($_REQUEST['uploadsuccess'] == 'true_photo') {
                                    echo '
                                        <h3 style="color: green;">
                                            <i>Profile Picture Changed Successfully!</i>
                                        </h3>
                                    ';
                                } else if ($_REQUEST['uploadsuccess'] == 'true_resume') {
                                    echo '
                                        <h3 style="color: green;">
                                            <i>Resume Uploaded Successfully!</i>
                                        </h3>
                                    ';
                                }
                            }
                            ?>

                            <h1>Hi! I'm <?php echo $row['first_name']; ?> </h1>
                            <br>
                            <h3>Use this page to edit your user details.</h3>
                            <br>
                            <a class="btn btn-outline-warning" href="documents.php">Change profile picture and upload a resume here!</a>

                        </div>
                        <div class='form-group'>
                            <form action="profile.php" method="POST" class="form-group" name="main-form" enctype="multipart/form-data">
                                <br>
                                <label for="reg_owen_classof">What year do you graduate from Owen?</label>
                                <br>
                                <select name="reg_owen_classof" class="form-control text-center" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;">
                                    <option value="" <?php if ($owen_classof == "") echo "selected"; ?>>--Please choose an option--</option>
                                    <option value="2020" <?php if ($owen_classof == "2020") echo "selected"; ?>>2020</option>
                                    <option value="2021" <?php if ($owen_classof == "2021") echo "selected"; ?>>2021</option>
                                    <option value="2022" <?php if ($owen_classof == "2022") echo "selected"; ?>>2022</option>
                                    <option value="2023" <?php if ($owen_classof == "2023") echo "selected"; ?>>2023</option>
                                </select>
                                <br>
                                <!-- Owen Program -->
                                <label for="reg_owen_program">What's your program at Owen?</label>
                                <br>

                                <select name="reg_owen_program" class="form-control text-center" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;">
                                    <option value="" <?php if ($owen_program == "") echo "selected"; ?>>--Please choose an option--</option>
                                    <option value="MBA" <?php if ($owen_program == "MBA") echo "selected"; ?>>MBA</option>
                                    <option value="Executive MBA" <?php if ($owen_program == "Executive MBA") echo "selected"; ?>>Executive MBA</option>
                                    <option value="MS Finance" <?php if ($owen_program == "MS Finance") echo "selected"; ?>>MS Finance</option>
                                    <option value="MACC Assurance" <?php if ($owen_program == "MACC Assurance") echo "selected"; ?>>MACC Assurance</option>
                                    <option value="MACC Valuation" <?php if ($owen_program == "MACC Valuation") echo "selected"; ?>>MACC Valuation</option>
                                    <option value="Master of Marketing" <?php if ($owen_program == "Master of Marketing") echo "selected"; ?>>Master of Marketing</option>
                                    <option value="Master of Management in Health Care" <?php if ($owen_program == "Master of Management in Health Care") echo "selected"; ?>>Master of Management in Health Care</option>
                                    <option value="Executive Education Certificate Program" <?php if ($owen_program == "Executive Education Certificate Program") echo "selected"; ?>>Executive Education Certificate Program</option>
                                    <option value="Accelerator Business Immersions" <?php if ($owen_program == "Accelerator Business Immersions") echo "selected"; ?>>Accelerator Business Immersions</option>
                                    <option value="Technology Bootcamps" <?php if ($owen_program == "Technology Bootcamps") echo "selected"; ?>>Technology Bootcamps</option>
                                </select>

                                <br>
                                <!-- Personal Statement -->
                                <label for="reg_personal_statement">Add a Personal Statement. This shows up to others as your headline!</label>
                                <br>
                                <textarea rows="5" name="reg_personal_statement" placeholder="Personal Statement"><?php echo $personal_statement; ?></textarea>
                                <br>
                                <!-- Hometown Section -->
                                <label for="reg_hometown">Where are you from?</label>
                                <br>
                                <input type="text" name="reg_hometown" placeholder="Hometown" value="<?php echo $hometown; ?>">
                                <br>
                                <!-- Undergrad School -->
                                <label for="reg_undergrad_institution">Where did you get your Undergraduate Degree?</label>
                                <input type="text" name="reg_undergrad_institution" placeholder="What was your undergraduate institution?" value="<?php echo $undergrad_institution; ?>">
                                <br>
                                <!-- Undergrad Major -->
                                <label for="reg_undergrad_major">What did you major in?</label>
                                <br>
                                <input type="text" name="reg_undergrad_major" placeholder="What did you major in?" value="<?php echo $undergrad_major ?>">
                                <br>
                                <!-- Fun facts -->
                                <label for="reg_fun_fact">Share a fun fact about yourself!</label>
                                <br>
                                <textarea rows="5" name="reg_fun_fact" placeholder="Got any fun facts?"><?php echo $fun_fact; ?></textarea>
                                <br>
                                <!-- NOTICE THIS IS THE SOCIAL MEDIA FORM, FOR NOW, I'LL KEEP IT JUST TO LINKEDIN TO AVOID DEALING WITH ARRAYS -->
                                <label for="reg_social_media"> Add a link to your Linkedin Profile:</label>
                                <br>
                                <input type="text" name="reg_social_media" placeholder="Linkedin Profile URL" value="<?php echo $social_media; ?>">
                                <br>
                                <!-- FACEBOOK -->
                                <br>
                                <label for="reg_facebook"> If you would like, you can also add links to your other social media pages:</label>
                                <br>
                                <input type="text" name="reg_facebook" placeholder="Facebook URL" value="<?php echo $facebook; ?>">
                                <br>
                                <!-- INSTAGRAM -->
                                <input type="text" name="reg_instagram" placeholder="Instagram Profile URL" value="<?php echo $instagram; ?>">
                                <br>
                                <!-- TWITTER -->
                                <input type="text" name="reg_twitter" placeholder="Twitter Profile URL" value="<?php echo $twitter; ?>">
                                <br>
                                <!-- PERSONAL WEBPAGE -->
                                <br>
                                <label for="reg_webpage"> If you have a personal website, link it here!</label>
                                <br>
                                <input type="text" name="reg_webpage" placeholder="Personal Website URL" value="<?php echo $webpage; ?>">
                                <br>
                                <small style="opacity: 0.4;"><i>And if you do not have one and would like one, <a href="mailto:thomas.l.desrosiers@vanderbilt.edu">we should talk.</a></i></small>
                                <br>
                                <br>
                                <!-- Phone Number -->
                                <label for="reg_phone_number">Phone number:</label>
                                <input type="tel" class="form-control" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="reg_phone_number" value="<?php echo $phone_number; ?>">
                                <small>Format: XXX-XXX-XXXX</small>
                                <br>
                                <br>
                                <!-- Email Sharing on/off -->

                                <label style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;" for="reg_email_sharing">Would you like to disable email sharing? Your email is visible to others by default.</label>
                                <br>
                                <select name="reg_email_sharing" class="form-control text-center" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;">
                                    <option value="yes" <?php if ($email_sharing == "yes") echo "selected"; ?>>Yes, please share my email address.</option>
                                    <option value="no" <?php if ($email_sharing == "no") echo "selected"; ?>>No, do not share my email address.</option>
                                </select>


                                <br>

                                <!-- Submit Button -->
                                <input type="submit" name="profile_change_button" value="Save Changes" class="mb-5">
                                <br>
                                <?php if (isset($message)) echo "<h1 style='color: blue;'>$message</h1>";
                                ?>
                            </form>
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