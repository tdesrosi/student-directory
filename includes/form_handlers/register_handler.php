<?php
//Declaring Vars to prevent errors

$fName = "";
$lName = "";
$email = "";
$email2 = "";
$pw = "";
$pw2 = "";
$date = "";
$error_array = array();

if(isset($_POST['register_button'])){

    //Registration form values
    $fName = strip_tags($_POST['reg_fName']); //remove tags
    $fName = str_replace(' ', '', $fName); //remove spaces
    $fName = ucfirst(strtolower($fName)); //uppercase first letter
    $_SESSION['reg_fName'] = $fName; //stores first name into session var

    $lName = strip_tags($_POST['reg_lName']); //remove tags
    $lName = str_replace(' ', '', $lName); //remove spaces
    $lName = ucfirst(strtolower($lName)); //uppercase first letter
    $_SESSION['reg_lName'] = $lName; //stores first name into session var

    $email = strip_tags($_POST['reg_email']); //remove tags
    $email = str_replace(' ', '', $email); //remove spaces
    $email = ucfirst(strtolower($email)); //uppercase first letter
    $_SESSION['reg_email'] = $email; //stores first name into session var

    $email2 = strip_tags($_POST['reg_email2']); //remove tags
    $email2 = str_replace(' ', '', $email2); //remove spaces
    $email2 = ucfirst(strtolower($email2)); //uppercase first letter
    $_SESSION['reg_email2'] = $email2; //stores first name into session var

    $pw = strip_tags($_POST['reg_password']); //remove tags
    $pw2 = strip_tags($_POST['reg_password2']); //remove tags
   
    $date = date("Y-m-d"); //gets current date
    $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';

    if($email == $email2) {
        //check if email is valid format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            //Check if email exists already
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

            //Count Number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }
            
        } else {
            array_push($error_array, "Invalid email format<br>");
        }
    } else {
        array_push($error_array, "Emails don't match<br>");
    }

    if(strlen($fName) > 25 || strlen($fName) <2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }

    if(strlen($lName) > 25 || strlen($lName) <2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }

    if($pw != $pw2){
        array_push($error_array, "Your passwords do not match<br>");
    } else {
        if (preg_match($pattern, $pw) === false) { 
            array_push($error_array, "Your password can only contain English characters or numbers<br>");
        }  
    }

    if(strlen($pw > 30 || strlen($pw) < 8)) {
        array_push($error_array, "Your password must be between 8 and 30 characters<br>");
    }

    if(empty($error_array)) {
        //encrypt before sending to db
        $hashed_password = password_hash($pw, PASSWORD_DEFAULT);
        //generate username by concatenating first/last name
        $username = strtolower($fName . "_" . $lName);
        $check_username_query  =mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        $i = 0;
        //if username exists add number to username
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        //profile picture assignment
        $profile_pic = "assets/images/profile_pics/defaults/profile_default.png";

        //insert new user
        $query = mysqli_query($con, "INSERT INTO users VALUES (NULL, '$fName', '$lName', '$username', '$email', 'yes', '$hashed_password', '$date', '$profile_pic', 'no', '', '0', '', '', '', '', '', '', '', '', 'no')");
        
        array_push($error_array, "<span style='color: #14C800;'>You're all set! Goahead and login!</span><br>");

        //Clear session variables 
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
    }

}
?>