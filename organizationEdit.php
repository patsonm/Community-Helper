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
    $organizationID = $_GET['organizationID'];
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
         </ul>
       </nav>
     </header>

     <!-- Form adapted from https://www.w3schools.com/howto/howto_css_responsive_form.asp -->
     <div class="containerForm">
       <div class="serviceArea">
         <h3>We Currently Only Serve Seattle, WA Area</h3>
       </div>
         <?php
           echo "<form action = 'organizationEdit.php?organizationID=".$organizationID."' method = 'post' >";
         ?>
         <div class="row">
           <div class="col-25">
             <label for="name">Name:</label>
           </div>
           <div class="col-75">
             <input type="text" id="name" name="name">
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
             <input type="number" id="phone" name= "phone">
           </div>
         </div>
         <div class="row">
           <div class="col-25">
             <label for="description">Organization Description:</label>
           </div>
           <div class="col-75">
             <input type="text" id="description" name="description">
           </div>
         </div>
         <div class="row">
           <input type="submit" name="submit">
         </div>
       </form>
     </div>
     <?php


       if(isset($_POST['submit'])){
         if(isset($_POST['name'])){
           $name = $_POST['name'];
           if($name != ""){
             $query1 = "UPDATE `organizations` SET  `name` = '$name' WHERE `id` = '$organizationID' ";
             $result1 = mysql_query($query1);
             //If query fails
             if(!mysql_query($query1)){
               die('Error:'.mysql_error());
             }
             else{
               echo "Organization Updated";
             }
         }

         if(isset($_POST['contact_name'])){
           $contact_name = $_POST['contact_name'];
           if($contact_name != "" ){
             $query3 = "UPDATE `organizations` SET `contact_name` = '$contact_name' WHERE `id` = '$organizationID' ";
             $result3 = mysql_query($query3);
             //If query fails
             if(!mysql_query($query3)){
               die('Error:'.mysql_error());
             }
             else{
               echo "Organization Updated";
             }
           }
         }
         if(isset($_POST['email'])){
           $email = $_POST['email'];
           if($email != ""){
             $query4 = "UPDATE `organizations` SET `email` = '$email' WHERE `id` = '$organizationID' ";
             $result4 = mysql_query($query4);
             //If query fails
             if(!mysql_query($query4)){
               die('Error:'.mysql_error());
             }
             else{
               echo "Organization Updated";
             }
           }

         }
         if(isset($_POST['phone'])){
           $phone = $_POST['phone'];
           if($phone != ""){
             $query5 = "UPDATE `organizations` SET `phone` = '$phone' WHERE `id` = '$organizationID' ";
             $result5 = mysql_query($query5);
             //If query fails
             if(!mysql_query($query5)){
               die('Error:'.mysql_error());
             }
             else{
               echo "Organization Updated";
             }
           }

         }
         if(isset($_POST['description'])){
           $description = $_POST['description'];
           if($description !=""){
             $query6 = "UPDATE `organizations` SET  `description` = '$description' WHERE `id` = '$organizationID' ";
             $result6 = mysql_query($query6);
             //If query fails
             if(!mysql_query($query6)){
               die('Error:'.mysql_error());
             }
             else{
               echo "Organization Updated";
             }
           }

         }
       }
     }
     ?>


</body>
</html>
