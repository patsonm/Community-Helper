<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/public/styles.css" />
    <title></title>
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

    <div class="topnav navpad">
      <a href="http://flip3.engr.oregonstate.edu:7855/">Home</a>
      <a href="http://flip3.engr.oregonstate.edu:7855/guitars">Guitars</a>
      <a href="http://flip3.engr.oregonstate.edu:7855/songs">Songs</a>
      <a class="active" href=http://flip3.engr.oregonstate.edu:7855/chords>Chords</a>
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

             $conn = new mysqli(DB_host, DB_user, DB_password, DB_name)
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
