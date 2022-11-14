<?php include "header.php"?>
<?php
echo "<script> document.getElementById('info2').innerHTML = 'Deleting from the Location Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform""><br>
  <form method="POST">
    <label for="id">Primary Key: </label>
    <input name="id" placeholder="key" type="text"><br>
    <label for="name">Name of Location: </label>
    <input name="name" placeholder="Location Name" type="text"><br>
    <input type="submit" name="delete" value="Delete">
  </form>
</div><br><!--theform -->

<?php
  if(isset($_POST['delete'])){
    echo "<div class='insertoutputdiv'>\r\n";
    $results = VikingsSearchOptOutput("LOCATION", array("id", "name","actperiod", "gps_lat", "gps_lng", "img", "text"), true);
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv   
    $result = VikingsDelete("LOCATION", array("id", "name","actperiod", "gps_lat", "gps_lng", "img", "text"));
    switch ($result){
      case 1: echo "<script> document.getElementById('info3').innerHTML = 'Nothing to Delete';</script>";
        break;
      default: echo "<script> document.getElementById('info3').innerHTML = '$result';</script>";
        break;
    }
  } 
?>
</div><!--insertcontainer -->
<?php include "footer.php";?>