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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Recent Itineraries</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="st_common.css">

  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="../sales_dash.php"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Recent Packages</strong></p>
    </div>
    <br>
    <div class="container-fluid">
      <h3>Recent Itineraries</h3>
      <small>Need help, <?php echo $d_name ?>? Search for a destination and get all the information you need!</small>
      <div class="section">
        <form class="" action="" method="get">
          <div class="form-group row">
            <label for="dest" class="col-sm-2 col-form-label">Enter destination:</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name = "dest" id="dest" placeholder="Enter Destination">

              <small>Enter the destation in the above input box to get a list of packages!</small>
            </div>
            <div class="col-sm-4">
              <button type="submit" name="submit" id = 'submit' class = 'form-control btn btn-sm btn-secondary'>Get Details</button>
            </div>
          </div>
        </form>
      </div>
      <br>
      <br>
      <div>
        <?php
        if(isset($_GET["submit"])){
          $search_term = $_GET["dest"];
          $sql_pack = "SELECT * FROM agent_form_data WHERE holi_dest LIKE '%".$search_term."%' AND (formstatus = 'submitted' OR formstatus = 'confirmed') AND ref_num > 250 ORDER BY datesent DESC";
          $res_pack = $conn->query($sql_pack);
          if($res_pack->num_rows){
            echo"<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>GHR Number</th>
                      <th scope='col'>Destination</th>
                      <th scope='col'>Start Date</th>
                      <th scope='col'>End Date</th>
                      <th scope='col'>Duration</th>
                      <th scope='col'>View</th>
                    </tr>
                  </thead>
                ";
                while($row_pack = $res_pack->fetch_assoc()){
                  echo"<tr>
                      <td>GHRN".(5000+(int)$row_pack["ref_num"])."</td>
                      <td>".$row_pack["holi_dest"]."</td>
                      <td>".$row_pack["date_of_travel"]."</td>
                      <td>".$row_pack["return_date_of_travel"]."</td>
                      <td>".$row_pack["duration"]."</td>
                      <td><a class='btn btn-info' href='view.php?q=".$row_pack["ref_num"]."&r=".$row_pack["holi_type"]."'>View</a></td>
                      </tr>";
                }
                echo"</table>";
          }
          else{
            echo"No Packages with such destination found please modify your search";
          }
        }
        ?>
      </div>
    </div>
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
  </body>
</html>
