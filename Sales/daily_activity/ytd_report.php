<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$name = $_SESSION["name"];
$userid = $_SESSION["userid"];
$sno = $_SESSION["sno"];
$sql_m_type = "SELECT * FROM managers_data WHERE sno = '".$sno."'";
$res_m_type = $conn->query($sql_m_type);
if($res_m_type->num_rows){
  if($row_m_type = $res_m_type->fetch_assoc()){
    $m_type = $row_m_type["type"];
  }
}
$status = 0;
if(isset($_POST["ytd_sub"])){
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

  //getting manager name
  $man_name = $_POST["m_sel"];
  //itinerary type
  $iti_typ = $_POST["iti_sel"];

  switch($iti_typ){
    case "pending":

    $sql_ytd = "SELECT * FROM agent_form_data WHERE form_filled_by = '".$man_name."' AND formstatus = 'pending'";
    $res_ytd = $conn->query($sql_ytd);
    if($res_ytd->num_rows){

      $data = "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>GHRN</th>
                      <th scope='col'>Customer Name</th>
                      <th scope='col'>Partner's Name</th>
                      <th scope='col'>Holiday Type</th>
                      <th scope='col'>Sent Date</th>
                    </tr>
                  </thead>";
      while($row_ytd = $res_ytd->fetch_assoc()){

        $sent_dt = (date("d-M-Y", strtotime($row_ytd["datesent"])));

        if(($sent_dt >= $from_date) && ($sent_dt <= $to_date)){

          $status = 1;
          $ref_num = (5000 + (int)$row_ytd["ref_num"]);
          $cus_name = $row_ytd["cust_firstname"]." ".$row_ytd["cust_lastname"];
          $holi_type = $row_ytd["holi_type"];
          $sent_dt = (date("d-M-Y", strtotime($row_ytd["datesent"])));
          $par_sno = $row_ytd["sales_partner_name"];
          $par_type = $row_ytd["holi_partner_name"];
          $tab_name = $par_type."s";
          $sql_par = "SELECT * FROM ".$tab_name." WHERE sno = '".$par_sno."'";
          $res_par = $conn->query($sql_par);
          if($res_par->num_rows){
            if($row_par = $res_par->fetch_assoc()){
              $par_name = $row_par["name"];
            }
          }
          $data .= "<tr>
                          <td>GHRN".$ref_num."</td>
                          <td>".$cus_name."</td>
                          <td>".$par_name."</td>
                          <td>".$holi_type."</td>
                          <td>".$sent_dt."</td>
                        </tr>
                    ";
        }
        else{
          $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
        }

      }
      $data .= "</table>";
    }
    else{
      $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
    }
    break;
    case "submitted":


    $sql_ytd = "SELECT * FROM agent_form_data WHERE form_filled_by = '".$man_name."' AND formstatus = 'submitted'";
    $res_ytd = $conn->query($sql_ytd);
    if($res_ytd->num_rows){
      $data = "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>GHRN</th>
                      <th scope='col'>Customer Name</th>
                      <th scope='col'>Partner's Name</th>
                      <th scope='col'>Holiday Type</th>
                      <th scope='col'>Sent Date</th>
                    </tr>
                  </thead>";
      while($row_ytd = $res_ytd->fetch_assoc()){
        $sent_dt = (date("d-M-Y", strtotime($row_ytd["senttocustomerdate"])));
        if(($sent_dt >= $from_date) && ($sent_dt <= $to_date)){
          $status = 1;

          $ref_num = (5000 + (int)$row_ytd["ref_num"]);
          $cus_name = $row_ytd["cust_firstname"]." ".$row_ytd["cust_lastname"];
          $holi_type = $row_ytd["holi_type"];
          $sent_dt = (date("d-M-Y", strtotime($row_ytd["senttocustomerdate"])));
          $par_sno = $row_ytd["sales_partner_name"];
          $par_type = $row_ytd["holi_partner_name"];
          $tab_name = $par_type."s";
          $sql_par = "SELECT * FROM ".$tab_name." WHERE sno = '".$par_sno."'";
          $res_par = $conn->query($sql_par);
          if($res_par->num_rows){
            if($row_par = $res_par->fetch_assoc()){
              $par_name = $row_par["name"];
            }
          }
          $data .= "<tr>
                          <td>GHRN".$ref_num."</td>
                          <td>".$cus_name."</td>
                          <td>".$par_name."</td>
                          <td>".$holi_type."</td>
                          <td>".$sent_dt."</td>
                        </tr>
                    ";
        }
        else{
          $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
        }
      }
      $data .= "</table>";
    }
    else{
      $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
    }

    break;
    case "confirmed":

    $sql_ytd = "SELECT * FROM agent_form_data WHERE form_filled_by = '".$man_name."' AND formstatus = 'confirmed'";
    $res_ytd = $conn->query($sql_ytd);
    if($res_ytd->num_rows){
      
      $data = "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>GHRN</th>
                      <th scope='col'>Customer Name</th>
                      <th scope='col'>Partner's Name</th>
                      <th scope='col'>Holiday Type</th>
                      <th scope='col'>Sent Date</th>
                    </tr>
                  </thead>";
      while($row_ytd = $res_ytd->fetch_assoc()){
        $sent_dt = (date("d-M-Y", strtotime($row_ytd["confirmeddate"])));
        if(($sent_dt >= $from_date) && ($sent_dt <= $to_date)){
          $status = 1;

          $ref_num = (5000 + (int)$row_ytd["ref_num"]);
          $cus_name = $row_ytd["cust_firstname"]." ".$row_ytd["cust_lastname"];
          $holi_type = $row_ytd["holi_type"];
          $sent_dt = (date("d-M-Y", strtotime($row_ytd["confirmeddate"])));
          $par_sno = $row_ytd["sales_partner_name"];
          $par_type = $row_ytd["holi_partner_name"];
          $tab_name = $par_type."s";
          $sql_par = "SELECT * FROM ".$tab_name." WHERE sno = '".$par_sno."'";
          $res_par = $conn->query($sql_par);
          if($res_par->num_rows){
            if($row_par = $res_par->fetch_assoc()){
              $par_name = $row_par["name"];
            }
          }
          $data .= "<tr>
                          <td>GHRN".$ref_num."</td>
                          <td>".$cus_name."</td>
                          <td>".$par_name."</td>
                          <td>".$holi_type."</td>
                          <td>".$sent_dt."</td>
                        </tr>
                    ";
        }
        else{
          $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
        }
      }
      $data .= "</table>";
    }
    else{
      $err = "Hmm! We looked! Alot! But couldn't find anything to match your requirements, maybe modify them a little bit!?";
    }
    break;
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>YTD View</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="st_common.css">
  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="../sales_dash.php"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Issued Vouchers</strong></p>
    </div>
    <br>
    <div class="container">
      <h3>YTD View</h3>
      <div class="section">
        <?php if($status == 1){echo $data;}else{echo $err;} ?>
      </div>
    </div>
  </body>
</html>
