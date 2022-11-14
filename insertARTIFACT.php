<?php include "header.php"?>
<?php
echo "<script> document.getElementById('info2').innerHTML = 'Inserting into the Artifact Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform"><br>
  <form method="POST" enctype="multipart/form-data">
    <label for="name">Artifact Name</label>
    <input name="name" required placeholder="Name of Artifact" type="text"><br>
    <label for="text">Facts</label><br>
    <textarea name="text" required placeholder="Enter Information here"></textarea><br>
    <label for="actperiod">Activity Period</label>
    <input name="actperiod" required placeholder="from when to when" type="text"><br>
    <label for="img">Image</label> 
    <input name="img"  type="file"><br> 
    <input type="submit" name="insert" value="Insert">
  </form>
</div><!--theform -->

<?php
if (isset($_POST['insert'])){
  $_POST['img'] = $_FILES['img']['tmp_name'];
  if (!VikingsSearchOptOutput("ARTIFACT", array("id", "name", "actperiod", "text"), false)){ //NB Don't search on image, since name changes on insert
    echo "<script> document.getElementById('info3').innerHTML = 'Record already in Database, nothing inserted';</script>";
  }else{
    $result = VikingsInsert("ARTIFACT", array("name", "text", "actperiod", "img"));
    switch ($result){
      case 0: echo "<script> document.getElementById('info3').innerHTML = 'Nothing Inserted';</script>";
              break;
      case 1: echo "<script> document.getElementById('info1').innerHTML = 'Record Inserted';</script>";
              break;
      default: echo "<script> document.getElementById('info').innerHTML = '$result';</script>";
              break;
    }
    echo "<div class='insertoutputdiv'>\r\n";
    VikingsSearchOptOutput("ARTIFACT", array("id", "name", "actperiod", "img", "text"), true);
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv
  }
}
?>

</div><!--insertcontainer -->
<?php include "footer.php" ?>
