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
  <title>Other Activity Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <script type="text/javascript" src = 's_activity_report.js'></script>
    <script type="text/javascript">
      var id  = '<?php echo $sno?>';
      var m_type = '<?php echo $m_type?>';
      console.log(id);
      console.log(m_type);
      $(document).ready(function(){
        $("#p_type").change(function(){
          var par_type = $("#p_type").val()
          console.log(par_type);
          get_part(par_type);
          $("#p_sel").change(function(){
            var part = $("#p_sel").val();
            $("#p_name").val(part);
          });
        });
      });
      function get_part(par_type){
        if((m_type == 'salesmanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "sp_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'salesmanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "hp_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'salesmanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "sup_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "get_sp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "get_hp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "get_sup.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "r_get_sp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "r_get_hp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "r_get_sup.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_sel").html(data);
            }
          });
        }
      }
    </script>
</head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Activity Report</strong></p>
    </div>
    <br>
    <div class="container">
      <h3>Other Activity</h3>
      <small>Go ahead, tell us what happened!</small>
      <form class="" action="other_act_ins.php" method="post">
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
          <h2>Partner Details</h2>
          <div class="form-group row">
            <label for="p_type" class="col-sm-2 col-form-label">Select Partner Type:</label>
            <div class="col-sm-10">
              <select class="custom-select" name="p_type" id = 'p_type'>
                <option>Choose Partner Type</option>
                <option value="salespartner">Sales Partner</option>
                <option value="holidaypartner">Holiday Partner</option>
                <option value="superpartner">Super Partner</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="p_sel" class="col-sm-2 col-form-label">Select Partner:</label>
            <div class="col-sm-10">
              <select class="custom-select" name="p_sel" id = 'p_sel'>
                <option>Choose Partner</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="p_name" class="col-sm-2 col-form-label">Partner Name:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "p_name" id="p_name" placeholder="Partner Name" readonly>
            </div>
          </div>
        </div>
        <div class="section">
          <h2>Location Details</h2>
          <div class="form-group row">
            <label for="place" class="col-sm-2 col-form-label">Place:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "place" id="place" placeholder="Name of the buiilding/location the activity took place">
            </div>
          </div>
          <div class="form-group row">
            <label for="a_area" class="col-sm-2 col-form-label">Area:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "a_area" id="a_area" placeholder="Acivity Area">
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
            <label for="a_source" class="col-sm-2 col-form-label">Source:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "a_source" id="a_source" placeholder="Source of activity, was it referred/created etc.">
            </div>
          </div>
          <div class="form-group row">
            <label for="a_type" class="col-sm-2 col-form-label">Type of Activity:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "a_type" id="a_type" placeholder="Type of the activity">
            </div>
          </div>
          <div class="form-group row">
            <label for="d_maker" class="col-sm-2 col-form-label">Decision Maker's Name:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "d_maker" id="d_maker" placeholder="Name of the person who authorised the activity">
            </div>
          </div>
          <div class="form-group row">
            <label for="d_maker_num" class="col-sm-2 col-form-label">Decision Maker's Contact:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "d_maker_num" id="d_maker_num" placeholder="Contact Number of the person who authorised the activity">
            </div>
          </div>
          <div class="form-group row">
            <label for="d_maker_pro" class="col-sm-2 col-form-label">Decision Maker's Profile:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "d_maker_pro" id="d_maker_pro" placeholder="Profile of the person who authorised the activity (e.g. MD of Infosys!)">
            </div>
          </div>
          <div class="form-group row">
            <label for="exp_c" class="col-sm-2 col-form-label">Explained About Company?</label>
            <div class="col-sm-10">
              <select class="custom-select" name="exp_c" id = 'exp_c'>
                <option>Choose a Response</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="exp_p" class="col-sm-2 col-form-label">Product Explained?</label>
            <div class="col-sm-10">
              <select class="custom-select" name="exp_p" id = 'exp_p'>
                <option>Choose a Response</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="iti_s" class="col-sm-2 col-form-label">Sample Itinerary Shared?</label>
            <div class="col-sm-10">
              <select class="custom-select" name="iti_s" id = 'iti_s'>
                <option>Choose a Response</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="num_lead" class="col-sm-2 col-form-label">Number of leads Collected:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "num_lead" id="num_lead" placeholder="Number of leads collected by this activity">
            </div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Status/Remarks:</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name = "status" id="status" placeholder="Final Status/Remarks">
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
