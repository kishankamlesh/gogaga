<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
$name = $_SESSION["name"];
$userid = $_SESSION["userid"];
$sno = $_SESSION["sno"];

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//customer details section
$c_type = test_input($_POST["cu_type"]);
$c_fname =  test_input($_POST["cu_fname"]);
$c_lname =  test_input($_POST["cu_lname"]);
$c_phone =  test_input($_POST["cu_phone"]);
$c_ttc = test_input($_POST["cu_ttc"]);
$c_loc = test_input($_POST["cu_loc"]);
$c_em = $_POST["cu_em"];

//partners details section
$p_type = test_input($_POST["p_type"]);
$p_name = test_input($_POST["p_name"]);
//getting partner location, leaving it blank will make the column redundant
$p_table = $p_type."s";
$sql_get_p_loc = "SELECT * FROM ".$p_table." WHERE sno = '".$p_name."'";
$res_get_p_loc = $conn->query($sql_get_p_loc);
if($res_get_p_loc->num_rows){
  if($row_get_p_loc = $res_get_p_loc->fetch_assoc()){
    $dist = $row_get_p_loc["district"];
  }
}
$p_loc = $dist;
//holiday details section
$pack_type = test_input($_POST["pack_type"]);
$t_origin = test_input($_POST["t_origin"]);
$t_dest = test_input($_POST["t_dest"]);
$h_type = test_input($_POST["h_type"]);
$t_start_day = test_input($_POST["t_start_d"]);
$t_start_month = test_input($_POST["t_start_m"]);
$t_start_year = test_input($_POST["t_start_y"]);
$t_duration = test_input($_POST["t_dur"]);
$t_end_day = test_input($_POST["t_end_d"]);
$t_end_month = test_input($_POST["t_end_m"]);
$t_end_year = test_input($_POST["t_end_y"]);

$t_start_date = $t_start_day."-".$t_start_month."-".$t_start_year;
$t_end_date =  $t_end_day."-".$t_end_month."-".$t_end_year;

$n_adults = test_input($_POST["n_pass_a"]);
$n_children = test_input($_POST["n_pass_c"]);
$n_infants = test_input($_POST["n_pass_i"]);

$total_pass = (int)$n_adults + (int)$n_children + (int)$n_infants;
$c_age = test_input($_POST["c_age"]);

//travel details
$tr_mode = test_input($_POST["travel_type"]);
$t_from = test_input($_POST["travel_from"]);
$t_to = test_input($_POST["travel_to"]);

//accomodation Details
$hotel_st = test_input($_POST["hotel_type"]);
$acc_type = test_input($_POST["acco_type"]);
$num_rooms = test_input($_POST["n_rooms"]);
$additional_det  = test_input($_POST["add_det"]);
$food_pref = test_input($_POST["f_pref"]);
$sp_food_pref = test_input($_POST["s_f_pref"]);
$sight_s_pref = test_input($_POST["s_s_pref"]);
$budget = test_input($_POST["budget"]);
$l_status = test_input($_POST["l_status"]);
$datesent = date("Y-m-d");
$ghrnno =$_POST["pagecontrol"];

if($ghrno == 'newform'){
  $sql_ins = "INSERT INTO agent_form_data (c_type,p_type,form_filled_by,holi_partner_name,holi_partner_loc,sales_partner_name,
                sales_partner_loc,cust_firstname,cust_lastname,
                contact_phone,preferred_time,cust_addr,cust_email,trip_start_loc,holi_dest,
                holi_type,date_of_travel,return_date_of_travel,duration,no_of_adults,no_of_childs,
                no_of_infants,child_ages,travel_mode,travel_from,travel_to,type_hotel,acc_type,
                no_rooms,additional_details,food_pref,specific_food_pref,
                sight_pref,budget,lead_status,datesent)
                VALUES ('$c_type','$pack_type','$name','$p_type','$p_loc','$p_name','','$c_fname','$c_lname','$c_phone','$c_ttc','$c_loc',
                '$c_em','$t_origin','$t_dest','$h_type','$t_start_date','$t_end_date','$t_duration','$n_adults','$n_children','$n_infants',
                '$c_age','$tr_mode','$t_from','$t_to','$hotel_st','$acc_type','$num_rooms','$additional_det','$food_pref','$sp_food_pref',
                '$sight_s_pref','$budget','$l_status','$datesent')";
    if($conn->query($sql_ins)){
      //successful insertion
      //now insert this ghrn into other tables
      $sql_ref = "SELECT MAX(ref_num) AS max_no FROM agent_form_data WHERE contact_phone = '$c_phone'";
      $res_ref = $conn->query($sql_ref);
      if($res_ref->num_rows){
        if($row_ref=$res_ref->fetch_assoc()){
          $ref_num = $row_ref["max_no"];
        }
      }
      $sno = '1';
      if($h_type == 'Domestic'){
        $sql_dom = "INSERT INTO itinerary_domestic (ghrnno) VALUES('$ref_num')";
        if($conn->query($sql_dom)){
          $sql_hotel = "INSERT INTO hotels_domestic (ghrno,sno) VALUES ('$ref_num',$sno)";
          if($conn->query($sql_hotel)){
            //success
          }
        }
      }
      elseif($h_type == 'International'){
        $sql_int = "INSERT INTO itinerary_inter (ghrno) VALUES('$ref_num')";
        if($conn->query($sql_int)){
          $sql_hotel = "INSERT INTO hotels_inter (ghrnno,sno) VALUES ('$ref_num',$sno)";
          if($conn->query($sql_hotel)){
            //success
          }
        }
      }
      $sql_flights = "INSERT INTO flights_info (ghrno,sno,airtrav) VALUES ('$ref_num',$sno,'$total_pass')";
      if($conn->query($sql_flights)){
        //flight inserted
      }
      $sql_design = "INSERT INTO designdetails (ghrno) VALUES ('$ref_num')";
      if($conn->query($sql_design)){
        //inserted into design itineraries
      }
      $sql_notif = "UPDATE login SET notif_count = notif_count + 1 WHERE handle_type IN ('$holi_type','Both')";
      if($conn->query($sql_notif)){
        //updated notification
        //add redirect
      }
    }
    else{
      //add code for creating an empty row

    }
}
?>
