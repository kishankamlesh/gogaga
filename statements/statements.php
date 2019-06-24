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
if(isset($_POST["submit"])){
  $p_id = $_POST["p_name"];
  $p_type = $_POST["p_type"];
  $sql_com = "SELECT * FROM commissions WHERE (sup_sno = '".$p_id."' OR holi_sno = '".$p_id."' OR sal_sno = '".$p_id."') AND status = 'confirmed' ORDER BY ghrno DESC";
  $res_com = $conn->query($sql_com);
  if($res_com->num_rows){
    $data = "<table class='table'>
              <thead class='thead-light'>
                <tr>
                  <th scope='col'>GHR Number</th>
                  <th scope='col'>Customer Name</th>
                  <th scope='col'>Holiday Type</th>
                  <th scope='col'>Destination</th>
                  <th scope='col'>Super Partner Commision</th>
                  <th scope='col'>Holiday Partner Commision</th>
                  <th scope='col'>Sales Partner Commision</th>
                  <th scope='col'></th>
                </tr>
              </thead>";
          while($row_com = $res_com->fetch_assoc()){
            $data .= "<tr>
                    <td>GHRN".(5000+(int)$row_com["ghrno"])."</td>
                    <td>".$row_com["clientname"]."</td>
                    <td>".$row_com["holitype"]."</td>
                    <td>".$row_com["holidest"]."</td>
                    <td>".$row_com["sup"]."</td>
                    <td>".$row_com["hol"]."</td>
                    <td>".$row_com["sal"]."</td>
                    <td><a class='btn btn-info' target = '_blank' href='viewst.php?id=".$p_id."&type=".$p_type."&ghr=".$row_com["ghrno"]."'>View</a></td>

                    </tr>";
          }
          $data .= "</table>";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Issued Statements</title>
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
  		<p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Issued Statements</strong></p>
  	</div>
    <div class="container-fluid">
      <div class="section">
        <?php if(isset($data)){echo $data;} else{echo"No statements to display";}?>
      </div>
    </div>
  </body>
</html>
