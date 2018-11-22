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
    <?

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
            <li><a href="userInitialForm.php">Donate</a></li>
            <li><a href="organizationSignUp.php" class="current"> Create Organization Account</a></li>
            <li><a href="organizationSignIn.phporganizationSignIn.php">Organization Sign-In </a></li>
          </ul>
        </nav>
      </header>
    </div>

    <form action="organizationSignUp.php" method="post">
      <fieldset>
        <legend>Organization Information</legend>
        Name:<input type="text" name="name">
        <br>
        Location:<br>
        Street: <input type="text" name= "street_name">
        Suite:<input type="text" name= "suite">
        <br>
        City:<input type="text" name= "city">
        State:<input type="text" name= "state">
        Zip:<input type="text" name="zip">
        <br>
        Website:<input type="text" name= "website">
        <br>
        Main Contact Name:<input type="text" name="contact_name">
        <br>
        Email:<input type="email" name= "email">
        <br>
        Phone:<input type="number" name= "phone">
        <br>
        Organzation Description:<input type="text" name="description">
        <br>
        Category of Service Provided:
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
        <input type="submit" name="submit">
      </fieldset>
    </form>
    <?
      if(isset($_POST['submit'])){
        $query= "INSERT INTO `organizations` (`name`,`street_name`,`suite`,`city`,`state`,`zip`,`website`,`contact_name`,`email`,`phone`,`description`)
                  VALUES ('$_POST[name]', '$_POST[street_name]', '$_POST[suite]', '$_POST[city]', '$_POST[state]', '$_POST[zip]', '$_POST[website]', '$_POST[contact_name]', '$_POST[email]', '$_POST[phone]', '$_POST[description]')";

        //If query fails
        if(!mysql_query($query)){
          die('Error:'.mysql_error());
        }
        else{
          echo "Organization Added";
        }
      }
    ?>
    <?
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
