<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
$name = $_SESSION['name'];
$userid = $_SESSION['userid'];
$sno = $_SESSION['sno'];
$d_name = $_SESSION['d_name'];
$sql_m_type = "SELECT * FROM managers_data WHERE sno = '".$sno."'";
$res_m_type = $conn->query($sql_m_type);
if($res_m_type->num_rows){
  if($row_m_type = $res_m_type->fetch_assoc()){
    $m_type = $row_m_type["type"];
  }
}
$sn = $_GET["sn"];
$type = $_GET["typ"];
if($type == "Recruitment"){
  $sql_act = "SELECT * FROM rec_activity_track WHERE sno = '".$sn."'";
  $res_act = $conn->query($sql_act);
  if($res_act->num_rows){
    if($row_act = $res_act->fetch_assoc()){
      $m_id = $row_act["man_id"];
      $m_name = $row_act["man_name"];
      $man_type = $row_act["man_type"];
      if($man_type == "areamanager"){
        $desg = "Area Manager";
      }
      elseif($man_type == "salesmanager"){
        $desg = "Sales Manager";
      }
      $man_uid = $row_act["man_uid"];
      //prospect Details
      $pr_type = $row_act["pr_type"];
      $pr_source = $row_act["pr_source"];
      $pr_name = $row_act["pr_name"];
      $pr_phone = $row_act["pr_phone"];
      $pr_loc = $row_act["pr_loc"];
      $pr_profile = $row_act["pr_profile"];
      $act_date = date("d-M-Y", strtotime($row_act["activity_date"]));
      $meet_date = date("d-M-Y", strtotime($row_act["meet_date"]));
      $pres_done = $row_act["presentation"];
      $pr_status = $row_act["pr_status"];
      $fee_paid = $row_act["fee_paid"];
      $remarks = $row_act["remarks"];

    }
  }
  $a_type = "Recruitment";
  $data = "<div class='section'>
    <h4>Manager Details</h4>
    <div class='form-group row'>
      <label for='m_id' class='col-sm-2 col-form-label'>Manager ID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_id' id='m_id' value = '".$m_id."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_name' class='col-sm-2 col-form-label'>Manager Name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_name' id='m_name' value='".$m_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_uid' class='col-sm-2 col-form-label'>Manager UserID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_uid' id='m_uid' value='".$man_uid."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='desg' class='col-sm-2 col-form-label'>Designation:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'desg' id='desg' value = '".$desg."' readonly>
      </div>
    </div>
  </div>
  <div class='section'>
    <h4>Prospect Details</h4>
    <div class='form-group row'>
      <label for='par_type' class='col-sm-2 col-form-label'>Prospect Type:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_type' id='par_type' value = '".$pr_type."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='pr_source' class='col-sm-2 col-form-label'>Prospect Source:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'pr_source' id='pr_source' value = '".$pr_source."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_name' class='col-sm-2 col-form-label'>Prospect Name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_name' id='par_name' value = '".$pr_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_phone' class='col-sm-2 col-form-label'>Prospect Phone:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_phone' id='par_phone' value = '".$pr_phone."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='pr_loc' class='col-sm-2 col-form-label'>Prospect Location:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'pr_loc' id='pr_loc' value = '".$pr_loc."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='pr_profile' class='col-sm-2 col-form-label'>Prospect Profile:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'pr_profile' id='pr_profile' value = '".$pr_profile."' readonly>
      </div>
    </div>
  </div>
    <div class='section'>
      <h4>Activity Details</h4>
      <div class='form-group row'>
        <label for='date_act' class='col-sm-2 col-form-label'>Date Of Activity:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'date_act' id='date_act' value = '".$act_date."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='date_meet' class='col-sm-2 col-form-label'>Date Of Meeting:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'date_meet' id='date_meet' value = '".$meet_date."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='pres' class='col-sm-2 col-form-label'>Product Explained?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'pres' id='pres' value = '".$pres_done."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='pr_status' class='col-sm-2 col-form-label'>Prospect Onboard?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'pr_status' id='pr_status' value = '".$pr_status."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='f_p' class='col-sm-2 col-form-label'>Fee Paid:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'f_p' id='f_p' value = '".$fee_paid."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='rem' class='col-sm-2 col-form-label'>Remarks:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'rem' id='rem' value = '".$remarks."' readonly>
        </div>
      </div>
          ";
}
elseif($type == "Sales"){
  $sql_act = "SELECT * FROM sales_activity_track WHERE sno ='".$sn."'";
  $res_act = $conn->query($sql_act);
  if($res_act->num_rows){
    if($row_act = $res_act->fetch_assoc()){
      $m_id = $row_act["man_id"];
      $m_name = $row_act["man_name"];
      $man_type = $row_act["man_type"];
      if($man_type == "areamanager"){
        $desg = "Area Manager";
      }
      elseif($man_type == "salesmanager"){
        $desg = "Sales Manager";
      }
      $man_uid = $row_act["man_uid"];
      //partner details
      $par_type = $row_act["par_type"];
      $par_sno = $row_act["par_sno"];
      if($par_type == "superpartner"){
        $p_type = "Super Partner";
      }
      elseif($par_type == "holidaypartner"){
        $p_type = "Holiday Partner";
      }
      elseif($par_type == "salespartner"){
        $p_type = "Sales Partner";
      }
      $tab_name = $par_type."s";
      $sql_par = "SELECT * FROM ".$tab_name." WHERE sno = '".$par_sno."'";
      $res_par = $conn->query($sql_par);
      if($res_par->num_rows){
        if($row_par = $res_par->fetch_assoc()){
          $par_name = $row_par["name"];
          $par_phone = $row_par["phone"];
        }
      }
      $cu_name = $row_act["pros_name"];
      $cu_phone = $row_act["pros_phone"];
      $dest = $row_act["des_dest"];
      $holi_st = date("d-M-Y", strtotime($row_act["hol_start_date"]));
      $holi_end = date("d-M-Y", strtotime($row_act["hol_end_date"]));
      $act_date = date("d-M-Y", strtotime($row_act["activity_date"]));
      $comp_exp = $row_act["exp_com"];
      $pr_exp = $row_act["exp_pr"];
      $iti_sh = $row_act["iti_sh"];
      $o_call = $row_act["o_call"];
      $tot_amt = $row_act["t_amt"];
      $amt_c = $row_act["amt_c"];
    }
  }

  $a_type = "Sales";
  $data = "<div class='section'>
    <h4>Manager Details</h4>
    <div class='form-group row'>
      <label for='m_id' class='col-sm-2 col-form-label'>Manager ID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_id' id='m_id' value = '".$m_id."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_name' class='col-sm-2 col-form-label'>Manager Name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_name' id='m_name' value='".$m_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_uid' class='col-sm-2 col-form-label'>Manager UserID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_uid' id='m_uid' value='".$man_uid."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='desg' class='col-sm-2 col-form-label'>Designation:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'desg' id='desg' value = '".$desg."' readonly>
      </div>
    </div>
  </div>
  <div class='section'>
    <h4>Partner Details</h4>
    <div class='form-group row'>
      <label for='par_type' class='col-sm-2 col-form-label'>Partner Type:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_type' id='par_type' value = '".$p_type."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_id' class='col-sm-2 col-form-label'>Partner ID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_id' id='par_id' value = '".$par_sno."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_name' class='col-sm-2 col-form-label'>Partner name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_name' id='par_name' value = '".$par_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_phone' class='col-sm-2 col-form-label'>Partner Phone:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_phone' id='par_phone' value = '".$par_phone."' readonly>
      </div>
    </div>
  </div>
    <div class='section'>
      <h4>Potential Sale Details</h4>
      <div class='form-group row'>
        <label for='pr_name' class='col-sm-2 col-form-label'>Prospect Name:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'pr_name' id='pr_name' value = '".$cu_name."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='pr_phone' class='col-sm-2 col-form-label'>Prospect Name:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'pr_phone' id='pr_phone' value = '".$cu_phone."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='h_dest' class='col-sm-2 col-form-label'>Destination Desired:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'h_dest' id='h_dest' value = '".$dest."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='h_st' class='col-sm-2 col-form-label'>Holiday Start Date:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'h_st' id='h_st' value = '".$holi_st."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='h_en' class='col-sm-2 col-form-label'>Holiday End Date:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'h_en' id='h_en' value = '".$holi_end."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='date_act' class='col-sm-2 col-form-label'>Date Of Activity:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'date_act' id='date_act' value = '".$act_date."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='exp_cm' class='col-sm-2 col-form-label'>Company Explained?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'exp_cm' id='exp_cm' value = '".$comp_exp."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='exp_pr' class='col-sm-2 col-form-label'>Product Explained?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'exp_pr' id='exp_pr' value = '".$pr_exp."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='iti_sh' class='col-sm-2 col-form-label'>itinerary Shared?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'iti_sh' id='iti_sh' value = '".$iti_sh."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='o_call' class='col-sm-2 col-form-label'>Outcome Call:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'o_call' id='o_call' value = '".$o_call."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='tot_amt' class='col-sm-2 col-form-label'>Total Amount:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'tot_amt' id='tot_amt' value = '".$tot_amt."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='amt_c' class='col-sm-2 col-form-label'>Amount Collected:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'amt_c' id='amt_c' value = '".$amt_c."' readonly>
        </div>
      </div>
    </div>
          ";
}
elseif($type == 'Other'){
  $sql_act = "SELECT * FROM other_activity_track WHERE sno = '".$sn."'";
  $res_act = $conn->query($sql_act);
  if($res_act->num_rows){

    if($row_act = $res_act->fetch_assoc()){
      $m_id = $row_act["man_id"];
      $m_name = $row_act["man_name"];
      $man_type = $row_act["man_type"];
      if($man_type == "areamanager"){
        $desg = "Area Manager";
      }
      elseif($man_type == "salesmanager"){
        $desg = "Sales Manager";
      }
      $man_uid = $row_act["man_uid"];
      //partner details
      $par_type = $row_act["par_type"];
      $par_sno = $row_act["par_sno"];
      if($par_type == "superpartner"){
        $p_type = "Super Partner";
      }
      elseif($par_type == "holidaypartner"){
        $p_type = "Holiday Partner";
      }
      elseif($par_type == "salespartner"){
        $p_type = "Sales Partner";
      }
      $tab_name = $par_type."s";
      $sql_par = "SELECT * FROM ".$tab_name." WHERE sno = '".$par_sno."'";
      $res_par = $conn->query($sql_par);
      if($res_par->num_rows){
        if($row_par = $res_par->fetch_assoc()){
          $par_name = $row_par["name"];
          $par_phone = $row_par["phone"];
        }
      }
      $place = $row_act["place"];
      $area = $row_act["area"];
      $act_date = $row_act["activity_date"];
      //formatting date
      $act_date = date("d-M-Y", strtotime($act_date));

      $src = $row_act["source"];
      $act_type = $row_act["act_type"];
      $dec_maker = $row_act["decision_maker"];
      $dec_contact = $row_act["d_contact"];
      $dec_pr = $row_act["d_profile"];
      $comp_exp = $row_act["company_explained"];
      $pr_exp = $row_act["product_explained"];
      $iti_sh = $row_act["iti_shared"];
      $n_lead = $row_act["num_leads"];
      $remarks = $row_act["remarks"];
    }
  }
  $data = "<div class='section'>
    <h4>Manager Details</h4>
    <div class='form-group row'>
      <label for='m_id' class='col-sm-2 col-form-label'>Manager ID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_id' id='m_id' value = '".$m_id."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_name' class='col-sm-2 col-form-label'>Manager Name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_name' id='m_name' value='".$m_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='m_uid' class='col-sm-2 col-form-label'>Manager UserID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'm_uid' id='m_uid' value='".$man_uid."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='desg' class='col-sm-2 col-form-label'>Designation:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'desg' id='desg' value = '".$desg."' readonly>
      </div>
    </div>
  </div>
  <div class='section'>
    <h4>Partner Details</h4>
    <div class='form-group row'>
      <label for='par_type' class='col-sm-2 col-form-label'>Partner Type:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_type' id='par_type' value = '".$p_type."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_id' class='col-sm-2 col-form-label'>Partner ID:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_id' id='par_id' value = '".$par_sno."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_name' class='col-sm-2 col-form-label'>Partner Name:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_name' id='par_name' value = '".$par_name."' readonly>
      </div>
    </div>
    <div class='form-group row'>
      <label for='par_phone' class='col-sm-2 col-form-label'>Partner Phone:</label>
      <div class='col-sm-10'>
        <input type='text' class='form-control-plaintext' name = 'par_phone' id='par_phone' value = '".$par_phone."' readonly>
      </div>
    </div>
  </div>
    <div class='section'>
      <h4>Activity Details</h4>
      <div class='form-group row'>
        <label for='place' class='col-sm-2 col-form-label'>Place:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'place' id='place' value = '".$place."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='area' class='col-sm-2 col-form-label'>Area:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'area' id='area' value = '".$area."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='date_act' class='col-sm-2 col-form-label'>Date Of Activity:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'date_act' id='date_act' value = '".$act_date."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='src' class='col-sm-2 col-form-label'>Source:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'src' id='src' value = '".$src."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='d_maker' class='col-sm-2 col-form-label'>Decision Maker:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'd_maker' id='d_maker' value = '".$dec_maker."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='d_phone' class='col-sm-2 col-form-label'>Decision Maker's Contact:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'd_phone' id='d_phone' value = '".$dec_contact."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='d_pro' class='col-sm-2 col-form-label'>Decision Maker's Profile:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'd_pro' id='d_pro' value = '".$dec_pr."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='exp_cm' class='col-sm-2 col-form-label'>Company Explained?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'exp_cm' id='exp_cm' value = '".$comp_exp."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='exp_pr' class='col-sm-2 col-form-label'>Product Explained?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'exp_pr' id='exp_pr' value = '".$pr_exp."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='iti_sh' class='col-sm-2 col-form-label'>itinerary Shared?</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'iti_sh' id='iti_sh' value = '".$iti_sh."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='n_lead' class='col-sm-2 col-form-label'>Number of Leads:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'n_lead' id='n_lead' value = '".$n_lead."' readonly>
        </div>
      </div>
      <div class='form-group row'>
        <label for='rem' class='col-sm-2 col-form-label'>Remarks:</label>
        <div class='col-sm-10'>
          <input type='text' class='form-control-plaintext' name = 'rem' id='rem' value = '".$remarks."' readonly>
        </div>
      </div>
    </div>
          ";
}

?>
<!DOCTYPE html>
<html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>Activity Review</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
      <link rel='stylesheet' href='st_common.css'>
      <link href='https://fonts.googleapis.com/css?family=Raleway&display=swap' rel='stylesheet'>
      <script  src='https://code.jquery.com/jquery-3.4.1.js'  integrity='sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU='  crossorigin='anonymous'></script>

  </head>
  <body>
    <div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
        <a href='https://www.gogagaholidays.com'><img src='logonew.png' alt='Company Logo' id = 'logo'></a>
        <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Activity Review</strong></p>
    </div>
    <br>
    <div class='container'>
      <h3>Detailed Review</h3>
    	<small>Digging deeper, are we?</small>
        <?php echo $data; ?>
        <br><br>
      </div>
  </body>
</html>
