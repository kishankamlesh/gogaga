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
if(($m_type == 'areamanager')||($m_type == 'regionalmanager')){
  $review_act = "";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Daily Activity Report</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <script type="text/javascript" src = 's_activity_report.js'></script>
    <script type="text/javascript">
      var m_type = '<?php echo $m_type?>';
      console.log(m_type);
      $(document).ready(function(){
        if(m_type == 'salesmanager'){
          $("#review_sec").addClass("hidden");
          $("#own_act").removeClass("hidden");
        }
      });
    </script>
</head>
<body>
	<div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Daily Activity Report</strong></p>
    </div>
    <br>
    <div class = 'container'>
    	<h3>Daily Activity</h3>
    	<small>Let's Catch up! What have you been upto lately?</small>
    	<form action="redirect.php" method="POST" accept-charset="utf-8">
    		<div class  = 'section'>
	    		<h4>Report Activity</h4>
	            <div class="form-group row">
                <label for="a_type" class="col-sm-2 col-form-label">Activity Type:</label>
                <div class="col-md-10">
                  <select class="custom-select custom-select-sm" id = 'a_type' name = 'a_type'>
                    <option selected>Select Type of activity</option>
                    <option value="Recruitment">Recruitment</option>
                    <option value="Sales">Sales</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
	            </div>
	            <div class="form-group row">
                <div class="col-4">
                </div>
                <div class="col-4">
                  <button type="submit" class = 'form-control btn btn-lg btn-primary' name="sub">Go!</button>

                </div>
                <div class="col-4">

                </div>
	            </div>
              <div class="form-group row hidden" id = 'own_act'>
                <div class="col-4">

                </div>
                <div class="col-4">

                </div>
                <div class="col-4">
                  <a href="own_act.php" style = 'float:right;'>Review Your Own Activities</a>
                </div>
              </div>
    		</div>
    	</form>
      <div class="section" id = 'review_sec'>
        <h4>Review Activity</h4>
      	<small>Just enter a From and To date and hit Go! to get all the activity of managers!</small>
        <br> <br>
        <form class="" action="rev_activity.php" method="post">
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
            <label for="a_type" class="col-sm-2 col-form-label">Activity Type:</label>
            <div class="col-md-10">
              <select class="custom-select custom-select-sm" id = 'a_type' name = 'a_type'>
                <option selected>Select Type of activity</option>
                <option value="Recruitment">Recruitment</option>
                <option value="Sales">Sales</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-4">
            </div>
            <div class="col-4">
              <button type="submit" class = 'form-control btn btn-lg btn-primary' name="rev_sub">Go!</button>

            </div>
            <div class="col-4">

            </div>
          </div>
          <div class="form-group row">
            <div class="col-4">

            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
              <a href="own_act.php" style = 'float:right;'>Review Your Own Activities</a>
            </div>
          </div>
        </form>
      </div>
    </div>
</body>
<script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
<script type="text/javascript" src = 's_activity_report.js'></script>
</html>
