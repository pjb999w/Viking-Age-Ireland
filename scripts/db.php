<?php

function DBconnect($dbServerName, $dbUserName, $dbPassword, $dbName){
  $conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  return $conn;
}

function VikingsDBconnect(){
  
$XAMPP = true;
$UCC_SERVER = false;

  if ($XAMPP == true){
    //this function will return a connection to the local VikingsNew Database
    return DBconnect("localhost", "root", "", "Vikings");
  }elseif($UCC_SERVER == true){
    //this function will return a connection to the UCC Database
    return DBconnect("cs1.ucc.ie", "pjb6", "heith", "mscim2022_pjb6");
  }
}

function renderGPS($lat, $lng){
  echo "<a href='javascript:showOnMap($lat, $lng);'> GPS:($lat, $lng) </a><br>";
}

function VikingShowOne($columns, $record){
  $gps_lat_tmp = 0;
  echo "<div class='item'>\r\n ";
  foreach($columns as $column){
    if ($record[$column] !==""){
      echo "<div id='".$column."'>\r\n ";
      if ($column == 'img'){
        echo "<img src='" ."data:image;base64,".$record[$column]. "' class='img'><br>";
      }elseif ($column == 'gps_lat'){
        $gps_lat_tmp = $record[$column];
      }elseif($column == 'gps_lng'){
        renderGPS($gps_lat_tmp, $record[$column]);
      }else
        echo$record[$column] ."<br> ";
      echo "</div> \r\n";
    }
  }
  echo "</div> \r\n";
}

function VikingsNumOfTableEntries($table){
  $sql = "SELECT * FROM $table;";
  $conn = VikingsDBconnect();
  $result = mysqli_query($conn, $sql);
  return  mysqli_num_rows($result);
}

function VikingsPrintResults($results, $columns){
  if (($numres = mysqli_num_rows($results)) >0){
    echo "<script> document.getElementById('info1').innerHTML = '$numres "."Search Results';</script>";
    while ($row = mysqli_fetch_assoc($results)){
        VikingShowOne($columns, $row);
    }
    return 0; //results found
  }else
    return 1; //nonresults found
}

function VikingLookUpEntry($table, $column, $value){
 
  $sql = "SELECT $column FROM $table  WHERE $column = $value;";
  $conn = VikingsDBconnect();
  $results = mysqli_query($conn, $sql);
  $numres = mysqli_num_rows($results);
  $row = mysqli_fetch_assoc($results);
  return $row[$column];
}

function VikingsSearchOptOutput($table, $columns, $printing){
  //if $printing is false, the function looks for a record in the database
  //using the columns as search criteria and returns a 0 if found and 1 if not.
  //if $printing is true, the function looks for a record in the database
  //using the columns as search criteria and also as directives to the printing function (VikingsPrintResults). 
  //The order of the column elements also determine the printing order
  if (isset($_POST['select']) || isset($_POST['insert'])|| isset($_POST['delete'])){
    $conditions = array();
    foreach ($columns as $column){
      if(isset($_POST[$column]) && $_POST[$column] !="" && $column != "img"){
        // do not search on image
        $conditions[] = "$column='$_POST[$column]'";
      }
    }
    if(count($conditions) == 0){
      return 2; //No Search Criteria given
    }else{
      $sql = "SELECT * FROM $table  ";
      $sql .= " WHERE " . implode (' AND ', $conditions).";";
      $conn = VikingsDBconnect();
      $results = mysqli_query($conn, $sql);
      $numres = mysqli_num_rows($results);
      if ($numres >0 && $printing){
        return VikingsPrintResults($results, $columns); //0->results; 1->noresults
      }elseif ($numres >0) return 0; else return 1;
    }
  } 
}

function VikingsDelete($table, $columns){
  if (isset($_POST['delete'])){
    $conditions = array();
    foreach ($columns as $column){
      if(isset($_POST[$column]) && $_POST[$column] !=""){
        $conditions[] = "$column='$_POST[$column]'";
      }
    }
    if(count($conditions) == 0){
      return 1; //nothing to delete
    }else{
      $conn = VikingsDBconnect();
        $sql = "DELETE FROM $table ";
        $sql .= " WHERE ".implode (' AND ', $conditions).";";
        $result = mysqli_query($conn, $sql);
        $numRowsDeleted = mysqli_affected_rows($conn);
        if($numRowsDeleted == 0){
          return 1; //nothing to delete
        }else{
          return "Number of Rows Deleted :" .$numRowsDeleted;
        }
    }
  }else{
    return "Page improperly accessed";
  }
}


function VikingsInsert($table, $columns){
  if (isset($_POST['insert'])){
    $values = array();
    $nonemptycolumns = array();
    foreach ($columns as $column){
      if(isset($_POST[$column]) && $_POST[$column] !=""){
        if ($column == 'img'){
          if(getimagesize($_POST['img']) ==FALSE){
            return "Failed to insert image";
          }else{
            $img_name = addslashes($_FILES['img']['tmp_name']);
            $image = base64_encode(file_get_contents($img_name));
            $values[] = "'$image'";
            $nonemptycolumns[] = "$column";
          }
        }else{
          $values[] = "'$_POST[$column]'";
          $nonemptycolumns[] = "$column";
        }
      }
    }
    if (count($nonemptycolumns)>0){
      $conn = VikingsDBconnect();
      $sql = "INSERT INTO $table(" .implode(',', $nonemptycolumns) .") VALUES (" .implode (',', $values).");";
      $res = mysqli_query($conn, $sql);
      mysqli_close($conn);
      return $res;
    }else{
      return 0;
    }
  };
}


function VikingsShowAll($table, $columns){
  $conn = VikingsDBconnect();
  $sql = "SELECT * from $table;";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) >0){
    while ($row = mysqli_fetch_assoc($result))
      VikingShowOne($columns, $row);
  }
}

function VikingsFetch($table, $columns){
  $conn = VikingsDBconnect();
  $sql = "SELECT ".implode(',', $columns). " from $table";
  $resArray = array();
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) >0){
    while ($row = mysqli_fetch_assoc($result))
      $resArray[] = $row;
  }
  return $resArray;
}

function VikingsFetchLocations(){
  $conn = VikingsDBconnect();
  $sql = "SELECT id, name, text, actperiod,gps_lat,gps_lng from LOCATION;";
  $resArray = array();
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) >0){
    while ($row = mysqli_fetch_assoc($result))
      $resArray[] = $row;
  }
  return $resArray;

}

function CloseAndExit($conn){
  mysqli_close($conn);
  exit();
}
?>
