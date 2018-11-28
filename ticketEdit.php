<?php
	include_once 'phpsqlsearch_dbinfo.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" />
    <title>Describe Need</title>
  </head>
  <body>
    <?php

		$ticketNumber = $_GET['ticketNumber'];

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
            <li><a href="userInitialForm.php" class="current">Donate</a></li>
          </ul>
        </nav>
      </header>
    </div>

    <!-- Form adapted from https://www.w3schools.com/howto/howto_css_responsive_form.asp -->
    <div class="containerForm">
      <form action = "ticketEdit.php" method = "post">
        <div class="row">
          <div class="col-25">
            <label for="Status">Status:</label>
          </div>
          <div class="col-75">
            <label>Confirmed</label>
            <input type ="radio" name="status" value="Yes">
            <label>Not Confirmed</label>
            <input type ="radio" name="status" value="No"><br>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="Status">Description Use:</label>
          </div>
          <div class="col-75">
            <input type = "text" id="descriptionUse" name="descriptionUse">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="Status">Email Sent:</label>
          </div>
          <div class="col-75">
            <label>Yes</label>
            <input type ="radio" name="emailSent" value="Yes">
            <label>No</label>
            <input type ="radio" name="emailSent" value="No"><br>
          </div>
        </div>
        <div class="row">
          <input type ="submit" name="Submit"><br>
        </div>
      </form>
    </div>

    <?php
      if(isset($_POST['Submit'])){
        $query= "UPDATE `ticket_status` SET `status`='$_POST[status]', `useDescription`='$_POST[descriptionUse]', `emailSent`='$_POST[emailSent]' WHERE id = $ticketNumber";

        //If query fails
        if(!mysql_query($query)){
          die('Error:'.mysql_error());
        }
        else{
          $ticketUpdated = "Ticket Updated";
          echo $ticketUpdated;
        }

      }
    ?>

    <!--redirect to organizationLanding.php -->
    <script type="text/javascript">
      var posted = "<?php echo $ticketUpdated ?>";
      if(posted === "Ticket Updated"){
        location.href = 'organizationLanding.php';

      }
    </script>
  </body>
</html>
