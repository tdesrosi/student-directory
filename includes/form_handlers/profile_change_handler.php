<?php

$username = $_SESSION['username'];
$hometown = "";
$owen_classof = 0;
$owen_program = "";
$undergrad_institution = "";
$undergrad_major = "";
$fun_fact = "";
$social_media = "";
$resume_ = "";
$personal_statement = "";
$phone_number = "";
$error_array = array();

if (isset($_POST['profile_change_button'])) {

    //Registration form values
    $hometown = strip_tags($_POST['reg_hometown']); //remove tags
    $_SESSION['reg_hometown'] = $hometown; //stores first name into session var

    $owen_classof = strip_tags($_POST['reg_owen_classof']);
    $_SESSION['reg_owen_classof'] = $owen_classof;

    $owen_program = strip_tags($_POST['reg_owen_program']);
    $_SESSION['reg_owen_program'] = $owen_program;

    $undergrad_institution = strip_tags($_POST['reg_undergrad_institution']);
    $_SESSION['reg_undergrad_institution'] = $undergrad_institution;

    $undergrad_major = strip_tags($_POST['reg_undergrad_major']);
    $_SESSION['reg_undergrad_major'] = $undergrad_major;

    $fun_fact = strip_tags($_POST['reg_fun_fact']);
    $fun_fact = str_replace('\n\r', '\n', $fun_fact);
    $_SESSION['reg_fun_fact'] = $fun_fact;

    $social_media = strip_tags($_POST['reg_social_media']);
    $_SESSION['reg_social_media'] = $social_media;

    $resume_ = strip_tags($_POST['reg_resume_']);
    $_SESSION['reg_resume_'] = $resume_;

    $personal_statement = strip_tags($_POST['reg_personal_statement']);
    $personal_statement = str_replace('\n\r', '\n', $personal_statement);
    $_SESSION['reg_personal_statement'] = $personal_statement;

    $phone_number = strip_tags($_POST['reg_phone_number']);
    $_SESSION['reg_phone_number'] = $phone_number;

    $email_sharing = strip_tags($_POST['reg_email_sharing']);
    $_SESSION['reg_email_sharing'] = $email_sharing;

    $email_check = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($email_check);
    $matched_user = $row['username'];

    // //Handle Errors
    // if (strlen($hometown > 60 || strlen($hometown) < 3)) {
    //     array_push($error_array, "You must enter a valid name");
    // }
    // if ($owen_classof >= 2050 || $owen_classof <= 2020) {
    //     array_push($error_array, "You must enter a valid year");
    // }

    if ($matched_user == "" || $matched_user == $userLoggedIn) {
        $message = "Details Updated";
        $query = mysqli_query($con, "UPDATE users SET
            email_sharing='$email_sharing',
            hometown='$hometown',
            owen_classof='$owen_classof',
            owen_program='$owen_program',
            undergrad_institution='$undergrad_institution',
            undergrad_major='$undergrad_major',
            fun_fact='$fun_fact',
            social_media='$social_media',
            resume_='$resume_',
            personal_statement='$personal_statement',
            phone_number='$phone_number'
            WHERE username='$userLoggedIn'
        ");
    } else $message = "That email is already in use!<br><br>";
} else $nmessage = "Details not updated successfully";

