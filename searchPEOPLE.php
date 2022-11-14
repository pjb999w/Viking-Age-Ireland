<?php require "header.php"?>

<?php
echo "<script> document.getElementById('info2').innerHTML = 'Searching the People Table';</script>";
?>

<div class="insertcontainer">
<div class="theform">
    <form  method = "POST">
      <label for="fname">First Name: </label>
      <input name="fname" placeholder="First Name" type="text"><br>
      <label for="sname">Second Name: </label>
      <input name="sname" placeholder="Second Name" type="text"><br>
      <label for="actperiod">Activity Period: </label>
      <input name="actperiod" placeholder="from when to when" type="text"><br>
      <input type="submit" name="select" value="Search">
    </form>
</div><br><!--theform -->

<?php 
echo "<script> document.getElementById('info1').innerHTML = 'Number of Entries in DB = " .VikingsNumOfTableEntries('PEOPLE') ."';</script>";
?>

<?php  
  if (isset($_POST['select'])){
    echo "<div class='insertoutputdiv'>\r\n";
    $results = VikingsSearchOptOutput("PEOPLE", array("id", "fname", "sname", "actperiod", "text", "img"), true);
    echo "</div> <!--insertoutputdiv -->\r\n";//insertoutputdiv      
    switch ($results){
      case 0: break; //results found
      case 1: echo "<script> document.getElementById('info3').innerHTML = 'No results to show';</script>";
             break;
      case 2: echo "<script> document.getElementById('info3').innerHTML = 'No Search Criteria Given';</script>";
              break;
    }
  }

?>
</div><!--insertcontainer -->
<?php require "footer.php";?>