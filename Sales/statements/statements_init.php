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
    <title>Statements</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  	<script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
  	<link rel="stylesheet" href="st_common.css">
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
        });
      });
      function get_part(par_type){
        if((m_type == 'salesmanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "sp_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'salesmanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "hp_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'salesmanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "sup_id.php",
            data: 'sp_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "get_sp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "get_hp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'areamanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "get_sup.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'salespartner')){
          $.ajax({
            type: "POST",
            url: "r_get_sp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'holidaypartner')){
          $.ajax({
            type: "POST",
            url: "r_get_hp.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
        else if((m_type == 'regionalmanager') && (par_type == 'superpartner')){
          $.ajax({
            type: "POST",
            url: "r_get_sup.php",
            data: 'am_id='+id,
            success: function(data){
              $("#p_name").html(data);
            }
          });
        }
      }
    </script>
  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
  		<a href="../sales_dash.php"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
  		<p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Issued Statements</strong></p>
  	</div>
    <div class="container-fluid">
      <form class="" action="statements.php" method="post">
        <div class="section">
          <div class="form-group row">
            <label for="p_type" class="col-sm-2 col-form-label">Choose Partner Name:</label>
            <div class="col-md-3">
              <select class="custom-select" name="p_type" id = 'p_type'>
                <option>Choose Partner Type</option>
                <option value="salespartner">Sales Partner</option>
                <option value="holidaypartner">Holiday Partner</option>
                <option value="superpartner">Super Partner</option>
              </select>
            </div>
            <div class="col-md-1">
              <span style = 'padding-right:500px;'></span>
            </div>
            <label for="p_name" class="col-sm-2 col-form-label">Choose Partner Name:</label>
            <div class="col-md-3">
              <select class="custom-select" name="p_name" id = 'p_name'>
                <option>Choose Partner</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-4">
            </div>
            <div class="form-group col-4">
              <button type="submit" name="submit" id='sub_but' class = 'form-control btn btn-lg btn-primary' data-toggle="tooltip" data-placement="top" title="One Click away!">Get Statement</button>
            </div>
            <div class="form-group col-4">
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
  <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>

</html>
