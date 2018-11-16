<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" />
    <title>Describe Need</title>
  </head>
  <body>
    <?
    //Connection Constants
    define('DB_name', 'cs361_dunnbrit');
    define('DB_user', 'cs361_dunnbrit');
    define('DB_password', '1967');
    define('DB_host', 'classmysql.engr.oregonstate.edu');

    //Connect
    $link = mysql_connect(DB_host,DB_user,DB_password,DB_name);

    //If connection fails
    if(!$link){
        die("Connection Error:".mysql_error());
    }

    //Connect to database
    $db_selected = mysql_select_db(DB_name,$link);
    ?>

    <div class="wrapper">
      <header>
        <img src="images/logo.jpg"/>
        <nav>
          <ul>
            <li><a href="landingPage.php">Home</a></li>
            <li><a href="userInitialForm.php">Donate</a></li>
            <li><a href="organizationSignUp.php"> Create Organization Account</a></li>
            <li><a href="">Organization Sign-In </a></li>
          </ul>
        </nav>
      </header>
    </div>


    <form action = "userInitialForm.php" method = "post">
      <legend>User Information</legend><br>
        First Name:
        <input type = "text" name="firstName">
        Last Name:
        <input type = "text" name="lastName"><br>
      <br>
        Email Address:
        <input type = "email" name="email"><br>
      <br>
        Please Describe Need:
        <input type = "text" name="need"><br>
      <br>
      Please Select Apropriate Need Category:
      <?php

           //Code from https://stackoverflow.com/questions/8022353/how-to-populate-html-dropdown-list-with-values-from-database

           $conn = new mysqli(DB_host, DB_user, DB_password, DB_name)
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
         <br>
      <br>
        Select If Making A Donation:
      <br>
      <label>Yes</label>
        <input type ="radio" name="makeDonation" value="Yes">
      <label>No</label>
        <input type ="radio" name="makeDonation" value="No"><br>
      <br>
        Will Service Be Required?:
      <br>
      <label>Yes</label>
        <input type ="radio" name="requireService" value="Yes">
      <label>No</label>
        <input type ="radio" name="requireService" value="No"><br>
      <br>
      Your Latitude
        <input type ="text" name="latitude" id="latitude"><br>
      <br>
      Your longitude
        <input type="text" name="longitude" id="longitude"><br>
      <br>
        <input type ="submit" name="Submit"><br>
    </form>

  <script>

    //Code attribution: Learning PHP, MySQL & JavaScript by Robin Nixon (O'Reilly)
    if (typeof navigator.geolocation == 'undefined')
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
    }

  </script>
  <?
    $outputlat=$_POST['latitude'];
    $outputlon=$_POST['longitude'];

    if(isset($_POST['Submit'])){
      $query= "INSERT INTO `ticket` (`firstName`,`lastName`,`email`,`description`,`needType`,`serviceRequired`,`willDonate`,`lattitude`,`longitude`)
            VALUES ('$_POST[firstName]', '$_POST[lastName]', '$_POST[email]', '$_POST[need]', '$_POST[needType]', '$_POST[requireService]', '$_POST[makeDonation]','$_POST[latitude]', '$_POST[longitude]')";

      //If query fails
      if(!mysql_query($query)){
        die('Error:'.mysql_error());
      }
      else{
        echo "Ticket Created";
      }
    }
  ?>

  </body>
</html>
organizationSignIn.php
