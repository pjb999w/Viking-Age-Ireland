<?php include "header.php"?>
<?php
echo "<script> document.getElementById('info2').innerHTML = 'Deleting from the People Table';</script>";
?>

<div class="insertcontainer"><br>
<div class="theform""><br>
  <form  method="POST">
    <label for="id">Primary Key: </label>
    <input name="id" placeholder="key" type="text"><br>
    <label for="fname">First Name: </label>
    <input name="fname" placeholder="First Name" type="text"><br>
    <label for="sname">Second Name: </label>
    <input name="sname" placeholder="Second Name" type="text"><br>
    <input type="submit" name="delete" value="Delete">
  </form>
</div><br><!--theform -->

<?php
  if(isset($_POST['delete'])){
    echo "<div class='insertoutputdiv'>\r\n";
    $results = VikingsSearchOptOutput("PEOPLE", array("id", "fname", "sname", "actperiod", "text", "img"), true);
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv      
    $result = VikingsDelete("PEOPLE", array("id", "fname", "sname", "text", "actperiod", "img"));

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