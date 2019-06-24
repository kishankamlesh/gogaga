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

	//prospect details
	$pr_type = $_POST["p_type"];
	$pr_source = $_POST["pr_source"];
	$pr_name = $_POST["pr_name"];
	$pr_con = $_POST["pr_phone"];
	$pr_loc = $_POST["pr_loc"];
	$date_meet = $_POST["date_meet"];
	$pr_profile = $_POST["pr_profile"];

	//activity details
	$pres = $_POST["pres"];
	$pr_st = $_POST["part_st"];
	$amt_p = $_POST["amt_p"];
	$final_st = $_POST["status"];

	//meeting date
	$meet_dt = date("Y-m-d", strtotime($date_meet));

	//activity date
	$act_day = $_POST["activity_day"];
    $act_month = $_POST["activity_month"];
    $act_y = $_POST["activity_year"];
    $act_date = $act_day."-".$act_month."-".$act_y;
    $act_date_fr = date("Y-m-d", strtotime($act_date));

	$sql_ins = "INSERT INTO rec_activity_track (man_id,man_name,man_type,man_uid,pr_type,pr_source,pr_name,pr_phone,pr_loc,pr_profile,activity_date,meet_date,presentation,pr_status,fee_paid,remarks) 
				VALUES ('$sno','$name','$m_type','$man_uid','$pr_type','$pr_source','$pr_name','$pr_con','$pr_loc','$pr_profile','$act_date_fr','$meet_dt','$pres','$pr_st','$amt_p','$final_st')";
    if($conn->query($sql_ins)){
    	header('Location:success.html');
    }
    else{
    	header('Location:failure.html');
    }    
}
   
?>