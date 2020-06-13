<?php
require('../../config/config.php');
include("uploadHandling/ImageManipulator.php");

$username = $_SESSION['username'];
$finalImage = "";


// RESUME UPLOAD HANDLER
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




// PHOTO UPLOAD HANDLER
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['name'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');

    $email_check = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_array($email_check);
    $matched_user = $row['username'];

    if ($matched_user == "" || $matched_user == $userLoggedIn) {
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'uploads/images/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    //New image manipulation object
                    $im = new ImageManipulator($fileDestination);
                    
                    //croping algorithm
                    $lgDimmension =  max(round($im->getWidth()), round($im->getHeight()));
                    $smDimmension = min(round($im->getWidth()), round($im->getHeight()));

                    $getWidth = round($im->getWidth());
                    $getHeight = round($im->getHeight());

                    $x1 = 0;
                    $x2 = 0;
                    $y1 = 100;
                    $y2 = 100;

                    if($getWidth === $lgDimmension) {
                        $x1 = ($getWidth - $getHeight)/2;
                        $y1 = 0;
                        $x2 = $getWidth - ($getWidth - $getHeight)/2;
                        $y2 = $getHeight;
                    } else if($getHeight === $lgDimmension) {
                        $x1 = 0;
                        $y1 = ($getHeight - $getWidth)/2;
                        $x2 = $getWidth;
                        $y2 = $getHeight - ($getHeight - $getWidth)/2;
                    }

                    //crop and save image to new folder
                    $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
                    $finalImage = 'uploads/cropped_images/' . $fileDestination;
                    $im->save($finalImage);

                    $query = mysqli_query($con, "UPDATE users SET profile_pic='$finalImage' WHERE username='$userLoggedIn'");
                    $message = "Details Updated";
                    header("Location: profile.php?uploadsuccess");
                } else {
                    echo "Your file is too big to upload, try smaller than 2MB.";
                }
            } else {
                echo "There was an error uploading your file.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    }
}

?>
