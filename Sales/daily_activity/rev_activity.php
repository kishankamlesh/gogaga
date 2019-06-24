<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
$name = $_SESSION["name"];
$userid = $_SESSION["userid"];
$sno = $_SESSION["sno"];
$d_name = $_SESSION["d_name"];
$sql_m_type = "SELECT * FROM managers_data WHERE sno = '".$sno."'";
$res_m_type = $conn->query($sql_m_type);
if($res_m_type->num_rows){
  if($row_m_type = $res_m_type->fetch_assoc()){
    $m_type = $row_m_type["type"];
  }
}
if(isset($_POST["rev_sub"])){
  $fr_day = $_POST["fr_day"];
  $fr_mn = $_POST["fr_month"];
  $fr_y = $_POST["fr_yr"];

  //formatting date
  $from_date = $fr_day."-".$fr_mn."-".$fr_y;
  $from_date = date("d-M-Y", strtotime($from_date));

  $to_day = $_POST["to_day"];
  $to_mn = $_POST["to_month"];
  $to_y = $_POST["to_yr"];

  $to_date = $to_day."-".$to_mn."-".$to_y;
  $to_date = date("d-M-Y", strtotime($to_date));
  $act_type = $_POST["a_type"];
  if($act_type == "Recruitment"){
    $tab = "rec_activity_track";
    $a_type = "Recuitment";
  }
  elseif($act_type == "Sales"){
    $tab = "sales_activity_track";
    $a_type = "Sales";
  }
  elseif($act_type == "Other"){
    $tab = "other_activity_track";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Activity Review</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="st_common.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
      <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>

  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Daily Activity Report</strong></p>
    </div>
    <br>
    <div class="container">
      <h3>Activity Review</h3>
    	<small>Let's see what our world has been upto, shall we?</small>
      <div class="section">
        <?php
        switch($m_type){
          case "areamanager":

          $sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$sno."'";
          $res_sm = $conn->query($sql_sm);
          if($res_sm->num_rows){
            while($row_sm = $res_sm->fetch_assoc()){
              $sm_sno  = $row_sm["sno"];
              $sql_act = "SELECT * FROM ".$tab." WHERE man_id = '".$sm_sno."'";
              $res_act = $conn->query($sql_act);
              if($res_act->num_rows){

                echo "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>Manager ID</th>
                          <th scope='col'>Manager Name</th>
                          <th scope='col'>Activity Type</th>
                          <th scope='col'>Activity Date</th>
                          <th scope='col'>Detailed View</th>
                        </tr>
                      </thead>";
                while($row_act = $res_act->fetch_assoc()){
                  if($act_type == "Other"){
                    $a_type = $row_act["act_type"];
                  }
                  $act_date = $row_act["activity_date"];
                  $act_date = date("d-M-Y", strtotime($act_date));
                  if(($act_date >= $from_date) && ($act_date <= $to_date)){
                    echo "<tr>
                            <td>".$row_act["man_id"]."</td>
                            <td>".$row_act["man_name" ]."</td>
                            <td>".$a_type."</td>
                            <td>".$row_act["activity_date"]."</td>
                            <td><a class='btn btn-sm btn-info' role='button' target='_blank' href='view_act_det.php?sn=".$row_act["sno"]."&typ=".$act_type."'>Review Activity</a></td>
                            </tr>";
                  }

                }
                echo "</table>";
              }
              else{
                echo"Hmm! We didn't notice any recent activty there! Check the range you provided us with!";
              }
            }
          }
          break;
          case "regionalmanager":
          $sql_act = "SELECT * FROM ".$tab."";
          $res_act = $conn->query($sql_act);
          if($res_act->num_rows){
            echo "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Manager ID</th>
                      <th scope='col'>Manager Name</th>
                      <th scope='col'>Activity Type</th>
                      <th scope='col'>Activity Date</th>
                      <th scope='col'>Detailed View</th>
                    </tr>
                  </thead>";
                  while($row_act = $res_act->fetch_assoc()){
                    if(!(isset($a_type))){
                      $a_type = $row_act["act_type"];
                    }
                    $act_date = $row_act["activity_date"];
                    $act_date = date("d-M-Y", strtotime($act_date));
                    if(($act_date >= $from_date) && ($act_date <= $to_date)){
                      echo "<tr>
                              <td>".$row_act["man_id"]."</td>
                              <td>".$row_act["man_name" ]."</td>
                              <td>".$a_type."</td>
                              <td>".$row_act["activity_date"]."</td>
                              <td><a class='btn btn-sm btn-info' role='button' target='_blank' href='view_act_det.php?sn=".$row_act["sno"]."&typ=".$act_type."'>Review Activity</a></td>
                              </tr>";
                    }
                    else{
                      echo"Hmm! We didn't notice any recent activty there! Check the range you provided us with!";
                    }
                  }
                  echo "</table>";

          }
          break;
        }
        ?>
      </div>
    </div>
  </body>
</html>
