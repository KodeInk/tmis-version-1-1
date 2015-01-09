

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Map View</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
	
	<style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
// This example displays a marker at the center of Australia.
// When the user clicks the marker, an info window opens.
function initialize() {
  var myLatlng = new google.maps.LatLng(34.052, -118.244);
  var mapOptions = {
    zoom: 10,
    center: myLatlng
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<div id="bodyContent" style="height:140px;padding-top:3px;">'+
      '<table border="0" cellspacing="0" cellpadding="0"  id="contenttable">'+
      '<tr>'+
      '<td id="numbercell" width="1%" style="padding-bottom:5px;"><div><span id="bignumber">567</span><br><span id="smallnumber"  nowrap>Store Score</span></div></td>'+
      '<td class="locationbubble">A</td>'+
      '<td width="98%" valign="top" style="padding:10px 10px 0px 0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">'+
      '<tr>'+
      '<td class="title" width="99%" style="font-weight:bold;">Mariscos Jalisco</td>'+
      '<td style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/small_favorite_icon.png"></td>'+
      '<td>0.5mi</td>'+
      '</tr>'+
      '<tr>'+
      '<td colspan="3" nowrap>456789 Coldwater Canyon, Beverl...</td>'+
      '</tr>'+
      '</table></td>'+
      '</tr>'+
      '<tr>'+
      '<td colspan="3" style="padding:10px 10px 0px 0px;"><table width="100%" border="0" cellspacing="0" cellpadding="3">'+
      '<tr>'+
      '<td>Tacos, Mexican, Seafood, Food Stands, Outdoor Seating...</td>'+
      '<td style="padding-left:0px;">'+
      '<table border="0" cellspacing="0" cellpadding="2" class="rewardcard"><tr><td class="toprow"></td></tr><tr><td class="bottomrow" nowrap>10-20%</td></tr></table>'+
      '</td>'+
      '<td style="padding-left:3px;padding-right:0px;">'+
      '<table border="0" cellspacing="0" cellpadding="2" class="perkcard"><tr><td class="toprow"></td></tr><tr><td class="bottomrow" nowrap>Perk</td></tr></table>'+
      '</td>'+
      '</tr>'+
      '</table>'+
      '</td>'+
      '</tr>'+
	  
	  '<tr>'+
      '<td colspan="3" style="padding:5px 5px 0px 0px;"><table width="100%" border="0" cellspacing="0" cellpadding="3">'+
      '<tr>'+
      '<td><a href="javascript:;" class="bluebold" style="font-weight:bold;">Directions to here</a></td>'+
      '<td align="right"><a href="javascript:;" class="bluebold" style="font-weight:bold;">More</a></td>'+
      '</tr>'+
      '</table>'+
      '</td>'+
      '</tr>'+
	  
	  
      '</table>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
      content: contentString,
	  maxWidth: 340,
	  pixelOffset: 0
  });
  
  
  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var markerImage = {
    url: '<?php echo base_url();?>assets/images/map_marker.png',
    // This marker is 64 pixels wide by 79 pixels tall.
    size: new google.maps.Size(64, 79),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the marker at 0,60.
    anchor: new google.maps.Point(0, 60)
  };

  //Plot the selected marker and show its info window
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Mariscos Jalisco',
	  icon: markerImage
  });
  
  //Show marker and content windo open the first time
  infowindow.open(map,marker);
  
  //Also add a listener on click in case the user closed it
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
  
  
  //Sample restaurant marker array
  //Place format is Array(RESTAURANT_NAME, LATITUDE, LONGITUDE, PLACE_TIP_CONTENT)
  var searchPlaces = new Array();
  searchPlaces[0] = new Array('Walnut Grove Restaurant', 34.040, -117.900, 'Walnut Grove Restaurant content here');
  searchPlaces[1] = new Array('Manhattan Beach Shop', 33.8889, -118.4053, 'Manhattan Beach Shop content here');
  
  //Now plot all other markers but do not open them
  for(var i=0; i<searchPlaces.length; i++)
  {
     var anotherMarker = plotMarker(map, markerImage, searchPlaces[i][1], searchPlaces[i][2], searchPlaces[i][0]);
 	 createInfoWindow(map, anotherMarker, searchPlaces[i][3]);	 
  }
  
  
}


//To plot additional markers onto the map
function plotMarker(map, markerImage, lat, long, title) {
  var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat, long),
	 map: map,
     title: title,
	 icon: markerImage
  });
  return marker;
}


//To add info windows for the markers
function createInfoWindow(map, marker, popupContent) {
    var infowindow = new google.maps.InfoWindow({
      content: popupContent,
	  maxWidth: 340
  	});
	
	google.maps.event.addListener(marker, 'click', function () {
        infowindow.open(map, marker);
    });
}


google.maps.event.addDomListener(window, 'load', initialize);
</script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

