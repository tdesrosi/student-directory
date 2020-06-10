<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
    <title>Welcome to Owen Directory!</title>
</head>

<body>

    <?php
    if (isset($_POST['register_button'])) {
        echo '
            <script>
            $(document).ready(function(){
                $("#first").hide();
                $("#second").show();
            }) 
            </script>
            ';
    }


    ?>

    <div class="wrapper">
        <div class="login-box">
            <div class="login-header">
                <h1>Owen Student Directory</h1>
                <h3>Login or Sign up below!</h3>

            </div>

            <div id="first">
                <!-- LOGIN FORM -->
                <form action="register.php" method="POST">
                    <input type="email" name="log_email" placeholder="Email Address" value="<?php if (isset($_SESSION['log_email'])) {
                                                                                                echo $_SESSION['log_email'];
                                                                                            } ?>" required>
                    <br>
                    <input type="password" name="log_password" placeholder="Password">
                    <br>
                    <input type="submit" name="login_button" value="Login">
                    <br>

                    <?php if (in_array("Email or password was incorrect<br>", $error_array))
                        echo "Email or password was incorrect<br>"
                    ?>
                    <a href="#" id="signup">Need an account? Register Here!</a>

                </form>
            </div>

            <div id="second">
                <!-- REGISTER FORM -->
                <form action="register.php" method="POST">
                    <!-- first name -->
                    <input type="text" name="reg_fName" placeholder="First Name" value="<?php if (isset($_SESSION['reg_fName'])) {
                                                                                            echo $_SESSION['reg_fName'];
                                                                                        } ?>" required>
                    <br>
                    <?php if (in_array("Your first name must be between 2 and 25 characters<br>", $error_array))
                        echo "Your first name must be between 2 and 25 characters<br>"; ?>

                    <!-- last name -->
                    <input type="text" name="reg_lName" placeholder="Last Name" value="<?php if (isset($_SESSION['reg_lName'])) {
                                                                                            echo $_SESSION['reg_lName'];
                                                                                        } ?>" required>
                    <br>
                    <?php if (in_array("Your last name must be between 2 and 25 characters<br>", $error_array))
                        echo "Your last name must be between 2 and 25 characters<br>"; ?>

                    <!-- email input -->
                    <input type="email" name="reg_email" placeholder="Email Address" value="<?php if (isset($_SESSION['reg_email'])) {
                                                                                                echo $_SESSION['reg_email'];
                                                                                            } ?>" required>
                    <br>

                    <!-- email input -->
                    <input type="email" name="reg_email2" placeholder="Confirm Email Address" value="<?php if (isset($_SESSION['reg_email2'])) {
                                                                                                            echo $_SESSION['reg_email2'];
                                                                                                        } ?>" required>
                    <br>
                    <?php if (in_array("Email already in use<br>", $error_array))
                        echo "Email already in use<br>";
                    else if (in_array("Invalid email format<br>", $error_array))
                        echo "Invalid email format<br>";
                    else if (in_array("Emails don't match<br>", $error_array))
                        echo "Emails don't match<br>"; ?>



                    <!-- password input -->
                    <input type="password" name="reg_password" placeholder="Password" required>
                    <br>

                    <!-- password input -->
                    <input type="password" name="reg_password2" placeholder="Confirm Password" required>
                    <br>
                    <?php if (in_array("Your passwords do not match<br>", $error_array))
                        echo "Your passwords do not match<br>";
                    else if (in_array("Your password can only contain english characters or numbers<br>", $error_array))
                        echo "Your password can only contain english characters or numbers<br>";
                    else if (in_array("Your password must be between 8 and 30 characters<br>", $error_array))
                        echo "Your password must be between 8 and 30 characters<br>"; ?>


                

                    <!-- submit button -->
                    <input type="submit" name="register_button" value="Register">
                    <br>

                    <?php
                    if (in_array("<span style='color: #14C800;'>You're all set! Goahead and login!</span><br>", $error_array))
                        echo "<span style='color: #14C800;'>You're all set! Goahead and login!</span><br>";
                    ?>

                    <h3><a href="#" id="signin" class="">Already have an account? Sign In here!</a></h3>

                </form>
            </div>
        </div>
    </div>



    
<?php
require "includes/footer.php";
?> 