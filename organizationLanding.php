<?php
	include_once 'phpsqlsearch_dbinfo.php';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
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
  
  <h1>Organization's Tickets</h1>
    <table>
      <tr>
        <th>Ticket Number</th>
        <th>Donor First Name</th>
        <th>Donor Last Name</th>
        <th>Donor Email</th>
        <th>Need Description</th>
        <th>Need Type</th>
        <th>Lattitude</th>
        <th>Longitude</th>
        <th>Donation Use</th>
        <th>Ticket Status</th>
        <th>Email Status</th>
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
      echo "<td>".$row['ticketID']."</td>";
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
      echo "<td><a href = 'ticketEdit.php?ticketNumber=".$row['id']."'>Edit</a></td>";
      echo "</tr>";
    }

   ?>
 </table>
