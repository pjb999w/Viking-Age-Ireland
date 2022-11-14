<?php include "header.php"?>
<?php
echo "<script> document.getElementById('info2').innerHTML = 'Deleting from the Artifact Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform""><br>
  <form method="POST">
    <label for="id">Primary Key: </label>
    <input name="id" placeholder="key" type="text"><br>
    <label for="name">Name of Artifact: </label>
    <input name="name" placeholder="Artifact Name" type="text"><br>
    <input type="submit" name="delete" value="Delete">
  </form>
</div><br><!--theform -->

<?php
  if(isset($_POST['delete'])){
    echo "<div class='insertoutputdiv'>\r\n";
    $results = VikingsSearchOptOutput("ARTIFACT", array("id", "name", "text", "actperiod", "img"), true);
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv      
    $result = VikingsDelete("ARTIFACT", array("id", "name", "text", "actperiod", "img"));

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