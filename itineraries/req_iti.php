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
    <title>Requested Itineraries</title>
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
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Requested Itineraries</strong></p>
    </div>
    <br>
    <div class="container-fluid">
      <h3>Requested Itineraries</h3>
      <small>Hey there, <?php echo $d_name ?>! This is all that's <strong>pending </strong>on the shelf!</small>
      <div class="container-fluid">
        <?php
          switch ($m_type){
            case "salesmanager":
            //getting sales partner forms who are under him
            $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
            $res_sp = $conn->query($sql_sp);
            if($res_sp->num_rows){
              while($row_sp = $res_sp->fetch_assoc()){
                $sp_sno = $row_sp["sno"];
                $sql_sp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sp_sno."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                $res_sp_forms = $conn->query($sql_sp_forms);
                if($res_sp_forms->num_rows){
                  echo "<br><h4>Sales Partner Requests</h4><br>
                        <table class='table'>
                        <thead class='thead-light'>
                          <tr>
                            <th scope='col'>GHR Number</th>
                            <th scope='col'>Customer Name</th>
                            <th scope='col'>Form Raised By</th>
                            <th scope='col'>Partner's Name</th>
                            <th scope='col'>Destination</th>
                            <th scope='col'>Start Date</th>
                            <th scope='col'>End Date</th>
                            <th scope='col'>Duration</th>
                            <th scope='col'>Form Requested on</th>
                          </tr>
                        </thead>
                        ";
                        while($row_sp_forms = $res_sp_forms->fetch_assoc()){
                          $datesent =date_create($row_sp_forms["datesent"]);
                          $datesent =date_format($datesent,"d-M-Y");
                          echo "<tr>
                                  <td>GHRN".(5000+(int)$row_sp_forms["ref_num"])."</td>
                                  <td>".$row_sp_forms["cust_firstname"]." ".$row_sp_forms["cust_lastname"]."</td>
                                  <td>".$row_sp_forms["form_filled_by"]."</td>
                                  <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                  <td>".$row_sp_forms["holi_dest"]."</td>
                                  <td>".$row_sp_forms["date_of_travel"]."</td>
                                  <td>".$row_sp_forms["return_date_of_travel"]."</td>
                                  <td>".$row_sp_forms["duration"]."</td>
                                  <td>".$datesent."</td>
                                  </tr>";
                        }
                        echo"</table>";
                }
              }
            }
            //getting holiday partner forms
            $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
            $res_sm = $conn->query($sql_sm);
            if($res_sm->num_rows){
              if($row_sm = $res_sm->fetch_assoc()){
                $hp_id = $row_sm["hp_sno"];
                $sql_hp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$hp_id."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                $res_hp_forms = $conn->query($sql_hp_forms);
                if($res_hp_forms->num_rows){
                  echo "<br><h4>Holiday Partner Requests</h4><br>
                        <table class='table'>
                        <thead class='thead-light'>
                          <tr>
                            <th scope='col'>GHR Number</th>
                            <th scope='col'>Customer Name</th>
                            <th scope='col'>Form Raised By</th>
                            <th scope='col'>Partner's Name</th>
                            <th scope='col'>Destination</th>
                            <th scope='col'>Start Date</th>
                            <th scope='col'>End Date</th>
                            <th scope='col'>Duration</th>
                            <th scope='col'>Form Requested on</th>
                          </tr>
                        </thead>
                        ";
                        while($row_hp_forms = $res_hp_forms->fetch_assoc()){
                          $datesent =date_create($row_hp_forms["datesent"]);
                          $datesent =date_format($datesent,"d-M-Y");
                          echo "<tr>
                                  <td>GHRN".(5000+(int)$row_hp_forms["ref_num"])."</td>
                                  <td>".$row_hp_forms["cust_firstname"]." ".$row_hp_forms["cust_lastname"]."</td>
                                  <td>".$row_hp_forms["form_filled_by"]."</td>
                                  <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                  <td>".$row_hp_forms["holi_dest"]."</td>
                                  <td>".$row_hp_forms["date_of_travel"]."</td>
                                  <td>".$row_hp_forms["return_date_of_travel"]."</td>
                                  <td>".$row_hp_forms["duration"]."</td>
                                  <td>".$datesent."</td>
                                  </tr>";
                        }
                        echo"</table>";
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
                            $sql_sup_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sup_id."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                            $res_sup_forms = $conn->query($sql_sup_forms);
                            if($res_sup_forms->num_rows){
                              echo "<br><h4>Super Partner Requests</h4><br>
                                    <table class='table'>
                                    <thead class='thead-light'>
                                      <tr>
                                        <th scope='col'>GHR Number</th>
                                        <th scope='col'>Customer Name</th>
                                        <th scope='col'>Form Raised By</th>
                                        <th scope='col'>Partner's Name</th>
                                        <th scope='col'>Destination</th>
                                        <th scope='col'>Start Date</th>
                                        <th scope='col'>End Date</th>
                                        <th scope='col'>Duration</th>
                                        <th scope='col'>Form Requested on</th>
                                      </tr>
                                    </thead>
                                    ";
                              while($row_sup_forms = $res_sup_forms->fetch_assoc()){
                                $datesent =date_create($row_sup_forms["datesent"]);
                                $datesent =date_format($datesent,"d-M-Y");
                                echo "<tr>
                                        <td>GHRN".(5000+(int)$row_sup_forms["ref_num"])."</td>
                                        <td>".$row_sup_forms["cust_firstname"]." ".$row_sup_forms["cust_lastname"]."</td>
                                        <td>".$row_sup_forms["form_filled_by"]."</td>
                                        <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                        <td>".$row_sup_forms["holi_dest"]."</td>
                                        <td>".$row_sup_forms["date_of_travel"]."</td>
                                        <td>".$row_sup_forms["return_date_of_travel"]."</td>
                                        <td>".$row_sup_forms["duration"]."</td>
                                        <td>".$datesent."</td>
                                        </tr>";
                              }
                              echo"</table>";
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
                    $sql_sp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sp_sno."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                    $res_sp_forms = $conn->query($sql_sp_forms);
                    if($res_sp_forms->num_rows){
                      echo "<br><h4>Sales Partner Requests</h4><br>
                            <table class='table'>
                            <thead class='thead-light'>
                              <tr>
                                <th scope='col'>GHR Number</th>
                                <th scope='col'>Customer Name</th>
                                <th scope='col'>Form Raised By</th>
                                <th scope='col'>Partner's Name</th>
                                <th scope='col'>Destination</th>
                                <th scope='col'>Start Date</th>
                                <th scope='col'>End Date</th>
                                <th scope='col'>Duration</th>
                                <th scope='col'>Form Requested on</th>
                              </tr>
                            </thead>
                            ";
                            while($row_sp_forms = $res_sp_forms->fetch_assoc()){
                              $datesent =date_create($row_sp_forms["datesent"]);
                              $datesent =date_format($datesent,"d-M-Y");
                              echo "<tr>
                                      <td>GHRN".(5000+(int)$row_sp_forms["ref_num"])."</td>
                                      <td>".$row_sp_forms["cust_firstname"]." ".$row_sp_forms["cust_lastname"]."</td>
                                      <td>".$row_sp_forms["form_filled_by"]."</td>
                                      <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                      <td>".$row_sp_forms["holi_dest"]."</td>
                                      <td>".$row_sp_forms["date_of_travel"]."</td>
                                      <td>".$row_sp_forms["return_date_of_travel"]."</td>
                                      <td>".$row_sp_forms["duration"]."</td>
                                      <td>".$datesent."</td>
                                      </tr>";
                            }
                            echo"</table>";
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
                $sql_hp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$hp_id."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                $res_hp_forms = $conn->query($sql_hp_forms);
                if($res_hp_forms->num_rows){
                  echo "<br><h4>Holiday Partner Requests</h4><br>
                        <table class='table'>
                        <thead class='thead-light'>
                          <tr>
                            <th scope='col'>GHR Number</th>
                            <th scope='col'>Customer Name</th>
                            <th scope='col'>Form Raised By</th>
                            <th scope='col'>Partner's Name</th>
                            <th scope='col'>Destination</th>
                            <th scope='col'>Start Date</th>
                            <th scope='col'>End Date</th>
                            <th scope='col'>Duration</th>
                            <th scope='col'>Form Requested on</th>
                          </tr>
                        </thead>
                        ";
                        while($row_hp_forms = $res_hp_forms->fetch_assoc()){
                          $datesent =date_create($row_hp_forms["datesent"]);
                          $datesent =date_format($datesent,"d-M-Y");
                          echo "<tr>
                                  <td>GHRN".(5000+(int)$row_hp_forms["ref_num"])."</td>
                                  <td>".$row_hp_forms["cust_firstname"]." ".$row_hp_forms["cust_lastname"]."</td>
                                  <td>".$row_hp_forms["form_filled_by"]."</td>
                                  <td>".$row_hp_forms["holi_partner_loc"]."</td>
                                  <td>".$row_hp_forms["holi_dest"]."</td>
                                  <td>".$row_hp_forms["date_of_travel"]."</td>
                                  <td>".$row_hp_forms["return_date_of_travel"]."</td>
                                  <td>".$row_hp_forms["duration"]."</td>
                                  <td>".$datesent."</td>
                                  </tr>";
                        }
                        echo"</table>";
                  }
              }
            }
            //getting super partner form
            $sql_hp_sup = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
            $res_hp_sup = $conn->query($sql_hp_sup);
            if($res_hp_sup->num_rows){
              if($row_hp_sup = $res_hp_sup->fetch_assoc()){
                $sup_id = $row_hp_sup["super_partner_sno"];
                $sql_sup_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sup_id."' AND formstatus = 'pending' ORDER BY ref_num DESC";
                $res_sup_forms = $conn->query($sql_sup_forms);
                if($res_sup_forms->num_rows){
                  echo "<br><h4>Super Partner Requests</h4><br>
                        <table class='table'>
                        <thead class='thead-light'>
                          <tr>
                            <th scope='col'>GHR Number</th>
                            <th scope='col'>Customer Name</th>
                            <th scope='col'>Form Raised By</th>
                            <th scope='col'>Partner's Name</th>
                            <th scope='col'>Destination</th>
                            <th scope='col'>Start Date</th>
                            <th scope='col'>End Date</th>
                            <th scope='col'>Duration</th>
                            <th scope='col'>Form Requested on</th>
                          </tr>
                        </thead>
                        ";
                  while($row_sup_forms = $res_sup_forms->fetch_assoc()){
                    $datesent =date_create($row_sup_forms["datesent"]);
                    $datesent =date_format($datesent,"d-M-Y");
                    echo "<tr>
                            <td>GHRN".(5000+(int)$row_sup_forms["ref_num"])."</td>
                            <td>".$row_sup_forms["cust_firstname"]." ".$row_sup_forms["cust_lastname"]."</td>
                            <td>".$row_sup_forms["form_filled_by"]."</td>
                            <td>".$row_sup_forms["holi_partner_loc"]."</td>
                            <td>".$row_sup_forms["holi_dest"]."</td>
                            <td>".$row_sup_forms["date_of_travel"]."</td>
                            <td>".$row_sup_forms["return_date_of_travel"]."</td>
                            <td>".$row_sup_forms["duration"]."</td>
                            <td>".$datesent."</td>
                            </tr>";
                  }
                  echo"</table>";
                }
              }
            }
            break;
            case "regionalmanager":
            //all data will be displayed for regional manager
            $sql_rm = "SELECT * FROM agent_form_data WHERE formstatus = 'pending' ORDER BY ref_num DESC";
            $res_rm = $conn->query($sql_rm);
            if($res_rm->num_rows){
              echo "<br><h4>Partner Requests</h4><br>
                    <table class='table'>
                    <thead class='thead-light'>
                      <tr>
                        <th scope='col'>GHR Number</th>
                        <th scope='col'>Customer Name</th>
                        <th scope='col'>Form Raised By</th>
                        <th scope='col'>Partner's Name</th>
                        <th scope='col'>Destination</th>
                        <th scope='col'>Start Date</th>
                        <th scope='col'>End Date</th>
                        <th scope='col'>Duration</th>
                        <th scope='col'>Form Requested on</th>
                      </tr>
                    </thead>
                    ";
              while($row_rm = $res_rm->fetch_assoc()){
                $datesent =date_create($row_rm["datesent"]);
                $datesent =date_format($datesent,"d-M-Y");
                echo "<tr>
                        <td>GHRN".(5000+(int)$row_rm["ref_num"])."</td>
                        <td>".$row_rm["cust_firstname"]." ".$row_rm["cust_lastname"]."</td>
                        <td>".$row_rm["form_filled_by"]."</td>
                        <td>".$row_rm["holi_partner_loc"]."</td>
                        <td>".$row_rm["holi_dest"]."</td>
                        <td>".$row_rm["date_of_travel"]."</td>
                        <td>".$row_rm["return_date_of_travel"]."</td>
                        <td>".$row_rm["duration"]."</td>
                        <td>".$datesent."</td>
                        </tr>";
              }
              echo"</table>";

            }
            break;
          }
        ?>
      </div>
    </div>
  </body>
</html>
