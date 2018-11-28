<?php
	include_once 'phpsqlsearch_dbinfo.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="styles.css" type="text/css"/>
	<title>Community Helper Organization Login</title>
</head>
<body>
	<?php
		$organizationID = $_GET['organizationID'];
		//Connect to database
		$link = mysql_connect($hostname, $username, $password);

		//If connection fails
		if(!$link){
				die("Connection Error:".mysql_error());
		}

		$db_selected = mysql_select_db($database,$link);
	?>

	<!--Navigation Bar and Background-->
		<div class="wrapper">
			<header>
					<img src="rsz_cmlogo.jpg"/>
				<nav>
					<ul>
						<li><a href="landingPage.php">Home</a></li>
						<li><a href="userInitialForm.php">Donate</a></li>
						<li><a href="organizationSignUp.php">Create Organization Account </a></li>
						<li><a href="organizationSignIn.php" class="current">Organization Sign-In </a></li>
					</ul>
				</nav>
			</header>

			<div id="signIncontainer">
				<div class="box">
					<h2>Organization Login</h2>
				</div>

				<form action="organizationSignIn.php" method="post">
					<div class="SignIn">
						<label for="phone"><b>Phone Number</b></label>
						<input type="int" placeholder="Enter Phone Number" name="phone" required>

						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required>

						<button type="submit" name="submit"> Login</button>
					</div>
				</form>
			</div>
		</div>
<?php
	$conn = new mysqli($hostname, $username, $password, $database)
		or die('Cannot connect to database');
		if(isset($_POST['submit'])){
			$sql= "SELECT id
				 	 	 FROM organizations
					 	 WHERE email = '$_POST[phone]' AND password = '$_POST[psw]'";

			if(mysqli_query($conn,$sql)){
				echo "<a href = 'organizationLanding.php?id="      "'>Go to Organization Homepage</a>";
			}
			else {
				echo "Inncorrect Email and/or Password";
			}
		}
 ?>


		<footer>
			<h3>Group 26 Project</h3>
		</footer>
	</div>
</body>
</html>
