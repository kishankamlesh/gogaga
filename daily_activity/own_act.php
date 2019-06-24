<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
//include "config.php";
session_start();
if(!(isset($_SESSION["userid"]))){
  header("location:index.html");
}
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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Review Own Activity</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="st_common.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
      <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
      <script type="text/javascript" src = 's_activity_report.js'></script>
  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Daily Activity Report</strong></p>
    </div>
    <br>

    <div class="container">
      <h3>Own Activity Review</h3>
    	<small>Let's see what you've been upto recently, shall we?</small>
      <div class="section">
        <h6>Sales Activity</h6>
        <?php
        $sql_act_sal = "SELECT * FROM sales_activity_track WHERE man_id = '".$sno."' ORDER BY activity_date DESC";
        $res_act_sal = $conn->query($sql_act_sal);
        if($res_act_sal->num_rows){
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
          while($row_act_sal = $res_act_sal->fetch_assoc()){
            echo "<tr>
                    <td>".$row_act_sal["man_id"]."</td>
                    <td>".$row_act_sal["man_name" ]."</td>
                    <td>Sales</td>
                    <td>".$row_act_sal["activity_date"]."</td>
                    <td><a class='btn btn-sm btn-info' role='button' target='_blank' href='view_act_det.php?sn=".$row_act_sal["sno"]."&typ=Sales'>Review Activity</a></td>
                    </tr>";
          }
          echo "</table>";
        }
        else{
          echo"Hmm! We didn't notice any activty there! Hustle!";
        }
        ?>
      </div>
      <div class="section">
        <h6>Recruitment Activity</h6>
        <?php
        $sql_act_rec = "SELECT * FROM rec_activity_track WHERE man_id = '".$sno."' ORDER BY activity_date DESC";
        $res_act_rec = $conn->query($sql_act_rec);
        if($res_act_rec->num_rows){
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
          while($row_act_rec = $res_act_rec->fetch_assoc()){
            echo "<tr>
                    <td>".$row_act_rec["man_id"]."</td>
                    <td>".$row_act_rec["man_name" ]."</td>
                    <td>Recruitment</td>
                    <td>".$row_act_rec["activity_date"]."</td>
                    <td><a class='btn btn-sm btn-info' role='button' target='_blank' href='view_act_det.php?sn=".$row_act_rec["sno"]."&typ=Recruitment'>Review Activity</a></td>
                    </tr>";
          }
          echo "</table>";
        }
        else{
          echo"Hmm! We didn't notice any activty there! Hustle!";
        }
        ?>
      </div>
      <div class="section">
        <h6>Other Activity</h6>
        <?php
        $sql_act_oth = "SELECT * FROM other_activity_track WHERE man_id = '".$sno."' ORDER BY activity_date DESC";
        $res_act_oth = $conn->query($sql_act_oth);
        if($res_act_oth->num_rows){
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
          while($row_act_oth = $res_act_oth->fetch_assoc()){
            echo "<tr>
                    <td>".$row_act_oth["man_id"]."</td>
                    <td>".$row_act_oth["man_name"]."</td>
                    <td>".$row_act_oth["act_type"]."</td>
                    <td>".$row_act_rec["activity_date"]."</td>
                    <td><a class='btn btn-sm btn-info' role='button' target='_blank' href='view_act_det.php?sn=".$row_act_rec["sno"]."&typ=Other'>Review Activity</a></td>
                    </tr>";
          }
          echo "</table>";
        }
        else{
          echo"Hmm! We didn't notice any activty there! Hustle!";
        }
        ?>
      </div>
    </div>
  </body>
</html>
