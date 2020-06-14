<?php
include("includes/header.php");
require("includes/form_handlers/uploadHandling/ImageManipulator.php");
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-1',
]);

use \Gumlet\ImageResize;


$bucket = $_SERVER['BUCKETEER_BUCKET_NAME'] ?: die('No "S3_BUCKET" config var in found in env!');
$finalImage = "";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: register.php");
}

?>


<div style="width: 100%; height: 100%; ">
    <div class="container-fluid" style="padding: 20px auto; ">
        <div class="card col-lg-6" style="margin: 10% auto; min-width: 500px; text-align: center;">
            <div class="contents" style="padding: 2%">
                <h3>Manage Documents</h3>
                <br>
                <p>Submit your profile picture and resume here. Photos can only be in .png, .jpg, or .jpeg formats. Resumes can only be in .doc, .docx, and .pdf formats. When finished, click the button at the bottom to go back to your profile page.</p>
                <br>


                <!-- PHOTO UPLOAD SYSTEM -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photoUpload']) && $_FILES['photoUpload']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photoUpload']['tmp_name'])) {
                    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    $file = $_FILES['photoUpload'];
                    $fileName = $_FILES['photoUpload']['name'];
                    $fileTmpName = $_FILES['photoUpload']['tmp_name'];
                    $fileSize = $_FILES['photoUpload']['size'];
                    $fileError = $_FILES['photoUpload']['error'];
                    $fileType = $_FILES['photoUpload']['name'];
                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));
                    $allowed = array('png', 'jpg', 'jpeg');
                    var_dump($file);

                    $email_check = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $row = mysqli_fetch_array($email_check);
                    $matched_user = $row['username'];

                    if ($matched_user == "" || $matched_user == $userLoggedIn) {
                        if (in_array($fileActualExt, $allowed)) {
                            if ($fileError === 0) {
                                if ($fileSize < 2000000) {
                                    try {
                                        $croppedImage = new ImageResize($fileTmpName);
                                        $croppedImage->crop(1000, 1000, true, ImageResize::CROPCENTER);
                                        $croppedImage->save($fileTmpName);
                                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                                        $initialUpload = $s3->upload($bucket, $fileName, fopen($fileTmpName, 'rb'), 'public-read');
                                        $fileDestination = htmlspecialchars($initialUpload->get('ObjectURL'));
                                        $query = mysqli_query($con, "UPDATE users SET profile_pic='$fileDestination' WHERE username='$userLoggedIn'");

                                        ?>
                                        <p>Initial Upload <a href="<?= htmlspecialchars($initialUpload->get('ObjectURL')) ?>">successful</a> :)</p>
                                    <?php   header("Location: profile.php?uploadsuccess");
                                    } catch (Exception $e) { ?>
                                        <p>Initial Upload error :(</p>
                                     <?php }
                                } else
                                    echo "Your file is too big to upload, try smaller than 1MB.";
                            } else
                                echo "There was an error uploading your file.";
                        } else {
                            echo "You cannot upload files of this type.";
                        }
                    }
                }
                ?>

                <!-- RESUME UPLOAD SYSTEM -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resumeUpload']) && $_FILES['resumeUpload']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['resumeUpload']['tmp_name'])) {
                    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    $file = $_FILES['resumeUpload'];
                    $fileName = $_FILES['resumeUpload']['name'];
                    $fileTmpName = $_FILES['resumeUpload']['tmp_name'];
                    $fileSize = $_FILES['resumeUpload']['size'];
                    $fileError = $_FILES['resumeUpload']['error'];
                    $fileType = $_FILES['resumeUpload']['name'];
                    var_dump($file);
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
                                    //try uploading into bucket
                                    try {
                                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                                        $upload = $s3->upload($bucket, $fileName, fopen($fileTmpName, 'rb'), 'public-read');
                                        $fileDestination = htmlspecialchars($upload->get('ObjectURL'));
                                        $query = mysqli_query($con, "UPDATE users SET resume_='$fileDestination' WHERE username='$userLoggedIn'");
                ?>
                                        <p>Upload <a href="<?= htmlspecialchars($upload->get('ObjectURL')) ?>">successful</a> :)</p>
                                    <?php
                                        header("Location: profile.php?uploadsuccess");
                                    } catch (Exception $e) { ?>
                                        <p>Upload error :(</p>
                <?php }
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
                ?>






                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <!-- UPLOAD PROFILE IMAGE HERE -->
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile1" name="photoUpload">
                            <label class="custom-file-label" for="inputGroupFile1">Choose Profile Picture</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" value="Upload">Sumbit File</button>
                        </div>
                    </div>
                </form>
                <!-- UPLOAD RESUME HERE -->
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile2" name="resumeUpload">
                            <label class="custom-file-label" for="inputGroupFile2">Upload Resume</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" value="Upload">Sumbit File</button>
                        </div>
                    </div>
                </form>

                <br>
                <a class="btn btn-outline-warning" href="<?php echo $userLoggedIn ?>">Done!</a>

            </div>
        </div>
    </div>
</div>




<?php
include("includes/footer.php");
?>