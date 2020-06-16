<!-- TO COPY BELOW -->




<?php
include('includes/header.php');
include("includes/classes/Profile.php");
include("includes/form_handlers/settings_handler.php");

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}

$username = $_SESSION['username'];
$user_data_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
$row = mysqli_fetch_array($user_data_query);

$name = $row['first_name'] . " " . $row['last_name'];
$email_sharing = $row['email_sharing'];
$profile_pic = $row['profile_pic'];
$hometown = $row['hometown'];
$owen_classof = $row['owen_classof'];
$owen_program = $row['owen_program'];
$undergrad_institution = $row['undergrad_institution'];
$undergrad_major = $row['undergrad_major'];
$fun_fact = $row['fun_fact'];
$social_media = $row['social_media'];
$resume_ = $row['resume_'];
$personal_statement = $row['personal_statement'];
$phone_number = $row['phone_number'];
$signup_date = $row['signup_date'];


?>

<div style='margin: 7% 7%'>
	<div class='container-fluid row'>
		<div class='col-md-4'>
			<div class='card'>
				<div class='card-body' style='padding: 0;'>
					<div class='post_profile_pic'>
						<a href="documents.php">
							<img class='card-img-top' style="border-radius: 0;" src='<?php echo $profile_pic ?>'>
						</a>
					</div>
					<div style='padding: 1rem;'>
						<div class='poster_info'>
							<h3><?php echo $name ?></h3>
							<br>
							<br>
							<h6><small style='opacity: 0.4;'><i> Account Created on <?php echo $signup_date ?></i></small></h6>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='col-md-8'>
			<div class='card'>
				<div class='card-body' style='padding: 0;'>
					<div style='padding: 1rem; text-align: center;'>
						<div class='poster_info'>
							<h1>Hi! I'm <?php echo $row['first_name']; ?> </h1>
							<br>
							<h3>Use this page to edit your user details.</h3>
							<br>
							<a class="btn btn-outline-warning" href="documents.php">Change profile picture and upload a resume here!</a>
							<br>
							<br>
						</div>
						<div class='form-group'>
							<?php
							$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
							$row = mysqli_fetch_array($user_data_query);

							$first_name = $row['first_name'];
							$last_name = $row['last_name'];
							$email = $row['email'];
							?>

							<form action="settings.php" method="POST">

								<label for="first_name">First Name:</label>
								<br>
								<input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input">
								<br>
								<label for="last_name">Last Name:</label>
								<br>
								<input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input">
								<br>
								<label for="email">Email:</label>
								<br>
								<input type="text" name="email" value="<?php echo $email; ?>" id="settings_input">

								<?php echo $message; ?>
								<br>
								<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
								<br>
							</form>

							<h4>Change Password</h4>
							<form action="settings.php" method="POST">
								<label for="old_password">Old Password:</label>
								<br>
								<input type="password" name="old_password" id="settings_input">
								<br>
								<label for="new_password_1">New Password:</label>
								<br>
								<input type="password" name="new_password_1" id="settings_input">
								<br>
								<label for="new_password_2">Confirm New Password:</label>
								<br>
								<input type="password" name="new_password_2" id="settings_input">
								<br>

								<?php echo $password_message; ?>

								<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
							</form>

							<h4>Close Account</h4>
							<br>
							<form action="settings.php" method="POST">
								<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include("includes/footer.php");
?>