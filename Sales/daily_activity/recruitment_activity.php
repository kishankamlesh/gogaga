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
  <title>Recuritment Activity Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <script type="text/javascript" src = 's_activity_report.js'></script>
</head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Activity Report</strong></p>
    </div>
    <br>
    <div class="container">
      <h3>Recuitment Activity</h3>
      <small>Someone got added to the family?</small>
      <form class="" action="recruitment_act_ins.php" method="post">
        <div class="section">
          <h2>Manager Details</h2>
          <div class="form-group row">
            <label for="m_id" class="col-sm-2 col-form-label">Manager ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" name = "m_id" id="m_id" value = '<?php echo $sno;?>' readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="m_name" class="col-sm-2 col-form-label">Manager Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" name = "m_name" id="m_name" value='<?php echo $name;?>' readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="m_uid" class="col-sm-2 col-form-label">Manager UserID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext" name = "m_uid" id="m_uid" value='<?php echo $userid;?>' readonly>
            </div>
          </div>
        </div>
        <div class="section">
          <h2>Prospect Details</h2>
          <div class="form-group row">
            <label for="p_type" class="col-sm-2 col-form-label">Prospect Type:</label>
            <div class="col-sm-10">
              <select class="custom-select" name="p_type" id = 'p_type'>
                <option>Choose Partner Type</option>
                <option value="Sales Partner">Sales Partner</option>
                <option value="Holiday Partner">Holiday Partner</option>
                <option value="Super Partner">Super Partner</option>
              </select>
              <small>The kind of partnership the prospect is interested in.</small>

            </div>
          </div>
          <div class="form-group row">
            <label for="pr_source" class="col-sm-2 col-form-label">Prospect Source:</label>
            <div class="col-sm-10">
              <select class="custom-select" name="pr_source" id = 'pr_source'>
                <option>Choose Prospect Source</option>
                <option value="Self Outsourced">Self Sourced</option>
                <option value="Recommendation">Recommendation</option>
                <option value="HP Reference">Holiday Partner Reference</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="pr_name" class="col-sm-2 col-form-label">Prospect name:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "pr_name" id="pr_name" placeholder="Prospect Name">
            </div>
          </div>
          <div class="form-group row">
            <label for="pr_phone" class="col-sm-2 col-form-label">Prospect Contact Number:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "pr_phone" id="pr_phone" placeholder="Prospect Contact Number" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="pr_loc" class="col-sm-2 col-form-label">Prospect's Location:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "pr_loc" id="pr_loc" placeholder="Prospect's Location">
            </div>
          </div>
          <div class="form-group row">
            <label for="date_meet" class="col-sm-2 col-form-label">Date of Meeting:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "date_meet" id="date_meet" value = '<?php $date = date("d-M-Y"); echo $date;?>'>
            </div>
          </div>
          <div class="form-group row">
            <label for="pr_profile" class="col-sm-2 col-form-label">Prospect's Profile:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "pr_profile" id="pr_profile" placeholder="Prospect's current line of work">
            </div>
          </div>
        </div>
        <div class="section">
          <h2>Activity Details</h2>
          <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Activity Date:</label>
            <div class="col-md-3">
              <select class="custom-select" name="activity_day" id = 'activity_day'>
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
              <select class="custom-select" name="activity_month" id = 'activity_month'>
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
              <select class="custom-select" name="activity_year" id = 'activity_year'>
                <option value="">Year</option>
                <?php
                  $x=date("Y");
                  $y=$x+10;
                  while($x <= $y)
                      {
                        echo "<option>".$x."</option>";
                        $x++;
                      }
                  ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="pres" class="col-sm-2 col-form-label">Presentation done?</label>
            <div class="col-sm-10">
              <select class="custom-select" name="pres" id = 'pres'>
                <option>Choose a Response</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="part_st" class="col-sm-2 col-form-label">Partner Onboard?</label>
            <div class="col-sm-10">
              <select class="custom-select" name="part_st" id = 'part_st'>
                <option>Choose a Response</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="amt_p" class="col-sm-2 col-form-label">Amount Paid:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "amt_p" id="amt_p" placeholder="Amount Paid">
            </div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Final Status/Remarks:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "status" id="status" placeholder="Final Status/Remarks like location of interest of prospect">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group col-4">
          </div>
          <div class="form-group col-4">
            <button type="submit" name="submit" id='sub_but' class = 'form-control btn  btn-primary' data-toggle="tooltip" data-placement="top" title="One Click away!">Submit</button>
          </div>
          <div class="form-group col-4">
          </div>
        </div>
      </div>
      <br>
      </form>
  </body>
  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
  <script type="text/javascript" src = 's_activity_report.js'></script>
</html>
