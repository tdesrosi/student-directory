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

if (isset($_POST['profile_change_button']) || isset($_POST['submit-file'])) {

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


//File-Upload System
$finalDocument = "";

if (isset($_POST['submit-file']) || isset($_POST['profile_change_button'])) {
    $file = $_FILES['resume'];
    $fileName = $_FILES['resume']['name'];
    $fileTmpName = $_FILES['resume']['tmp_name'];
    $fileSize = $_FILES['resume']['size'];
    $fileError = $_FILES['resume']['error'];
    $fileType = $_FILES['resume']['name'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('doc', 'docx', 'pdf');

    $email_check = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($email_check);
    $matched_user = $row['username'];

    if ($matched_user == "" || $matched_user == $userLoggedIn) {
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {

                    //s3 Bucketeer
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                        // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                        try {
                            // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                            $upload = $s3->upload($bucket, $_FILES['userfile']['name'], fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
?>
                            <p>Upload <a href="<?= htmlspecialchars($upload->get('ObjectURL')) ?>">successful</a> :)</p>
                        <?php } catch (Exception $e) { ?>
                            <p>Upload error :(</p>
<?php }
                    }


                    $fileNameNew = $username . "." . $fileActualExt;
                    $fileDestination = 'uploads/documents/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $query = mysqli_query($con, "UPDATE users SET resume_='$fileDestination' WHERE username='$userLoggedIn'");
                    $message = "Details Updated";
                    header("Location: profile.php?uploadsuccess");
                } else {
                    echo "Your file is too big to upload, try smaller than 1MB.";
                }
            } else {
                echo "There was an error uploading your file.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    }
}
