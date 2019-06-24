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
$p_id = $_GET["id"];
$type = $_GET["type"];
$ghrn = $_GET["ghr"];
$table = $type."s";
$sql_name = "SELECT * FROM ".$table." WHERE sno = '".$p_id."'";
$res_name = $conn->query($sql_name);
if($res_name->num_rows){
  if($row_name = $res_name->fetch_assoc()){
    $p_name = $row_name["name"];
    $dist = $row_name["district"];
    $state = $row_name["state"];

  }
}
$sql_comm = "SELECT * FROM commissions WHERE ghrno = '".$ghrn."'";
$res_comm = $conn->query($sql_comm);
if($res_comm->num_rows){
  $data =  "<table class='table'>
            <thead class='thead-light'>
              <tr>
                <th scope='col'>GHR Number</th>
                <th scope='col'>Customer Name</th>
                <th scope='col'>Holiday Type</th>
                <th scope='col'>Destination</th>
                <th scope='col'>Partner Type</th>
                <th scope='col'>Partner Commision</th>
                <th scope='col'>Status</th>
              </tr>
            </thead>";
  if($row_comm=$res_comm->fetch_assoc()){
    $c_name = $row_comm["clientname"];
    $h_type = $row_comm["holitype"];
    $dest = $row_comm["holidest"];
    $amt = $row_comm["commamt"];
    if($type == 'salespartner'){
      $p_amt = $row_comm["sal"];
    }
    elseif($type == 'holidaypartner'){
      $p_amt = $row_comm["hol"];

    }
    elseif($type == 'superpartner'){
      $p_amt = $row_comm["sup"];
    }
    $status = $row_comm["status"];
    $data .= "<tr>
            <td>GHRN".(5000+(int)$ghrn)."</td>
            <td>".$c_name."</td>
            <td>".$h_type."</td>
            <td>".$dest."</td>
            <td>".ucfirst($type)."</td>
            <td>".$p_amt."</td>
            <td>".$status."</td>
            </tr>";
  }
  $data .= "</table>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Statement</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <style media="screen">
    body{
      font-family: 'Lato', sans-serif;
      font-size: 15px;
      margin:5px;
      background-color:#faf7f6;
    }
    #net_pay{
      font-weight: bolder;
    }
    #logo{
      float:right;
      height:60px;
      width:170px;
    }
    #add{
      float:right;
      background-color:#FF8C00;
    }
    #partner_name{
      width:300px;

    }
    #ghr_no{
      width:200px;
      height:40px;
    }
    #comm{
      width:100px;
    }
    .fl{
      float: right;
    }
    .rd_inp{
      background-color: transparent;
      border:0;
    }
    .hidden{
      display:none;
    }
    .show{
      display: block;
    }
    </style>
    <script>
    $(document).ready(function(){
      $("#print").click(function(){
    window.print();
      });
    });
    </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <h2>Commision statement</h2>
      </div>
      <div class="row">
        <div class="container-fluid">
          <div class = "row">
            <div class="col">
              Date : <?php $curr_date = date('d-m-Y'); echo "$curr_date"?> <br>
              <p>Hyderbad</p>
              <h4 style = "color:#FF8C00;">Commision Invoice</h4>
              <hr>
              <br>
            </div>
            <div class="col">
              <img id = "logo" src="logo_fin.jpg" alt="company logo">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col">
        <?php

        echo
        "<div class='row'>
          <div class='col'>
            <label >Partner Name:</label>
            <br>
          </div>
          <div class='col'>
            <span id = 'ac_no'>" .$p_name. "</span>
            <br>
          </div>
          <div class='col-md-auto'>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <label >Distict:</label>
            <br>
          </div>
          <div class='col'>
            <span id = 'ac_no'>" .$dist. "</span>
            <br>
          </div>
          <div class='col-md-auto'>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <label >State:</label>
          </div>
          <div class='col'>
            <span id = 'desg' >" .$state. "</span>
          </div>
          <div class='col-md-auto'>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <label >Invoice Date:</label>
          </div>
          <div class='col'>
            <span id = 'bmon'>".$curr_date."</span>
          </div>
          <div class='col-md-auto'>
          </div>
        </div>";

        ?>
      </div>
      <div id = "add" class="col">
        <p align = "right">GoGaga Holidays Private Limited,<br>Modern Profound Tech Park,Ground Floor,<br>White Field Road, Kondapur, Hyderabad, Telangana,</p><hr><p align = "right">Land Line: 040 48591205,<br>Mail: support@gogagaholidays.in,<br>Web: www.gogagaholidays.com<p>
      </div>
    </div>
    <br>
    </div>
    <br>
    <div class="container-fluid">
      <?php if(isset($data)){echo $data;} else{echo "No comissions to display";} ?>
    </div>
    <div class="container-fluid">
    <br>
    <div class="container-fluid">
      <div class="row">
        <p> <strong>Payment Method:</strong> Bank Transfer</p>
      </div>
      <br><br>
      <div class="row">
        <div class="col-12">
          <p> <strong> Notes: </strong><br> <ul> <li>The above commisions are processed for business done before the 30th of previous month</li> <li>Any business falling in the current month is not considered for payout</li> <li>For any further issues regarding partner commisions please write to us at support@gogagaholidays.in</li> <ul></p>
        </div>
      </div>
      <div class="row">
        <div class="col-4">

        </div>
        <div class="col-4">

        </div>
        <div class="col-4">
          <button type="button" id = "print" class = "btn btn-info" name="button" style = "float:right;">Save as PDF</button>
        </div>
      </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  </body>
</html>
