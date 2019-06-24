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
if(isset($_POST["submit"])){
	$man_id = $_POST["m_id"];
	$man_name = $_POST["m_name"];
	//m_type already available
	$man_uid = $_POST["m_uid"];

	//partner data	
	$par_type = $_POST["p_type"];
	$par_sno = $_POST["p_name"];

	//location detail
	$place = $_POST["place"];
	$act_area = $_POST["a_area"];

	//actitvity details
	$act_source = $_POST["a_source"];
	$act_type = $_POST["a_type"];
	$d_name = $_POST["d_maker"];
	$d_number = $_POST["d_maker_num"];
	$d_profile = $_POST["d_maker_pro"];
	$exp_com = $_POST["exp_c"];
    $exp_pr = $_POST["exp_p"];
    $iti_sh = $_POST["iti_s"];
    $num_lead = $_POST["num_lead"];
    $final_st = $_POST["status"];

    //activity date
	$act_day = $_POST["activity_day"];
    $act_month = $_POST["activity_month"];
    $act_y = $_POST["activity_year"];
    $act_date = $act_day."-".$act_month."-".$act_y;
    $act_date_fr = date("Y-m-d", strtotime($act_date));


    $sql_ins = "INSERT INTO other_activity_track (man_id,man_name,man_type,man_uid,par_type,par_sno,place,area, activity_date,source,act_type,decision_maker,d_contact,d_profile,company_explained, product_explained,iti_shared,num_leads,remarks) VALUES ('$sno','$name','$m_type','$man_uid','$par_type','$par_sno','$place','$act_area','$act_date_fr','$act_source','$act_type','$d_name','$d_number','$d_profile','$exp_com','$exp_pr','$iti_sh','$num_lead','$final_st')";
    if($conn->query($sql_ins)){
    	header('Location:success.html');
    }
    else{
    	header('Location:failure.html');
    }    
}