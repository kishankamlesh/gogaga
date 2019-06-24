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
if(isset($_POST["sub"])){
  $act_type = $_POST["a_type"];
  if($act_type == 'Recruitment'){
    header("Location:recruitment_activity.php");
  }
  elseif($act_type == 'Sales'){
    header("Location:sales_activity.php");
  }
  elseif($act_type == 'Other'){
    header("Location:other_activity.php");
  }
}
?>
