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
switch ($m_type){
  case "salesmanager":
  //getting sales partner forms who are under him
  $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
  $res_sp = $conn->query($sql_sp);
  if($res_sp->num_rows){
    while($row_sp = $res_sp->fetch_assoc()){
      $sp_sno = $row_sp["sno"];
      $sql_sp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sp_sno."' ORDER BY ref_num DESC";
      $res_sp_forms = $conn->query($sql_sp_forms);
      if($res_sp_forms->num_rows){
        $msg_sp = "<br><h4>Sales Partner Clients</h4><br>";
        $data_sp = "<table class='table'>
              <thead class='thead-light'>
                <tr>
                  <th scope='col'>Customer Name</th>
                  <th scope='col'>Contact</th>
                  <th scope='col'>Partner's Name</th>
                  <th scope='col'>Email</th>
                  <th scope='col'>Location</th>
                  <th scope='col'>Holiday Type</th>
                  <th scope='col'>Destination</th>
                  <th scope='col'>Form Status</th>
                </tr>
              </thead>
              ";
              while($row_sp_forms = $res_sp_forms->fetch_assoc()){
                $data_sp .= "<tr>
                        <td>".$row_sp_forms["cust_firstname"]." ".$row_sp_forms["cust_lastname"]."</td>
                        <td>".$row_sp_forms["contact_phone" ]."</td>
                        <td>".$row_sp_forms["form_filled_by"]."</td>
                        <td>".$row_sp_forms["cust_email"]."</td>
                        <td>".$row_sp_forms["cust_addr"]."</td>
                        <td>".$row_sp_forms["holi_type"]."</td>
                        <td>".$row_sp_forms["holi_dest"]."</td>
                        <td>".$row_sp_forms["formstatus"]."</td>
                        </tr>";
              }
              $data_sp .= "</table>";
      }
    }
  }
  //getting holiday partner forms
  $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    if($row_sm = $res_sm->fetch_assoc()){
      $hp_id = $row_sm["hp_sno"];
      $sql_hp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$hp_id."' ORDER BY ref_num DESC";
      $res_hp_forms = $conn->query($sql_hp_forms);
      if($res_hp_forms->num_rows){
        $msg_hp = "<br><h4>Holiday Partner Clients</h4><br>";
        $data_hp = "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                        <th scope='col'>Customer Name</th>
                        <th scope='col'>Contact</th>
                        <th scope='col'>Partner's Name</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Location</th>
                        <th scope='col'>Holiday Type</th>
                        <th scope='col'>Destination</th>
                        <th scope='col'>Form Status</th>
                        </tr>
                      </thead>
              ";
              while($row_hp_forms = $res_hp_forms->fetch_assoc()){
                $data_hp .= "<tr>
                              <td>".$row_hp_forms["cust_firstname"]." ".$row_hp_forms["cust_lastname"]."</td>
                              <td>".$row_hp_forms["contact_phone" ]."</td>
                              <td>".$row_hp_forms["form_filled_by"]."</td>
                              <td>".$row_hp_forms["cust_email"]."</td>
                              <td>".$row_hp_forms["cust_addr"]."</td>
                              <td>".$row_hp_forms["holi_type"]."</td>
                              <td>".$row_hp_forms["holi_dest"]."</td>
                              <td>".$row_hp_forms["formstatus"]."</td>
                            </tr>";
              }
              $data_hp .= "</table>";
        }
      }
    }
    //getting super partner forms
    $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
    $res_sm = $conn->query($sql_sm);
    if($res_sm->num_rows){
      if($row_sm = $res_sm->fetch_assoc()){
        $hp_id = $row_sm["hp_sno"];
        $sql_hp = "SELECT * FROM holidaypartners WHERE sno = '".$hp_id."'";
        $res_hp = $conn->query($sql_hp);
        if($res_hp->num_rows){
                if($row_hp = $res_hp->fetch_assoc()){
                  $sup_id = $row_hp["super_partner_sno"];
                  $sql_sup_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sup_id."' ORDER BY ref_num DESC";
                  $res_sup_forms = $conn->query($sql_sup_forms);
                  if($res_sup_forms->num_rows){
                    $msg_sup = "<br><h4>Super Partner Clients</h4><br>";
                    $data_sup = "<table class='table'>
                            <thead class='thead-light'>
                              <tr>
                              <th scope='col'>Customer Name</th>
                              <th scope='col'>Contact</th>
                              <th scope='col'>Partner's Name</th>
                              <th scope='col'>Email</th>
                              <th scope='col'>Location</th>
                              <th scope='col'>Holiday Type</th>
                              <th scope='col'>Destination</th>
                              <th scope='col'>Form Status</th>
                              </tr>
                            </thead>
                          ";
                    while($row_sup_forms = $res_sup_forms->fetch_assoc()){
                      $data_sup .= "<tr>
                                      <td>".$row_sup_forms["cust_firstname"]." ".$row_sup_forms["cust_lastname"]."</td>
                                      <td>".$row_sup_forms["contact_phone" ]."</td>
                                      <td>".$row_sup_forms["form_filled_by"]."</td>
                                      <td>".$row_sup_forms["cust_email"]."</td>
                                      <td>".$row_sup_forms["cust_addr"]."</td>
                                      <td>".$row_sup_forms["holi_type"]."</td>
                                      <td>".$row_sup_forms["holi_dest"]."</td>
                                      <td>".$row_sup_forms["formstatus"]."</td>
                                    </tr>";
                    }
                    $data_sup .= "</table>";
                  }
                }
          }
        }
      }
  break;
  case "areamanager":
  //get sales partners forms
  $sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    while($row_sm=$res_sm->fetch_assoc()){
      $sm_id = $row_sm["sno"];
      $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sm_id."'";
      $res_sp = $conn->query($sql_sp);
      if($res_sp->num_rows){
        while($row_sp = $res_sp->fetch_assoc()){
          $sp_sno = $row_sp["sno"];
          $sql_sp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sp_sno."' ORDER BY ref_num DESC";
          $res_sp_forms = $conn->query($sql_sp_forms);
          if($res_sp_forms->num_rows){
            $msg_sp = "<br><h4>Sales Partner Clients</h4><br>";
            $data_sp .= "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Customer Name</th>
                      <th scope='col'>Contact</th>
                      <th scope='col'>Partner's Name</th>
                      <th scope='col'>Email</th>
                      <th scope='col'>Location</th>
                      <th scope='col'>Holiday Type</th>
                      <th scope='col'>Destination</th>
                      <th scope='col'>Form Status</th>
                    </tr>
                  </thead>
                  ";
                  while($row_sp_forms = $res_sp_forms->fetch_assoc()){
                    $data_sp .= "<tr>
                            <td>".$row_sp_forms["cust_firstname"]." ".$row_sp_forms["cust_lastname"]."</td>
                            <td>".$row_sp_forms["contact_phone" ]."</td>
                            <td>".$row_sp_forms["form_filled_by"]."</td>
                            <td>".$row_sp_forms["cust_email"]."</td>
                            <td>".$row_sp_forms["cus_addr"]."</td>
                            <td>".$row_sp_forms["holi_type"]."</td>
                            <td>".$row_sp_forms["holi_dest"]."</td>
                            <td>".$row_sp_forms["formstatus"]."</td>
                            </tr>";
                  }
                  $data_sp .= "</table>";
          }
        }
      }
    }
  }
  //getting holiday partner forms
  $sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
  $res_hp = $conn->query($sql_hp);
  if($res_hp->num_rows){
    while($row_hp = $res_hp->fetch_assoc()){
      $hp_id = $row_hp["sno"];
      $sql_hp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$hp_id."' ORDER BY ref_num DESC";
      $res_hp_forms = $conn->query($sql_hp_forms);
      if($res_hp_forms->num_rows){
        $msg_hp = "<br><h4>Holiday Partner Clients</h4><br>";
        $data_hp = "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                        <th scope='col'>Customer Name</th>
                        <th scope='col'>Contact</th>
                        <th scope='col'>Partner's Name</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Location</th>
                        <th scope='col'>Holiday Type</th>
                        <th scope='col'>Destination</th>
                        <th scope='col'>Form Status</th>
                        </tr>
                      </thead>
              ";
              while($row_hp_forms = $res_hp_forms->fetch_assoc()){
                $data_hp .= "<tr>
                              <td>".$row_hp_forms["cust_firstname"]." ".$row_hp_forms["cust_lastname"]."</td>
                              <td>".$row_hp_forms["contact_phone" ]."</td>
                              <td>".$row_hp_forms["form_filled_by"]."</td>
                              <td>".$row_hp_forms["cust_email"]."</td>
                              <td>".$row_hp_forms["cust_addr"]."</td>
                              <td>".$row_hp_forms["holi_type"]."</td>
                              <td>".$row_hp_forms["holi_dest"]."</td>
                              <td>".$row_hp_forms["formstatus"]."</td>
                            </tr>";
              }
              $data_hp .= "</table>";
        }
    }
  }
  //getting super partner form
  $sql_hp_sup = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
  $res_hp_sup = $conn->query($sql_hp_sup);
  if($res_hp_sup->num_rows){
    if($row_hp_sup = $res_hp_sup->fetch_assoc()){
      $sup_id = $row_hp_sup["super_partner_sno"];
      $sql_sup_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sup_id."' ORDER BY ref_num DESC";
      $res_sup_forms = $conn->query($sql_sup_forms);
      if($res_sup_forms->num_rows){
        $msg_sup = "<br><h4>Super Partner Clients</h4><br>";
        $data_sup = "<table class='table'>
                <thead class='thead-light'>
                  <tr>
                  <th scope='col'>Customer Name</th>
                  <th scope='col'>Contact</th>
                  <th scope='col'>Partner's Name</th>
                  <th scope='col'>Email</th>
                  <th scope='col'>Location</th>
                  <th scope='col'>Holiday Type</th>
                  <th scope='col'>Destination</th>
                  <th scope='col'>Form Status</th>
                  </tr>
                </thead>
              ";
        while($row_sup_forms = $res_sup_forms->fetch_assoc()){
          $data_sup .= "<tr>
                          <td>".$row_sup_forms["cust_firstname"]." ".$row_sup_forms["cust_lastname"]."</td>
                          <td>".$row_sup_forms["contact_phone" ]."</td>
                          <td>".$row_sup_forms["form_filled_by"]."</td>
                          <td>".$row_sup_forms["cust_email"]."</td>
                          <td>".$row_sup_forms["cust_addr"]."</td>
                          <td>".$row_sup_forms["holi_type"]."</td>
                          <td>".$row_sup_forms["holi_dest"]."</td>
                          <td>".$row_sup_forms["formstatus"]."</td>
                        </tr>";
        }
        $data_sup .= "</table>";
      }
    }
  }
  break;
  case "regionalmanager":
  //all data will be displayed for regional manager
  $sql_rm = "SELECT * FROM agent_form_data ORDER BY ref_num DESC";
  $res_rm = $conn->query($sql_rm);
  if($res_rm->num_rows){
    $msg_rm = "<br><h4>Partner Requests</h4><br>";
    $data_rm = "<table class='table'>
          <thead class='thead-light'>
            <tr>
            <th scope='col'>Customer Name</th>
            <th scope='col'>Contact</th>
            <th scope='col'>Partner's Name</th>
            <th scope='col'>Email</th>
            <th scope='col'>Location</th>
            <th scope='col'>Holiday Type</th>
            <th scope='col'>Destination</th>
            <th scope='col'>Form Status</th>
            </tr>
          </thead>
          ";
    while($row_rm = $res_rm->fetch_assoc()){
      $datesent =date_create($row_rm["datesent"]);
      $datesent =date_format($datesent,"d-M-Y");
      $data_rm .= "<tr>
                    <td>".$row_rm["cust_firstname"]." ".$row_rm["cust_lastname"]."</td>
                    <td>".$row_rm["contact_phone" ]."</td>
                    <td>".$row_rm["form_filled_by"]."</td>
                    <td>".$row_rm["cust_email"]."</td>
                    <td>".$row_rm["cust_addr"]."</td>
                    <td>".$row_rm["holi_type"]."</td>
                    <td>".$row_rm["holi_dest"]."</td>
                    <td>".$row_rm["formstatus"]."</td>
                  </tr>";
    }
    $data_rm .= "</table>";

  }
  break;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Clients</title>
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
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Client Base</strong></p>
    </div>
    <br>
    <div class="container-fluid">
      <h3>Clients Base</h3>
      <small>Hey there, <?php echo $d_name ?>! Here are all the <strong>clients</strong> you <i>feel</i> related to! We hope!</small>
      <div class="container-fluid">
        <?php
          switch($m_type){
            case "salesmanager":
            if((isset($msg_sup)) && (isset($data_sup))){
              echo $msg_sup;
              echo $data_sup;
            }
            if((isset($msg_hp)) && (isset($data_hp))){
              echo $msg_hp;
              echo $data_hp;
            }
            if((isset($msg_sp)) && (isset($data_sp))){
              echo $msg_sp;
              echo $data_sp;
            }
            break;
            case "areamanager":
            if((isset($msg_sup)) && (isset($data_sup))){
              echo $msg_sup;
              echo $data_sup;
            }
            if((isset($msg_hp)) && (isset($data_hp))){
              echo $msg_hp;
              echo $data_hp;
            }
            if((isset($msg_sp)) && (isset($data_sp))){
              echo $msg_sp;
              echo $data_sp;
            }
            break;
            case "regionalmanager":
            if((isset($msg_rm)) && (isset($data_rm))){
              echo $msg_rm;
              echo $data_rm;
            }
            break;
          }
        ?>
      </div>
    </div>
  </body>
</html>
