<?php

$username = $_SESSION['username'];
$finalDocument = "";

if (isset($_POST['submit-file'])) {
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
