<?php
include("includes/header.php");

if(isset($_GET['q'])) {
    $query = $_GET['q'];
}
else {
    $query = "";
}
?>




<div class="container-fluid">
	<div class="row">
		<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
			<div class="sidebar-sticky pt-3">
				<div class="user_details column">
					<!-- Profile Image -->
					<a class="profile-sidebar-image cropped"> <img src="<?php echo $user['profile_pic']; ?>" alt=""> </a>
				</div>
				<!-- Sidebar -->
				<!-- Shows up only if user is logged in -->
				<?php if (isset($_SESSION['username'])) {
					echo '
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <div class="nav-link">
                            <h5>
                                Welcome, ' . $user['first_name'] . ' ' . $user['last_name'] . '
                            </h5>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="' . $userLoggedIn . '">
                            <span data-feather="home"></span>
                            My Profile <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="includes/handlers/logout.php">
                            <span data-feather="file"></span>
                            Log Out
                        </a>
                    </li>
                </ul> ';
				} else {
					echo '
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <div class="nav-link">
                                <h5>
                                    Welcome, Guest!
                                </h5>
                                <p>
                                    If you are a student, be sure to register and create your account. To everyone else, hello and welcome to our site! If you have any issues, be sure to contact us to report any bugs you may run into.
                                </p>
                            </div>
                        </li>
                    </ul>
                '; }?>
			</div>
		</nav>


		<!-- Profiles -->
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-3">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-5" id="main-platform">
				<div class="container-fluid">


				</div>
				<!-- <h1 class="h2">Dashboard</h1> -->
			</div>
			<div class="table-responsive row pl-3 pr-3 justify-content-md-center">


				<?php
				if ($query != "") {

					$search = mysqli_real_escape_string($con, $query);

					$sql = "SELECT * FROM users WHERE
						(first_name LIKE '%$search%' OR
						last_name LIKE '%$search%' OR
						hometown LIKE '%$search%' OR
						owen_classof LIKE '%$search%' OR
						owen_program LIKE '%$search%' OR
						undergrad_institution LIKE '%$search%' OR
						undergrad_major LIKE '%$search%' OR
						fun_fact LIKE '%$search%' OR
						personal_statement LIKE '%$search%')
						AND user_closed='no'";

					$result = mysqli_query($con, $sql);
					$queryResult = mysqli_num_rows($result);
					$str = "";

					if ($queryResult > 0) {
						while ($row = mysqli_fetch_assoc($result)) {

							$profile_pic = $row['profile_pic'];
							$name = $row['first_name'] . ' ' . $row['last_name'];
							$username = $row['username'];
							$owen_classof = $row['owen_classof'];
							$owen_program = $row['owen_program'];

							$owen_classof_string = "";
							if ($owen_classof != 0) {
								$owen_classof_string = "Class of " . $owen_classof;
							} else {
								$owen_classof_string = "";
							}

							$personal_statement_string = "";
							if ($row['personal_statement'] != "") {
								$personal_statement_string = substr($row['personal_statement'], 0, 120) . ". . .";
							}

							$str .= "
							<div class='col-lg-4 col-md-6 col-xl-3' style='padding: 0;' >
								<div class='card' style='width: auto; margin: 1rem;'>
									<div class='card-body' style='padding: 0;' >
										<div class='post_profile_pic'>
											<a href='" . $username . "'>
												<img class='card-img-top' style='border-radius: 0; max-width: 100%; border: none;' src='$profile_pic' >
											</a>
										</div>
										<div style='padding: 1rem;'>
											<div class='poster_info'>
												<a href='" . $username . "'> $name </a>
												<br>
												<p>$owen_program</p>
												<p>$owen_classof_string</p>
											</div>
											<div class='card_body'>
												<p>$personal_statement_string</p> 
											</div>
										</div>
									</div>
								</div> 
							</div>
							";
						}
						echo " <div class='profile_post row'> $str </div>";
					} else {
						echo "<div class='card'><h5 style='text-align: center;'>No results found.</h5></div>";
					}
				} else {
					echo "<div class='card'><h5 style='text-align: center;'>You must enter something in the search box.</h5></div>";
				}
				?>
			</div>
		</main>
	</div>
</div>