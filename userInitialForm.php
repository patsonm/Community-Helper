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
    <div class="serviceArea">
      <h3>We Currently Only Serve Seattle, WA Area</h3>
    </div>
    <form action = "userInitialForm.php" method = "post">
      <div class="row">
        <div class="col-25">
          <label for="firstName">First Name:</label>
        </div>
        <div class="col-75">
          <input type = "text" id="firstName" name="firstName">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="lastName">Last Name:</label>
        </div>
        <div class="col-75">
          <input type = "text" id="lastName" name="lastName">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="email">Email Address:</label>
        </div>
        <div class="col-75">
          <input type = "email" id="email" name="email">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="need">Please Describe Need:</label>
        </div>
        <div class="col-75">
          <input type = "text" id="need" name="need">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="needType">Please Select Apropriate Need Category:</label>
        </div>
        <div class="col-75">
          <?php

             //Code from https://stackoverflow.com/questions/8022353/how-to-populate-html-dropdown-list-with-values-from-database

             $conn = new mysqli($hostname, $username, $password, $database)
             or die ('Cannot connect to db');

             $result = $conn->query("select id, name from categories");

             echo "<select name='needType'>";

             while ($row = $result->fetch_assoc()) {

                 unset($id, $name);
                 $id = $row['id'];
                 $name = $row['name'];
                 echo '<option value="'.$name.'">'.$name.'</option>';
             }
                 echo "</select>";
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="makeDonation">Select If Making A Donation:</label>
        </div>
        <div class="col-75">
          <label>Yes</label>
          <input type ="radio" name="makeDonation" value="Yes">
          <label>No</label>
          <input type ="radio" name="makeDonation" value="No"><br>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="requireService">Will Service Be Required?:</label>
        </div>
        <div class="col-75">
          <label>Yes</label>
          <input type ="radio" name="requireService" value="Yes">
          <label>No</label>
          <input type ="radio" name="requireService" value="No"><br>
        </div>
      </div>
      <!--Your Latitude -->
       <input type ="hidden" name="latitude" id="latitude" value="47.607055">
      <!--<br>
      Your longitude-->
        <input type="hidden" name="longitude" id="longitude" value="-122.329033">
      <!--<br> -->
      <div class="row">
        <input type ="submit" name="Submit"><br>
      </div>
    </form>
  </div>

  <!--<script>

    //Code attribution: Learning PHP, MySQL & JavaScript by Robin Nixon (O'Reilly)
   /* if (typeof navigator.geolocation == 'undefined')
      alert("Geolocation not supported.");
    else
      navigator.geolocation.getCurrentPosition(granted, denied);

    function granted(position){
      var lat = position.coords.latitude;
      var lon = position.coords.longitude;

      var outputlat = document.getElementById('latitude');
      var outputlong = document.getElementById('longitude');

      outputlat.value=lat;
      outputlong.value=lon;


      alert("Permission Granted. You are at location:\n\n"
      + lat + ", " + lon +
      "\n\nClick 'OK' to load Google Maps with your location");

      //window.location.replace("https://www.google.com/maps/@"
      //+ lat + "," + lon + ",14z")
    }

    function denied(error){
      var message
      switch(error.code){
        case 1: message = 'Permission Denied'; break;
        case 2: message = 'Position Unavailable'; break;
        case 3: message = 'Operation Timed Out'; break;
        case 4: message = 'Unknown Error'; break;
      }
      alert("Geolocation Error: " + message);
    } */

  </script> -->
    <?php

      $outputlat=$_POST['latitude'];
      $outputlon=$_POST['longitude'];
      $outputNeedType=$_POST['needType'];

      if(isset($_POST['Submit'])){
        $query= "INSERT INTO `ticket` (`firstName`,`lastName`,`email`,`description`,`needType`,`serviceRequired`,`willDonate`,`lattitude`,`longitude`)
              VALUES ('$_POST[firstName]', '$_POST[lastName]', '$_POST[email]', '$_POST[need]', '$_POST[needType]', '$_POST[requireService]', '$_POST[makeDonation]','$_POST[latitude]', '$_POST[longitude]')";

        //If query fails
        if(!mysql_query($query)){
          die('Error:'.mysql_error());
        }
        else{
          $ticketCreated = "Ticket Created";
          echo $ticketCreated;

        }

      }
    ?>
    <!--redirect to locationList.php -->
    <!--<script type="text/javascript">
      var posted = "<?php echo $ticketCreated ?>";
      if(posted === "Ticket Created"){
        location.href = 'locationList.php';

      }
    </script>-->
    <div class="containerForm">
      <form action="locationList.php" method="POST">
        <input type="hidden" name="outputNeedType" value="<?php echo $outputNeedType; ?>">
        <div class="row">
          <div class="col-25">
            <label for="submit">Click Go To Map Button To Be Matched With An Organization</label>
          </div>
          <div class="col-75">
            <button type="submit" id="mapBtn">Go To Map</button>
        </div>
      </div>
      </form>
    </div>



  </body>
</html>
