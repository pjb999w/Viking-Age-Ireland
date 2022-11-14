<?php require "header.php"?>


<?php
echo "<script> document.getElementById('info2').innerHTML = 'Searching the Location Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform""><br>
    <form  method="POST">
      <label for="name">Name: </label>
      <input name="name" placeholder="Location Name" type="text"><br>
      <label for="actperiod">Activity Period: </label>
      <input name="actperiod" placeholder="from when to when" type="text"><br>
      <input type="submit" name="select" value="Search">
    </form>
</div><br><!--theform -->

<div id=map></div>
<script>
    const myLatlng = { lat: 53.1424, lng: -7.6921 }; //Ireland
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: myLatlng,
      });
initMap(); 
</script>

 <?php 
echo "<script> document.getElementById('info1').innerHTML = 'Number of Entries in DB = " .VikingsNumOfTableEntries('LOCATION') ."';</script>";
?>

<?php
  if (isset($_POST['select'])){
    echo "<div class='insertoutputdiv' id='locOutputDiv>\r\n";
    $numResults = VikingsSearchOptOutput("LOCATION", array("id", "name","actperiod", "gps_lat", "gps_lng", "img", "text"), false);
    $locations[] = VikingsFetch("LOCATION", array("gps_lat", "gps_lng", "img"));

        foreach($locations as $location){
          foreach ($location as $loc){
            echo "<div class='item'>\r\n ";
            echo "<img src=". "'data:image;base64,". $loc['img']. "' class='img' onclick='showOnMap(". '"'.$loc['gps_lat'].'"'.$loc['gps_lng'].'"'. ")'". ">  </a>";
            echo "</div> \r\n";
          }
        }
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv
    switch ($numResults){
      case 0: break;
      case 1: echo "<script> document.getElementById('info3').innerHTML = 'No results to show';</script>";
              break;
      case 2: echo "<script> document.getElementById('info3').innerHTML = 'No Search Criteria Given';</script>";
              break;
    }
  }
?>
</div><!--insertcontainer -->
<?php require "footer.php";?>