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
					<h2>Organization Sign-In</h2>
				</div>

				<form action="organizationSignIn.php" method="post">
					<div class="SignIn">
						<label for="phone"><b>Phone Number</b></label><br>
						<input type="int" placeholder="Enter Phone Number" name="phone" required><br>

						<label for="psw"><b>Password</label></b>
						<input type="password" placeholder="Enter Password" name="psw" required>

						<button type="submit" name="submit"> Login</button>
					</div>
				</form>
			</div>
		</div>
<?php

		if(isset($_POST['submit'])){
			$result = mysql_query("SELECT `id`
				 	FROM `organizations`
					WHERE `phone` = '$_POST[phone]' AND `password` = '$_POST[psw]'");

			$row = mysql_fetch_array($result);

			if($row['id'] > 0){
				echo "<a href= 'organizationLanding.php?id=".$row['id']."'>Go to Organization Homepage</a>";
			}

			else {
				echo "Inncorrect Email and/or Password";
			}
		}

 ?>


		<footer>
			<h3>Group 26 Project</h3>
		</footer>

</body>
</html>
