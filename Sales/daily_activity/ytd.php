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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>YTD Report Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <script  src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <script type="text/javascript">
    var id  = '<?php echo $sno?>';
    var m_type = '<?php echo $m_type?>';
    if(m_type == 'salesmanager'){
      $(document).ready(function(){
        $("#ytd_vis").addClass("hidden");
        $("#ytd_invis").removeClass("hidden");
      });
    }
    else if(m_type == 'areamanager'){
      $.ajax({
        type:"POST",
        url:"get_sm_ytd.php",
        data:'am_id='+id,
        success: function(data){
          $("#m_sel").html(data);
        }
      });
    }
    else if(m_type == 'regionalmanager'){
      $.ajax({
        type:"POST",
        url:"get_m_ytd.php",
        data:"m_id="+id,
        success: function(data){
          $("#m_sel").html(data);
        }
      });
    }
    </script>
  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href='https://www.gogagaholidays.com'><img src='logonew.png' alt='Company Logo' id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>YTD Report</strong></p>
    </div>
    <br>
    <div class="container">
      <h3>YTD Request</h3>
      <small>Fill in this form and we'll tell you who did what!</small>
      <div class="section" id = 'ytd_vis'>
        <form class="" action="ytd_report.php" method="post">
          <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">From Date:</label>
            <div class="col-md-3">
              <select class="custom-select" name="fr_day" id = 'fr_day'>
                <option value="">Day</option>
                <?php
                  $x=1;
                  while($x <= 31)
                    {
                      echo "<option>".$x."</option>";
                      $x++;
                    }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <select class="custom-select" name="fr_month" id = 'fr_month'>
                <option value="">Month</option>
                <?php
                  $y=array("Jan", "Feb", "Mar", "Apr",
                            "May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
                  foreach ($y as $x) {
                    echo "<option>$x</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <select class="custom-select" name="fr_yr" id = 'fr_yr'>
                <option value="">Year</option>
                <?php
                  $x=date("Y");
                  $y=$x-10;
                  while($x >= $y)
                      {
                        echo "<option>".$x."</option>";
                        $x--;
                      }
                  ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">To Date:</label>
            <div class="col-md-3">
              <select class="custom-select" name="to_day" id = 'to_day'>
                <option value="">Day</option>
                <?php
                  $x=1;
                  while($x <= 31)
                    {
                      echo "<option>".$x."</option>";
                      $x++;
                    }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <select class="custom-select" name="to_month" id = 'to_month'>
                <option value="">Month</option>
                <?php
                  $y=array("Jan", "Feb", "Mar", "Apr",
                            "May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
                  foreach ($y as $x) {
                    echo "<option>$x</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <select class="custom-select" name="to_yr" id = 'to_yr'>
                <option value="">Year</option>
                <?php
                  $x=date("Y");
                  $y=$x-10;
                  while($x >= $y)
                      {
                        echo "<option>".$x."</option>";
                        $x--;
                      }
                  ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="m_sel" class="col-sm-2 col-form-label">Select Manager:</label>
            <div class="col-md-10">
              <select class="custom-select custom-select-sm" id = 'm_sel' name = 'm_sel'>
                <option selected>Select Manager</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="iti_sel" class="col-sm-2 col-form-label">Itinerary Type:</label>
            <div class="col-md-10">
              <select class="custom-select custom-select-sm" id = 'iti_sel' name = 'iti_sel'>
                <option selected>Select Itinerary Type</option>
                <option value="pending">Requested</option>
                <option value="submitted">Recieved</option>
                <option value="confirmed">Confirmed</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-4">
            </div>
            <div class="col-4">
              <button type="submit" class = 'form-control btn btn-lg btn-primary' name="ytd_sub">Go!</button>

            </div>
            <div class="col-4">

            </div>
          </div>
      </div>
      <div class="section hidden" id = 'ytd_invis'>
        <p>We're Sorry, but it looks like you're not authorised to see this data!</p>
      </div>
    </div>
  </body>
  <script  src='https://code.jquery.com/jquery-3.4.1.js'  integrity='sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU='  crossorigin='anonymous'></script>
</html>
