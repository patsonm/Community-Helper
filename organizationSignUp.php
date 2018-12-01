<?php
	include_once 'phpsqlsearch_dbinfo.php'
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" />
    <title>Create Organization Account</title>
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
            <li><a href="organizationSignUp.php" class="current"> Create Organization Account</a></li>
            <li><a href="organizationSignIn.php">Organization Sign-In </a></li>
          </ul>
        </nav>
      </header>
    </div>

    <!-- Form adapted from https://www.w3schools.com/howto/howto_css_responsive_form.asp -->
    <div class="containerForm">
      <div class="serviceArea">
        <h3>We Currently Only Serve Seattle, WA Area</h3>
      </div>
      <form action="organizationSignUp.php" method="post">
        <div class="row">
          <div class="col-25">
            <label for="name">Name:</label>
          </div>
          <div class="col-75">
            <input type="text" id="name" name="name" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="street_name">Steet:</label>
          </div>
          <div class="col-75">
            <input type="text" id="street_name" name= "street_name" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="suite">Suite:</label>
          </div>
          <div class="col-75">
            <input type="text" id="suite" name= "suite">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="city">City:</label>
          </div>
          <div class="col-75">
            <input type="text" id="city" name= "city" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="state">State:</label>
          </div>
          <div class="col-75">
            <input type="text" id="state" name= "state" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="zip">Zip:</label>
          </div>
          <div class="col-75">
            <input type="text" id="zip" name="zip" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="website">Website:</label>
          </div>
          <div class="col-75">
            <input type="text" id="website" name= "website" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="contact_name">Main Contact Name:</label>
          </div>
          <div class="col-75">
            <input type="text" id="contact_name" name="contact_name">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="email">Email:</label>
          </div>
          <div class="col-75">
            <input type="email" name= "email">
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="phone">Phone:</label>
          </div>
          <div class="col-75">
            <input type="number" id="phone" name= "phone" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="description">Organization Description:</label>
          </div>
          <div class="col-75">
            <input type="text" id="description" name="description" required>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="categoryID">Category of Service Provided:</label>
          </div>
          <div class="col-75">
            <?php

               //Code from https://stackoverflow.com/questions/8022353/how-to-populate-html-dropdown-list-with-values-from-database

               $conn = new mysqli($hostname, $username, $password, $database)
               or die ('Cannot connect to db');

               $result = $conn->query("select id, name from categories");

               echo "<select name='categoryID'>";

               while ($row = $result->fetch_assoc()) {

                   unset($id, $name);
                   $id = $row['id'];
                   $name = $row['name'];
                   echo '<option value="'.$id.'">'.$name.'</option>';
               }

                   echo "</select>";

            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-25">
            <label for="website">Password:</label>
          </div>
          <div class="col-75">
            <input type="text" id="password" name= "password" required>
          </div>
        </div>
        <div class="row">
          <input type="submit" name="submit">
        </div>
      </form>
    </div>

    <?php


      if(isset($_POST['submit'])){
        $address = $_POST[street_name]." ".$_POST[city].",".$_POST[state];
        $prepAddr = str_replace(' ','+',$address);
        echo $prepAddr;

        $jsonUrlString = "http://www.mapquestapi.com/geocoding/v1/address?key=YOdzbougFT5iQzEUfjOIhd5CaStxmXI3&location=".$prepAddr;
        $jsonurl = file_get_contents($jsonUrlString);
        $output = json_decode($jsonurl, true);
        $lattitude=$output['results'][0]['locations'][0]['latLng']['lat'];
        $longitude=$output['results'][0]['locations'][0]['latLng']['lng'];
        echo "Lat: ".$lattitude."Long: ".$longitude." ";

        $query= "INSERT INTO `organizations` (`name`,`street_name`,`suite`,`city`,`state`,`zip`,`website`,`contact_name`,`email`,`phone`,`description`, `lattitude`,`longitude`, `password`)
                  VALUES ('$_POST[name]', '$_POST[street_name]', '$_POST[suite]', '$_POST[city]', '$_POST[state]', '$_POST[zip]', '$_POST[website]', '$_POST[contact_name]', '$_POST[email]', '$_POST[phone]', '$_POST[description]', '$lattitude', '$longitude', '$_POST[password]')";

        //If query fails
        if(!mysql_query($query)){
          die('Error:'.mysql_error());
        }
        else{
          echo "Organization Added";
        }
      }
    ?>
    <?php
      if(isset($_POST['submit'])){
        if(isset($_POST['categoryID'])){
          $sql = "INSERT INTO `organizations_categories`(`organizationID`,`categoryID`)
                  VALUES ( (SELECT `id` FROM `organizations` WHERE `name` = '$_POST[name]'), '$_POST[categoryID]')";
          //If query fails
          if(!mysql_query($sql)){
                    die('Error:'.mysql_error());
          }
        }
      }
    ?>



  </body>
</html>
