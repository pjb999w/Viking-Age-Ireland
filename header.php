<?php include_once 'scripts/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href=css/style.css>
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org//face/runic" type="text/css"/>
  <link href="//db.onlinewebfonts.com/c/3cb76289938a393753b95451e837b716?family=Comic+Runes" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />  
  <title>Vikings Age Ireland</title>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0Wj5LDrqUMVYAUEz1XEQZi7nggbncEPg">
  </script>
  <script>    



     function showOnMap(latitude, longitude) {
        const locn = { lat: latitude, lng: longitude };
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 10,
          center: locn,
        });
        const marker = new google.maps.Marker({
        position: locn,
        map: map,
      });
      }



  function initMap() {

  // Create the initial InfoWindow.
    // let infoWindow = new google.maps.InfoWindow({
    //   content: "Click the map to get Lat/Lng",
    //   position: myLatlng
    //   });

    // infoWindow.open(map);

  // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {

      // infoWindow.close();


      infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
      });
      infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
      );
      document.getElementById("gps_lat").value = mapsMouseEvent.latLng.lat();
      document.getElementById("gps_lng").value = mapsMouseEvent.latLng.lng();
      infoWindow.open(map);
    });
  }

  
  function writeToInfoWindow(myLatlng,content){
    let infoWindow = new google.maps.InfoWindow({
        position: myLatlng,
          });
    infoWindow.setContent(content);
    infoWindow.open(map);
  }

  </script>

</head>


<body>
    <div class="navbar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
          <a href="#">Insert</a>
          <ul class="animated fadeIn">
            <li><a href="insertPEOPLE.php">People</a></li>
            <li><a href="insertARTIFACT.php">Artifact</a></li>
            <li><a href="insertLOCATION.php">Location</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#">Search</a>

          <ul class="animated fadeIn">
            <li><a href="searchPEOPLE.php">People</a></li>
            <li><a href="searchARTIFACT.php">Artifact</a></li>
            <li><a href="searchLOCATION.php">Location</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a href="#">Delete</a>

          <ul class="animated fadeIn">
            <li><a href="deletePEOPLE.php">People</a></li>
            <li><a href="deleteARTIFACT.php">Artifact</a></li>
            <li><a href="deleteLOCATION.php">Location</a></li>
          </ul>
        </li>

        <li><a href="explore.php">Explore</a></li>
      </ul>
    </div>

    <div class =infosection>
       <div class='info' id=info1> </div>
       <div class='info' id=info2> </div>
       <div class='info' id=info3> </div>
    </div>
    <div style="margin-top:10px;"> 
