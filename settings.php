<?php
require 'config/config.php';
if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
include("includes/form_handlers/settings_handler.php");
?>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/owen-student-page.js"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/css/settings_style.css">

	<title>Owen Student Directory</title>
</head>

<body>

	<header>

		<!-- ATTENTION - RE-ADD FIXED TOP TO CLASSES BELOW, I ONLY OMIT BECAUSE OF ERROR CHECKING -->
		<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
			<a class="navbar-brand" href="./index.php">Owen Student Directory</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="./about.php">About <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./contact.php">Contact Us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color: goldenrod;" href="./register.php">Student Login/Register</a>
					</li>
				</ul>

			</div>
		</nav>
	</header>




	<div class="wrapper">
		<div class="settings-box">
			<div class="container-fluid main-column">
				<h4>Account Settings</h4>
				<?php
				echo "<img src='" . $user['profile_pic'] . "' class='small_profile_pic' style='max-width: 100%'>";
				?>
				<br>
				<a href="profile.php">Upload new profile picture</a> <br><br><br>

				<h4>Modify the values and click "Update Details</h4>
			</div>

			<div class=" container-fluid">
				<?php
				$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
				$row = mysqli_fetch_array($user_data_query);

				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$email = $row['email'];
				?>

				<form action="settings.php" method="POST">
					First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>
					Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
					Email: <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input"><br>

					<?php echo $message; ?>

					<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
				</form>

				<h4>Change Password</h4>
				<form action="settings.php" method="POST">
					Old Password: <input type="password" name="old_password" id="settings_input"><br>
					New Password: <input type="password" name="new_password_1" id="settings_input"><br>
					New Password Again: <input type="password" name="new_password_2" id="settings_input"><br>

					<?php echo $password_message; ?>

					<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
				</form>

				<h4>Close Account</h4>
				<form action="settings.php" method="POST">
					<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
				</form>
			</div>

		</div>
	</div>


	<?php
	include("includes/footer.php");
	?>