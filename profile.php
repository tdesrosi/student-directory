<?php
// include("includes/classes/Profile.php");
include("includes/header.php");
//include("includes/classes/Profile.php");
include("includes/form_handlers/profile_change_handler.php");
include("includes/form_handlers/upload_picture_handler.php");

if (isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    // $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    // $user_array = mysqli_fetch_array($user_details_query);

    if ($username != $userLoggedIn) {
        $headerRedirect = "Location: user.php/?profile_username=" . $username;
        header($headerRedirect);
    }
}



?>
<link rel="stylesheet" href="https://unpkg.com/jcrop/dist/jcrop.css">
<link rel="stylesheet" href="assets/css/profile_style.css">

<h1 class="hidden">This is a profile page.</h1>

<div class="wrapper">
    <div class="profile-box">
        <div class="profile-header border-bottom">
            <div class="container-fluid" style="width: 75%; margin: 20px 12.5%;">
                <h1 class="heading">
                    <?php
                    if (isset($_SESSION['username'])) echo 'Welcome, ' . $user['first_name'] . ' ' . $user['last_name'];
                    ?>
                </h1>
                <h4>Personalize your profile below:</h4>
                <br>
            </div>
            <br>
            <div style="width: 75%; margin: 20px 12.5%;" class="container">
                <img src="<?php echo $user['profile_pic']; ?>" alt="" style="width: 50%; height: 37.5%; border-radius: 0;">
                <br>
            </div>
            <div style="width: 75%; margin: 80px 12.5%;" class="container">
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="file">
                        <label class="custom-file-label" for="customFile">Change Picture</label>
                        <input type="submit" style="display: block;" name="submit" value="Submit new image">
                    </div>

                    <script>
                        //Name of file shows up on select
                        $(".custom-file-input").on("change", function() {
                            var fileName = $(this).val().split("\\").pop();
                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                    </script>
                </form>
            </div>
            <br>
        </div>

        <div class="container mt-4">

            <?php
            $username = $_SESSION['username'];
            $user_data_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
            $row = mysqli_fetch_array($user_data_query);

            $email_sharing = $row['email_sharing'];
            $profile_poc = $row['profile_pic'];
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
            ?>

            <!-- Owen Class Section -->
            <div class="heading container-fluid" style="width: 75%; margin: 20px 12.5%; text-align: center;">
                <br>
                <h1>
                    Update your Profile Information Below:
                </h1>
                <br>
                <h4>
                    Keep in mind, nothing here is required. Feel free to add and leave out what you like! However, a bare profile never looks good...
                </h4>
                <br>
            </div>

            <form action="profile.php" method="POST" class="form-group" name="main-form" enctype="multipart/form-data">
                <label for="reg_owen_classof">What year do you graduate from Owen?</label>
                <input type="number" name="reg_owen_classof" placeholder="Owen Graduation Year" value="<?php echo $owen_classof ?>">
                <br>

                <!-- Owen Program -->
                <label for="reg_owen_program">What's your program at Owen?</label>
                <br>

                <select name="reg_owen_program" class="form-control text-center" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;" placeholder="What program are you a part of?">
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
                <label for="reg_fun_fact">Share a fun fact about yourself</label>
                <br>
                <textarea rows="5" name="reg_fun_fact" placeholder="Got any fun facts?"><?php echo $fun_fact; ?></textarea>
                <br>
                <!-- NOTICE THIS IS THE SOCIAL MEDIA FORM, FOR NOW, I'LL KEEP IT JUST TO LINKEDIN TO AVOID DEALING WITH ARRAYS -->
                <label for="reg_social_media"> Add a link to your Linkedin Profile:</label>
                <br>
                <input type="text" name="reg_social_media" placeholder="Linkedin Profile URL" value="<?php echo $social_media; ?>">


                <br>
                <!-- Phone Number -->
                <label for="reg_phone_number">Would you like to share your phone number?</label>
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
                <br>
                <!-- UPLOAD RESUME HERE -->
                <label for="resume"> Please upload a copy of your resume.</label>
                <br>

                <div class="custom-file" style="width: 75%; margin-right: 12.5%; margin-left: 12.5%;">
                    <input type="file" class="custom-file-input" id="customResume" name="resume">
                    <label class="custom-file-label" for="customResume">Upload Resume</label>
                    <input type="submit" style="display: block; text-align: center;" name="submit-file" value="Submit new File">
                </div>

                <script>
                    //Name of file shows up on select
                    $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                </script>
                <br>
                <?php
                if (isset($message)) echo "
                    <h1 style='color: blue;'>$message</h1>
                    "
                ?>
            </form>
        </div>
    </div>
</div>


<?php
include("includes/footer.php")
?>