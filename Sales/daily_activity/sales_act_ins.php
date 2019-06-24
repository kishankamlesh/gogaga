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

	//partner type
	$par_type = $_POST["p_type"];
	$par_sno = $_POST["p_name"];

	//prospect details
	$cu_name = $_POST["cu_name"];
	$cu_phone = $_POST["cu_phone"];
	$des_dest = $_POST["d_dest"];
	$t_start_day = ($_POST["t_start_d"]);
    $t_start_month = ($_POST["t_start_m"]);
    $t_start_year = ($_POST["t_start_y"]);
    $t_end_day = ($_POST["t_end_d"]);
    $t_end_month = ($_POST["t_end_m"]);
    $t_end_year = ($_POST["t_end_y"]);

    $t_start_date = $t_start_day."-".$t_start_month."-".$t_start_year;
    $t_end_date =  $t_end_day."-".$t_end_month."-".$t_end_year;
    //formatting date
    $st_date = date("Y-m-d", strtotime($t_start_date));
    $end_date = date("Y-m-d", strtotime($t_end_date));
    //activity details
    $act_day = $_POST["activity_day"];
    $act_month = $_POST["activity_month"];
    $act_y = $_POST["activity_year"];
    $act_date = $act_day."-".$act_month."-".$act_y;
    $act_date_fr = date("Y-m-d", strtotime($act_date));
    $exp_com = $_POST["exp_c"];
    $exp_pr = $_POST["exp_p"];
    $iti_sh = $_POST["iti_s"];
    $o_call = $_POST["call_out"];
    $t_amt = $_POST["tot_amt"];
    $amt_c = $_POST["tot_amt_c"];
    
    $sql_ins = "INSERT INTO sales_activity_track (man_id,man_name,man_type,man_uid,par_type,par_sno, pros_name,pros_phone,des_dest,hol_start_date,hol_end_date,activity_date,exp_com,exp_pr,iti_sh,o_call,t_amt,amt_c) VALUES ('$sno','$name','$m_type','$man_uid','$par_type',$par_sno,'$cu_name','$cu_phone','$des_dest','$st_date','$end_date','$act_date_fr','$exp_pr','$exp_pr','$iti_sh','$o_call','$t_amt','$amt_c')";
    if($conn->query($sql_ins)){
    	header('Location:success.html');
    }
    else{
    	header('Location:failure.html');
    }
}
?>