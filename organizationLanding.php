<?php
	include_once 'phpsqlsearch_dbinfo.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
			<meta charset="utf-8"/>
			<link rel="stylesheet" href="styles.css" type="text/css"/>
			<title> Organization Landing Page </title>
	</head>
	<body>

  <?php
    $organizationID = $_GET['id'];
    //Connect to database
    $link = mysql_connect($hostname, $username, $password);

    //If connection fails
    if(!$link){
        die("Connection Error:".mysql_error());
    }

    $db_selected = mysql_select_db($database,$link);
  ?>

    <div class="wrapper">
      <header>
        <img src="rsz_cmlogo.jpg"/>
        <nav>
          <ul>
            <li><a href="landingPage.php">Home</a></li>
						<?php
						echo "<li><a href = 'organizationEdit.php?organizationID=".$organizationID."'>Edit Account</a></li>";
						?>
          </ul>
        </nav>
      </header>
		</div>

		<div class= "ticketbox">
				<h1>Organization's Tickets</h1>

    <table id="tickets">
      <tr>
        <th>Ticket ID</th>
        <th>Donor First Name</th>
        <th>Donor Last Name</th>
        <th>Donor Email</th>
        <th>Need Description</th>
        <th>Need Type</th>
        <th>Lattitude</th>
        <th>Longitude</th>
        <th>Donation Use</th>
        <th>Donation Confirmed?</th>
        <th>Email Sent?</th>
        <th>Edit</th>
      </tr>
  <?php

    $conn = new mysqli($hostname, $username, $password, $database)
      or die('Cannot connect to database');


    $result = $conn->query("SELECT ticket_status.id, ticket.firstName, ticket.lastName, ticket.email,
     ticket.description, ticket.needType, ticket.lattitude, ticket.longitude, ticket_status.useDescription, ticket_status.status, ticket_status.emailSent
     FROM ticket_status
     INNER JOIN ticket ON ticket_status.ticketID = ticket.id
     WHERE ticket_status.organizationID = '$organizationID' ");


    while($row = mysqli_fetch_assoc($result)){
      echo "<tr>";
      echo "<td>".$row['id']."</td>";
      echo "<td>".$row['firstName']."</td>";
      echo "<td>".$row['lastName']."</td>";
      echo "<td>".$row['email']."</td>";
      echo "<td>".$row['description']."</td>";
      echo "<td>".$row['needType']."</td>";
      echo "<td>".$row['lattitude']."</td>";
      echo "<td>".$row['longitude']."</td>";
      echo "<td>".$row['useDescription']."</td>";
      echo "<td>".$row['status']."</td>";
      echo "<td>".$row['emailSent']."</td>";
      echo "<td><a href = 'ticketEdit.php?ticketNumber=".$row['id']."&organizationID=".$organizationID."'>Edit</a></td>";
      echo "</tr>";
    }

   ?>
 </table>

		</div>
		<footer>
			<h3>Group 26 Project</h3>
		</footer>
	</body>
</html>
