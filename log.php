<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
if(isset($_POST["submit"])){
  $log_st = 0;
  $userid = $_POST["log_id"];
  $pass = $_POST["pwd"];
  $en_pass = md5($pass);
  $sql_chk = "SELECT * FROM login WHERE userid= '".$userid."' AND password = '".$en_pass."'";
  $res_chk = $conn->query($sql_chk);
  if($res_chk->num_rows){
      $log_st = true;
	}
  else{
        $log_st = false;
      }
  }
  if($log_st == true){
    $sql_m_dat = "SELECT * FROM managers_data WHERE uid = '".$userid."'";
    $res_m_dat = $conn->query($sql_m_dat);
    if($res_m_dat->num_rows){
      if($row_m_dat = $res_m_dat->fetch_assoc()){
        $m_type = $row_m_dat["type"];
        $sno = $row_m_dat["sno"];
      }
    }
    $m_type_fin = $m_type."s";
    $sql_dat = "SELECT * FROM ".$m_type_fin." WHERE sno = '".$sno."'";
    $res_dat = $conn->query($sql_dat);
    if($res_dat->num_rows){
      while($row_dat = $res_dat->fetch_assoc()){
        $d_name = $row_dat["disp_name"];
        $name = $row_dat["name"];
      }
    }
    $row_chk = $res_chk->fetch_assoc();
    session_start();
    $_SESSION["userid"] = $userid;
    $_SESSION["d_name"] = $d_name;
    $_SESSION["name"] = $name;
    $_SESSION["sno"] = $sno;
    $type = $row_chk["type"];

    if($type == "Sales"){
      echo $_SESSION["userid"];
      echo $_SESSION["d_name"];

      header("Location:sales_dash.php");
    }
  }
  else{
    header("Location:failure.html");
  }
?>
