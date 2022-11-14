<?php include "header.php"?>

<script>  
function showText(txt){
    document.getElementById('exploreinfo').innerHTML = txt;
  }
</script>

<?php

  
echo "<script> document.getElementById('info2').innerHTML = 'Exploring';</script>";

echo '<div id="explorecontainer">';
    echo '  <div id="map"></div>';
    echo '  <div id="persongalary">';
        $people[] = VikingsFetch("PEOPLE", array("img", "text"));

        foreach($people as $person){
          foreach ($person as $p){
            echo "<div class='item'>\r\n ";
            echo "<img src=". "'data:image;base64,". $p['img']. "' class='img' onclick='showText(". '"'.$p['text'].'"'. ")'". ">  </a>";
            echo "</div> \r\n";
          }
        }
    echo '</div>';//persongalary

    echo '  <div id="artifactgalary">';
        $artifacts[] = VikingsFetch("ARTIFACT", array("img", "text"));

        foreach($artifacts as $artifact){
          foreach ($artifact as $art){
            echo "<div class='item'>\r\n ";
            echo "<img src=". "'data:image;base64,". $art['img']. "' class='img' onclick='showText(". '"'.$art['text'].'"'. ")'". ">  </a>";
            echo "</div> \r\n";
          }
        }
    echo '</div>';//artifactgalary

echo '</div>'; //explorecontainer

echo '  <div id="exploreinfo"> </div>';
?>

<script>
    const myLatlng = { lat: 53.1424, lng: -7.6921 }; //Ireland
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: myLatlng,
      });
initMap(); 

function dropMarker(lat, lng, txt){
    const marker = new google.maps.Marker({
    position: {lat,lng},
    map,
    title: txt
  });


    marker.addListener("click", function (){
    map.setZoom(8);
    map.setCenter(marker.getPosition());
    document.getElementById("exploreinfo").innerHTML = txt;
  });
}


</script>

<?php 
$locations[] = VikingsFetchLocations();
// print_r($locations);
foreach($locations as $location){
  foreach($location as $locn){
    // echo $locn['gps_lat']. $locn['gps_lng'];
    echo "<script> dropMarker(" .$locn['gps_lat'].",". $locn['gps_lng'].",'". $locn['text']. "');</script>";
  }
}
?>

<?php

?>


<?php include "footer.php" ?>