<html>
    <title> Information</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Navbar (sticky bottom) -->
    <head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="styles.css">
        </head>
    <style>
body,h1,h2{font-family: "Raleway", sans-serif}
body, html {height: 100%}
p {line-height: 1.5}

</style>
    <body>


       <div id="googleMap" style="width:50%;height:300px;"></div>



<script>

function myMap() {
var myLatLng = {lat: 37.4419, lng: -122.1419};
var mapProp= {
    center:new google.maps.LatLng(37.4419,-122.1419),
    zoom:13,
};

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
  });


};
</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXRt8gPgUVPTYBGpTTBAsaIcunwqGTRa8&callback=myMap">
</script>

   </body>

</html>
