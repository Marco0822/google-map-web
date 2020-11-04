
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
        array_push($locations, $array1);
      }
    } else {
      echo "0 results";
    }
    $conn->close();
   
  ?>

  <script>


      // var locations = [
//         ['Bondi Beach', -33.890542, 151.274856, 4],
//         ['Coogee Beach', -33.923036, 151.259052, 5],
//         ['Cronulla Beach', -34.028249, 151.157507, 3],
//         ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
//         ['Maroubra Beach', -33.950198, 151.259302, 1]
//       ];

    
    var locations = <?php echo json_encode($locations); ?>;
    var map;
      // Initialize and add the map
    function initMap() {
        // The location of Uluru

        const contentString =
          '<div id="content">' +
          '<div id="siteNotice">' +
          "</div>" +
          '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
          '<div id="bodyContent">' +
          "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
          "sandstone rock formation in the southern part of the " +
          "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
          "south west of the nearest large town, Alice Springs; 450&#160;km " +
          "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
          "features of the Uluru - Kata Tjuta National Park. Uluru is " +
          "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
          "Aboriginal people of the area. It has many springs, waterholes, " +
          "rock caves and ancient paintings. Uluru is listed as a World " +
          "Heritage Site.</p>" +
          '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
          "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
          "(last visited June 22, 2009).</p>" +
          "</div>" +
          "</div>";

        const infowindow = new google.maps.InfoWindow({
          content: contentString,
        });


      // The marker, positioned at Uluru
      var marker, i;
      const MaroubraBeach = { lat: -33.92, lng: 151.25 };
        // const BondiBeach = { lat: -33.890542, lng: 151.274856 };
        // The map, centered at Uluru
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 9,
          center: MaroubraBeach,
        });
        // var markerArray = [];

      for (i = 0; i < locations.length; i++) {  
        
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
        });

        // markerArray.push(marker);

        marker.addListener("click", () => {
          infowindow.open(map, marker);
        });
        
      }


    }



  
    
  </script>

</body>
</html>