<?php include "header.php"?>
<?php
echo "<script> document.getElementById('info2').innerHTML = 'Inserting into the Location Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform"><br>
  <form  method="POST" enctype="multipart/form-data">
    <label for="name">Location Name: </label>
    <input name="name" required placeholder="Name of Location" type="text"><br>
    <label for="text">Facts: </label><br>
    <textarea name="text" required placeholder="Enter Information here"></textarea><br>
    <label for="actperiod">Activity Period: </label>
    <input name="actperiod" required placeholder="from when to when" type="text"><br>
    <label for="gps_lat">GPS Latitude: </label>
    <input name="gps_lat" required placeholder="Latitude" type="text" id="gps_lat"><br>
    <label for="gps_lng">GPS Longitude: </label>
    <input name="gps_lng" required placeholder="Longitude" type="text" id="gps_lng"><br>
    <label for="img">Image: </label> 
    <input name="img"  type="file"><br> 
    <input type="submit" name="insert" value="Insert">
  </form>
</div><br><!--theform -->

<div id="map"></div>
<script>
    const myLatlng = { lat: 53.1424, lng: -7.6921 }; //Ireland
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: myLatlng,
      });
initMap(); 
</script>

<?php

  if (isset($_POST['insert'])){
    $_POST['img'] = $_FILES['img']['tmp_name'];
    if (!VikingsSearchOptOutput("LOCATION", array("id", "name", "actperiod", "text"), false)){ //NB Don't search on image, since name changes on insert
      echo "<script> document.getElementById('info3').innerHTML = 'Record already in Database, nothing inserted;</script>";
    }else{

      $result = VikingsInsert("LOCATION", array("id", "name", "text", "actperiod", "gps_lat", "gps_lng", "img"));
      switch ($result){
        case 0: echo "<script> document.getElementById('info3').innerHTML = 'Nothing Inserted';</script>";
                break;
        case 1: echo "<script> document.getElementById('info1').innerHTML = 'Record Inserted';</script>";
                echo "<script> writeToInfoWindow({lat:".$_POST['gps_lat'].",lng:".$_POST['gps_lng']."},"."'<div id=".'"mapinfowin"> '.$_POST['name'].": ".$_POST['text']."</div>');</script>";
                break;
        default: echo "<script> document.getElementById('info3').innerHTML = '$result';</script>";
                break;
      }
      echo "<div class='insertoutputdiv'>\r\n";
      VikingsSearchOptOutput("LOCATION", array("id", "name", "actperiod", "img", "text"), true);
      echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv
    }
  }

?>
</div><!--insertcontainer -->

<?php include "footer.php" ?>
