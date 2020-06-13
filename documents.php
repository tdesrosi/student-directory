<?php
include("includes/header.php");
?>


<div style="width: 100%; height: 100%; ">
    <div class="container-fluid" style="padding: 20px auto; ">
        <div class="card" style="margin: 10% auto; max-width: 500px; text-align: center;">
            <div class="contents" style="padding: 2%">
                <h3>Manage Documents</h3>
                <p>Submit your profile picture and resume here. Photos can only be in .png, .jpg, or .jpeg formats. Resumes can only be in .doc, .docx, and .pdf formats. When finished, click the button at the bottom to go back to your profile page.</p>
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <!-- UPLOAD PROFILE IMAGE HERE -->
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">Choose Profile Picture</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">Sumbit File</button>
                        </div>
                    </div>
                </form>
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <!-- UPLOAD RESUME HERE -->
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">Upload Resume</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">Sumbit File</button>
                        </div>
                    </div>
                </form>
                <a class="btn btn-outline-warning" href="<?php echo $userLoggedIn ?>">Done!</a>

            </div>
        </div>
    </div>
</div>




<?php
include("includes/footer.php");
?>