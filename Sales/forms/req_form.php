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
    <title>Request Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="st_req_form.css">
  </head>
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
        $("#p_sel").html("<option value = '0'>No Super Partners</option>");
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
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Request Form</strong></p>
    </div>
    <div class="container">
      <br>
      <h3>Itinerary Request Form</h3>
      <p><small>Please Fill in the details below for our executives to be able to get on with the process of follow-up and itinerary creation!</small></p>
      <div class="container">
        <form class="" action="" method="post">
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
            <h2>Customer Details</h2>
            <div class="form-group row">
              <label for="cu_type" class="col-sm-2 col-form-label">Customer Type:</label>
              <div class="col-sm-10">
                <select class="custom-select" name="cu_type" id = 'cu_type'>
                  <option>Select Customer Type</option>
                  <option value="New Customer">New Customer</option>
                  <option value="Subscriber">Subscriber</option>
                  <option value="Existing Customer">Existing Customer</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="cu_fname" class="col-sm-2 col-form-label">Customer Name:</label>
              <div class="col-md-5">
                <input type="text" class="form-control" name = "cu_fname" id="cu_fname" placeholder="First Name">
              </div>
              <div class="col-md-5">
                <input type="text" class="form-control" name = "cu_lname" id="cu_lname" placeholder="Last Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="cu_phone" class="col-sm-2 col-form-label">Customer Phone:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "cu_phone" id="cu_phone" placeholder="Contact Number">
              </div>
            </div>
            <div class="form-group row">
              <label for="cu_ttc" class="col-sm-2 col-form-label">Preffered Time to call:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "cu_ttc" id="cu_ttc" placeholder="Preffered Time to call">
              </div>
            </div>
            <div class="form-group row">
              <label for="cu_loc" class="col-sm-2 col-form-label">Customer Location:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "cu_loc" id="cu_loc" placeholder="Customer Location">
              </div>
            </div>
            <div class="form-group row">
              <label for="cu_em" class="col-sm-2 col-form-label">Customer Email:</label>
              <div class="col-md-10">
                <input type="email" class="form-control" name = "cu_em" id="cu_em" placeholder="Customer Email ID">
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
            <h2>Holiday Details</h2>
            <div class="form-group row">
              <label for="pack_type" class="col-sm-2 col-form-label">Package Type:</label>
              <div class="col-md-10">
                <select class="custom-select" name="pack_type" id = 'pack_type'>
                  <option>Choose Package Type</option>
                  <option value="Flight">Budget</option>
                  <option value="Bus">Standard</option>
                  <option value="Own">Premium</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="t_origin" class="col-sm-2 col-form-label">Trip Start Location:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "t_origin" id="t_origin" placeholder="Start Airport / Railway Station / Bus stop Location">
              </div>
            </div>
            <div class="form-group row">
              <label for="t_dest" class="col-sm-2 col-form-label">Trip Destination:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "t_dest" id="t_dest" placeholder="End Airport / Railway Station / Bus stop Location">
              </div>
            </div>
            <div class="form-group row">
              <label for="h_type" class="col-sm-2 col-form-label">Holiday Type:</label>
              <div class="col-sm-10">
                <select class="custom-select" name="h_type" id = 'h_type'>
                  <option>Choose Holiday Type</option>
                  <option value="p1">Domestic</option>
                  <option value="p2">International</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="h_start" class="col-sm-2 col-form-label">Trip Start Date:</label>
              <div class="col-md-3">
                <select class="custom-select" name="t_start_d" id = 'h_start_d'>
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
                <select class="custom-select" name="t_start_m" id = 'h_start_m'>
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
                <select class="custom-select" name="t_start_y" id = 'h_start_y'>
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
              <label for="h_end" class="col-sm-2 col-form-label">Trip End Date:</label>
              <div class="col-md-3">
                <select class="custom-select" name="t_end_d" id = 'h_end_d'>
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
                <select class="custom-select" name="t_end_m" id = 'h_end_m'>
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
                <select class="custom-select" name="t_end_y" id = 'h_end_y'>
                  <option value="">Year</option>
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
            </div>
            <div class="form-group row">
              <label for="n_pass_a" class="col-sm-2 col-form-label">Number Of Travellers:</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name = "n_pass_a" id="n_pass_a" placeholder="Adults">
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name = "n_pass_c" id="n_pass_c" placeholder="Children">
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control" name = "n_pass_i" id="n_pass_i" placeholder="Infants">
              </div>
            </div>
            <div class="form-group row">
              <label for="c_age" class="col-sm-2 col-form-label">Children Ages:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "c_age" id="c_age" placeholder="Ex.: 10,12,9">
              </div>
            </div>
          </div>
          <div class="section">
            <h2>Travel Details</h2>
            <div class="form-group row">
              <label for="travel_type" class="col-sm-2 col-form-label">Mode Of Travel:</label>
              <div class="col-sm-10">
                <select class="custom-select" name="travel_type" id = 'travel_type'>
                  <option>Choose Travel Type</option>
                  <option value="Flight">Flight</option>
                  <option value="Bus">Bus</option>
                  <option value="Own">Own</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="travel_from" class="col-sm-2 col-form-label">From:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "travel_from" id="travel_from" placeholder="Travel Start Place">
              </div>
            </div>
            <div class="form-group row">
              <label for="travel_to" class="col-sm-2 col-form-label">To:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "travel_to" id="travel_to" placeholder="Travel End Place">
              </div>
            </div>
          </div>
          <div class="section">
            <h2>Accomodation Details</h2>
            <div class="form-group row">
              <label for="hotel_type" class="col-sm-2 col-form-label">Hotel Type:</label>
              <div class="col-sm-10">
                <select class="custom-select" name="hotel_type" id = 'hotel_type'>
                  <option>Choose Hotel Type</option>
                  <option value="2 Star">2 Star</option>
                  <option value="3 Star">3 Star</option>
                  <option value="4 Star">4 Star</option>
                  <option value="5 Star">5 Star</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="acco_type" class="col-sm-2 col-form-label">Accomodation Type:</label>
              <div class="col-sm-10">
                <select class="custom-select" name="acco_type" id = 'acco_type'>
                  <option>Choose Accomodation Type</option>
                  <option value="Single">Single</option>
                  <option value="Double">Double</option>
                  <option value="Double + 1 Child">Double + 1 Child</option>
                  <option value="Double + 2 Child">Double + 2 Child</option>
                  <option value="Quadra">Quadra</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="n_rooms" class="col-sm-2 col-form-label">Number of Rooms:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "n_rooms" id="n_rooms" placeholder="Number of rooms required">
              </div>
            </div>
            <div class="form-group row">
              <label for="add_det" class="col-sm-2 col-form-label">Additional Detals about the accomodation (if any):</label>
              <div class="col-md-10">
                <textarea  class="form-control" rows="3" cols="40" name='add_det' id = 'add_det'></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="f_pref" class="col-sm-2 col-form-label">Food Preferences:</label>
              <div class="col-md-10">
                <select class="custom-select" name="f_pref" id = 'f_pref'>
                  <option>Choose Food Preferences</option>
                  <option value="Breakfast Only">Breakfast Only</option>
                  <option value="Breakfast, Lunch and Dinner">Breakfast, Lunch and Dinner</option>
                  <option value="Breakfast and Dinner">Breakfast and Dinner</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="s_f_pref" class="col-sm-2 col-form-label">Specific Food preferences (if any):</label>
              <div class="col-md-10">
                <textarea  class="form-control" rows="3" cols="40" name='s_f_pref' id = 's_f_pref'></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="s_s_pref" class="col-sm-2 col-form-label">Sight Seeing preferences (if any):</label>
              <div class="col-md-10">
                <textarea  class="form-control" rows="3" cols="40" name='s_s_pref' id = 's_s_pref'></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="budget" class="col-sm-2 col-form-label">Budget:</label>
              <div class="col-md-10">
                <input type="text" class="form-control" name = "budget" id="budget" placeholder="E.g: 10000">
                <input type='hidden' value='newform' name='pagecontrol'>
              </div>
            </div>
            <div class="form-group row">
              <label for="l_status" class="col-sm-2 col-form-label">Lead Status:</label>
              <div class="col-md-5">
                <input type="radio" id="l_status_h" name="l_status" class="custom-control-input" value = 'Hot'>
                <label class="custom-control-label" for="l_status_h">Hot</label>
              </div>
              <div class="col-md-5">
                <input type="radio" id="l_status_c" name="l_status" class="custom-control-input" value = "Cold">
                <label class="custom-control-label" for="l_status_c">Cold</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-4">
            </div>
            <div class="form-group col-4">
              <button type="submit" name="submit" id='sub_but' class = 'form-control btn btn-lg btn-success' data-toggle="tooltip" data-placement="top" title="One Click away!">Submit</button>
            </div>
            <div class="form-group col-4">
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
    <script type="text/javascript" src = "s_req_form.js"></script>
  </body>
</html>
