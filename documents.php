<?php
include("includes/header.php");
require('vendor/autoload.php');
// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = new Aws\S3\S3Client([
    'version'  => '2006-03-01',
    'region'   => 'us-east-1',
]);
$bucket = $_SERVER['BUCKETEER_BUCKET_NAME'] ?: die('No "S3_BUCKET" config var in found in env!');

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
                    try {
                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                        $upload = $s3->upload($bucket, $_FILES['photoUpload']['name'], fopen($_FILES['photoUpload']['tmp_name'], 'rb'), 'public-read');
                ?>
                        <p>Upload <a href="<?= htmlspecialchars($upload->get('ObjectURL')) ?>">successful</a> :)</p>
                    <?php } catch (Exception $e) { ?>
                        <p>Upload error :(</p>
                <?php }
                } ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resumeUpload']) && $_FILES['resumeUpload']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['resumeUpload']['tmp_name'])) {
                    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    try {
                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                        $upload = $s3->upload($bucket, $_FILES['resumeUpload']['name'], fopen($_FILES['resumeUpload']['tmp_name'], 'rb'), 'public-read');
                ?>
                        <p>Upload <a href="<?= htmlspecialchars($upload->get('ObjectURL')) ?>">successful</a> :)</p>
                    <?php } catch (Exception $e) { ?>
                        <p>Upload error :(</p>
                <?php }
                } ?>

                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                    <!-- UPLOAD PROFILE IMAGE HERE -->
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile04" name="photoUpload">
                            <label class="custom-file-label" for="inputGroupFile04">Choose Profile Picture</label>
                            <input type="submit" value="Upload">
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" value="Upload">Sumbit File</button>
                        </div>
                    </div>
                </form>
                <!-- UPLOAD RESUME HERE -->
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile04" name="resumeUpload">
                            <label class="custom-file-label" for="inputGroupFile04">Upload Resume</label>
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