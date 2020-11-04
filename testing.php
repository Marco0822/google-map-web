
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Google Map Anti-Depression</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h3>My Google Maps Demo</h3>
  <div id="map"></div>

  <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3b7E0j46EZELU-UjzhFjrxHVDkNL9lxg&callback=initMap">

  </script>

  <?php
   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $array = array("Bondi Beach",-33.890542,151.274856);

    $locations = array();

    array_push($locations, $array);

    $array = array("Coogee Beach",-33.923036,151.259052);

    array_push($locations, $array);


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM google_map";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $array1 = array();
        array_push($array1, $row["place_name"], $row["lat"], $row["lng"]);

        //locations is a 3d array with all the data in the database
        array_push($locations, $array1);
      }
    } else {
      echo "0 results";
    }
    $conn->close();
   
  ?>

<script type="text/javascript">

  var map;
  var Markers = {};
  var infowindow;
  var locations = [
    [
      'Samsung Store Madeleine',
      "<a href='https://youtu.be/CuAcKF31Opk'><div style='float:left'><img style='max-width: 100%;' src=https://img.youtube.com/vi/CuAcKF31Opk/hqdefault.jpg></div></a>",
      48.8701925,
      2.322897600000033,
      0
    ],
    [
      'Samsung Store Velizy',
      '<strong>Samsung Store Velizy</strong><p>CC Velizy 2 <br>2 Avenue de l\'Europe <br>78140 Vélizy-Villacoublay<br>Niveau 0 Porte 3 <br>10h – 22h</p>',
      48.78126899999999,
      2.219588599999952,
      1
    ]
  ];
  var origin = new google.maps.LatLng(locations[0][2], locations[0][3]);

  function initMap() {
    var mapOptions = {
      zoom: 13,
      center: origin
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    infowindow = new google.maps.InfoWindow();

    for(i=0; i<locations.length; i++) {
      var position = new google.maps.LatLng(locations[i][2], locations[i][3]);
      var marker = new google.maps.Marker({
        position: position,
        map: map,
      });
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          console.log("The value of i is " + i);
          //If marker is clicked
          infowindow.setContent(locations[i][1]);
          infowindow.setOptions({maxWidth: 200});
          infowindow.open(map, marker);
        }
      }) (marker, i));
      Markers[locations[i][4]] = marker;
    }

    locate(0);

  }

  function locate(marker_id) {
    var myMarker = Markers[marker_id];
    var markerPosition = myMarker.getPosition();
    map.setCenter(markerPosition);
    google.maps.event.trigger(myMarker, 'click');
  }

  google.maps.event.addDomListener(window, 'load', initialize);



</script>

</body>
</html>