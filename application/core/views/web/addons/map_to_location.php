

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var geocoder;
var query = '<?php echo $address;?>';


function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  geocoder = new google.maps.Geocoder();

   var mapOptions = {
    zoom:7
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  codeAddress();
  directionsDisplay.setMap(map);
}

//Calculate the route
function calcRoute() {
  var start = document.getElementById('start').value;
  var end = document.getElementById('end').value;
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}


//Center the map near the destination location
function codeAddress() {
  var address = query;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}


google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="panel">
    <table>
    <?php echo (empty($address) && !empty($msg))? "<tr><td colspan='2'>".format_notice($msg)."</td></tr>":''; 
	
	if(!empty($address))
	{?>
    <tr><td><input type="text" name="start" id="start" class="textfield" value="" placeholder="Enter your starting address " style="width: 250px;"/><input type="hidden" name="end" id="end" value="<?php echo $address;?>" /></td><td><input id="getdirections" name="getdirections" type="button" value="GO" class="greenbtn" style="width: 50px;" onclick="calcRoute();"></td></tr>
    <?php }?>
    </table>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>

