<?php
include("includes/header.php");
require("includes/form_handlers/uploadHandling/ImageManipulator.php");
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-1',
]);
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

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photoUpload']) && $_FILES['photoUpload']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photoUpload']['tmp_name'])) {
                    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    $file = $_FILES['photoUpload'];
                    $fileName = $_FILES['photoUpload']['name'];
                    $fileTmpName = $_FILES['photoUpload']['tmp_name'];
                    $fileSize = $_FILES['photoUpload']['size'];
                    $fileError = $_FILES['photoUpload']['error'];
                    $fileType = $_FILES['photoUpload']['name'];
                    var_dump($file);
                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));
                    $allowed = array('png', 'jpg', 'jpeg');

                    $email_check = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $row = mysqli_fetch_array($email_check);
                    $matched_user = $row['username'];

                    if ($matched_user == "" || $matched_user == $userLoggedIn) {
                        if (in_array($fileActualExt, $allowed)) {
                            if ($fileError === 0) {
                                if ($fileSize < 2000000) {
                                    try {
                                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                                        $initialUpload = $s3->upload($bucket, $fileName, fopen($fileTmpName, 'rb'), 'public-read');
                                        $initialPhotoDestination = htmlspecialchars($initialUpload->get('ObjectURL'));
                                        //New image manipulation object
                                        //Have to manipulate and then reupload to bucket
                                        $im = new ImageManipulator("https://www.google.com/url?sa=i&url=https%3A%2F%2Ftechcrunch.com%2F2015%2F12%2F01%2Fgoogle-turns-image-search-into-pinterest-with-new-collections-feature%2F&psig=AOvVaw1wBfjahvfzGhDM3nptxnEb&ust=1592161070943000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCLCNxKu8_-kCFQAAAAAdAAAAABAD");
                                        //croping algorithm
                                        $lgDimmension =  max(round($im->getWidth()), round($im->getHeight()));
                                        $smDimmension = min(round($im->getWidth()), round($im->getHeight()));

                                        $getWidth = round($im->getWidth());
                                        $getHeight = round($im->getHeight());

                                        $x1 = 0;
                                        $x2 = 0;
                                        $y1 = 100;
                                        $y2 = 100;

                                        if ($getWidth === $lgDimmension) {
                                            $x1 = ($getWidth - $getHeight) / 2;
                                            $y1 = 0;
                                            $x2 = $getWidth - ($getWidth - $getHeight) / 2;
                                            $y2 = $getHeight;
                                        } else if ($getHeight === $lgDimmension) {
                                            $x1 = 0;
                                            $y1 = ($getHeight - $getWidth) / 2;
                                            $x2 = $getWidth;
                                            $y2 = $getHeight - ($getHeight - $getWidth) / 2;
                                        }

                                        //crop and save image to new folder
                                        $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
                                        $im->save($nitialPhotoDestination);
                                        echo $initialPhotoDestination;
                                        var_dump($im);
                                        //try uploading into bucket again, after cropping
                                        try {
                                            // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                                            $finalUpload = $s3->upload($bucket, $fileName, fopen($initialPhotoDestination, 'rb'), 'public-read');
                                            $croppedPhotoDestination = htmlspecialchars($finalUpload->get('ObjectURL'));
                                            echo $croppedPhotoDestination;
                                            $query = mysqli_query($con, "UPDATE users SET profile_pic='$croppedPhotoDestination' WHERE username='$userLoggedIn'");
                ?>
                                            <p>Final Upload <a href="<?= htmlspecialchars($finalUpload->get('ObjectURL')) ?>">successful</a> :)</p>
                                        <?php
                                            header("Location: profile.php?uploadsuccess");
                                        } catch (Exception $e) { ?>
                                            <p>Final Upload error :(</p>
                                        <?php }

                                        ?>
                                        <p>Initial Upload <a href="<?= htmlspecialchars($initalUpload->get('ObjectURL')) ?>">successful</a> :)</p>
                                    <?php
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