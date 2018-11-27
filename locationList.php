<?php
  include_once 'phpsqlsearch_dbinfo.php';
  $outputNeedType=$_POST['outputNeedType'];

?>

<!DOCTYPE html >
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>Charity Locator</title>
  <style>

    #map {
      height: 100%;
    }

/*map is whole page
      edit size here*/
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    #searchBackground{
      background-color:black;
      color:white;
    }
    #searchButton{
      background-color:#9ACD32;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    #searchButton:hover {
      background-color: #45a049;
    }
    .selectOrganizationForm{
      background-color:black;
      color:white;
    }
    input[type=submit]{
      background-color:#9ACD32;
      color: white;
      border-radius: 4px;
      cursor: pointer;      
    }
    input[type=submit]:hover {
      background-color: #45a049;     
    }

 </style>
  </head>


  <body style="margin:0px; padding:0px;" onload="initMap()">
    <div id = "searchBackground">
        <label for="raddressInput">Search location:</label>
        <input type="text" id="addressInput" size="15"/>
        <label for="radiusSelect">Radius:</label>
        <select id="radiusSelect" label="Radius">
          <option value="32" selected>20 miles</option>
          <option value="24">15 miles</option>
          <option value="16">10 miles</option>
          <option value="8">5 miles</option>
        </select>
        <input type="button" id="searchButton" value="Search"/>
    </div>
    <div><select id="locationSelect" style="width: 10%; visibility: hidden"></select></div>
    <div id="map" style="width: 100%; height: 90%"></div>
    <script>
      var map;
      var markers = [];
      var infoWindow;
      var locationSelect;

        function initMap() {
          var seattle = {lat: 47.607055, lng: -122.329033};
          map = new google.maps.Map(document.getElementById('map'), {
            center: seattle,
            zoom: 11,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
          });
          infoWindow = new google.maps.InfoWindow();

          searchButton = document.getElementById("searchButton").onclick = searchLocations;

          locationSelect = document.getElementById("locationSelect");
          locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            if (markerNum != "none"){
              google.maps.event.trigger(markers[markerNum], 'click');
            }
          };
        }

       function searchLocations() {
         var address = document.getElementById("addressInput").value;
         var geocoder = new google.maps.Geocoder();
         geocoder.geocode({address: address}, function(results, status) {
           if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(results[0].geometry.location);
           } else {
             alert(address + ' not found');
           }
         });
       }

       function clearLocations() {
         infoWindow.close();
         for (var i = 0; i < markers.length; i++) {
           markers[i].setMap(null);
         }
         markers.length = 0;

         locationSelect.innerHTML = "";
         var option = document.createElement("option");
         option.value = "none";
         option.innerHTML = "See all results:";
         locationSelect.appendChild(option);
       }

       function searchLocationsNear(center) {
         clearLocations();

         var radius = document.getElementById('radiusSelect').value;
         var searchUrl = 'charlocator.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
         downloadUrl(searchUrl, function(data) {
           var xml = parseXml(data);
           var markerNodes = xml.documentElement.getElementsByTagName("marker");
           var bounds = new google.maps.LatLngBounds();
           for (var i = 0; i < markerNodes.length; i++) {
             var id = markerNodes[i].getAttribute("id");
             var name = markerNodes[i].getAttribute("name");
             var address = markerNodes[i].getAttribute("street_name");
             var distance = parseFloat(markerNodes[i].getAttribute("distance"));
             var latlng = new google.maps.LatLng(
                  parseFloat(markerNodes[i].getAttribute("lat")),
                  parseFloat(markerNodes[i].getAttribute("lng")));

             createOption(name, distance, i);
             createMarker(latlng, name, address);
             bounds.extend(latlng);
           }
           map.fitBounds(bounds);
           locationSelect.style.visibility = "visible";
           locationSelect.onchange = function() {
             var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
             google.maps.event.trigger(markers[markerNum], 'click');
           };
         });
       }

       function createMarker(latlng, name, address) {
          var html = "<b>" + name + "</b> <br/>" + address;
          var marker = new google.maps.Marker({
            map: map,
            position: latlng
          });
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
          markers.push(marker);
        }

       function createOption(name, distance, num) {
          var option = document.createElement("option");
          option.value = num;
          option.innerHTML = name;
          locationSelect.appendChild(option);
       }

       function downloadUrl(url, callback) {
          var request = window.ActiveXObject ?
              new ActiveXObject('Microsoft.XMLHTTP') :
              new XMLHttpRequest;

          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              request.onreadystatechange = doNothing;
              callback(request.responseText, request.status);
            }
          };

          request.open('GET', url, true);
          request.send(null);
       }

       function parseXml(str) {
          if (window.ActiveXObject) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.loadXML(str);
            return doc;
          } else if (window.DOMParser) {
            return (new DOMParser).parseFromString(str, 'text/xml');
          }
       }

       function doNothing() {}
  
  </script>
    <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXRt8gPgUVPTYBGpTTBAsaIcunwqGTRa8&callback=initMap">

  </script>

      <?php
  //Connect to database
    $link = mysql_connect($hostname, $username, $password);

    //If connection fails
    if(!$link){
        die("Connection Error:".mysql_error());
    }

    $db_selected = mysql_select_db($database,$link);

    ?>

      <!-- Form adapted from https://www.w3schools.com/howto/howto_css_responsive_form.asp -->
  <div class="selectOrganizationForm">
    <form action = "locationList.php" method = "post">
          <label for="selectOrganization">Please Select Organization To Donate To:</label>
          <?php
            
            //Get needType value from sumbitted form in userInitialForm.php and append to query
            /*$query = "select DISTINCT organizations.id, organizations.name from organizations INNER JOIN organizations_categories ON organizations.id = organizations_categories.organizationID INNER JOIN categories ON organizations_categories.categoryID = categories.id INNER JOIN ticket ON categories.name = ticket.needType WHERE ticket.needType =".$outputNeedType;

             //Code from https://stackoverflow.com/questions/8022353/how-to-populate-html-dropdown-list-with-values-from-database

             $conn = new mysqli($hostname, $username, $password, $database)
             or die ('Cannot connect to db');

             $result = $conn->query($query);
             echo $result;

             echo "<select name='selectOrganization'>";

             while ($row = $result->fetch_assoc()) {

                 unset($id, $name);
                 $id = $row['id'];
                 $name = $row['name'];
                 echo '<option value="'.$name.'">'.$name.'</option>';
             }
                 echo "</select>";*/

                  //Code from https://stackoverflow.com/questions/8022353/how-to-populate-html-dropdown-list-with-values-from-database

             $conn = new mysqli($hostname, $username, $password, $database)
             or die ('Cannot connect to db');

             $result = $conn->query("select id, name from organizations");

             echo "<select name='name'>";

             while ($row = $result->fetch_assoc()) {

                 unset($id, $name);
                 $id = $row['id'];
                 $name = $row['name'];
                 echo '<option value="'.$name.'">'.$name.'</option>';
             }
                 echo "</select>";
        

          ?>
      
        <input type ="submit" name="Submit"><br>
      
    </form>
  </div>

  <?php
      if(isset($_POST['Submit'])){
        if(isset($_POST['name'])){
          $sql = "INSERT INTO `ticket_status`(`organizationID`,`ticketID`)
                  VALUES ( (SELECT `id` FROM `organizations` WHERE `name` = '$_POST[name]'), (SELECT MAX(`id`) FROM ticket))";
          //If query fails
          if(!mysql_query($sql)){
                    die('Error:'.mysql_error());
          }
          else{
            $postConfirmed = "Confirmed";
        
            $result = mysql_query("SELECT `website` FROM organizations WHERE `name`='$_POST[name]'");
            //Get website address
            $webAddress = mysql_result($result,0);
          }

        }

      }

  ?>

      <!--redirect to locationList.php -->
    <script type="text/javascript">
      var confirmed = "<?php echo $postConfirmed ?>";
      var address = "<?php echo $webAddress ?>";
      if(confirmed === "Confirmed")
        location.href = address;
    </script>



  </body>
</html>
