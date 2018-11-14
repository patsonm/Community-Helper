<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/public/styles.css" />
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

    <div class="topnav navpad">
      <a href="landingPage.php/">Home</a>
      <a href="http://flip3.engr.oregonstate.edu:7855/guitars">Guitars</a>
      <a href="http://flip3.engr.oregonstate.edu:7855/songs">Songs</a>
      <a class="active" href=http://flip3.engr.oregonstate.edu:7855/chords>Chords</a>
    </div>


    <form action = "userInitialForm.php" method = "post">
      <legend>User Information</legend>
      First Name:
      <input type = "text" name="firstName">
      Last Name:
      <input type = "text" name="lastName"><br>
      Email Address:
      <input type = "email" name="email"><br>
      Please Describe Need:
      <input type = "text" name="need"><br>
      Select If Making A Donation:
      <input type ="radio" name="makeDonation" value="Yes">
      <input type ="radio" name="makeDonation" value="No"><br>
      Will Service Be Required?:
      <input type ="radio" name="requireService" value="Yes">
      <input type ="radio" name="requireService" value="No"><br>
      <input type ="submit" name="Submit"><br>

    </form>

  </body>
</html>
