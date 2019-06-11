<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
if(isset($_POST["submit"])){
  $sno = $_POST["m_id"];
  $f_name = $_POST["full_name"];
  $d_name = $_POST["d_name"];
  $dob = $_POST["dob"];
  $m_type = $_POST["m_type"];
  $h_type = $_POST["h_type"];
  $u_type = $_POST["user_t"];
  $userid = $_POST["uid"];
  $pass = md5($_POST["pass"]);
  $email = $_POST["email"];
  $dob = date("Y-m-d", strtotime($dob));
  $date = date("Y-m-d");
  $c_num = $_POST["c_num"];
  $dist = $_POST["dis"];
  $state = $_POST["state"];

  $sql_log_ins = "INSERT INTO login (userid,acc_status,username,password,type,handle_type,DOB,contact,mailid,joindate)
                  VALUES ('$userid','Active','$f_name','$pass','$m_type','$h_type','$dob','$c_num','$email','$date')";
  if($conn->query($sql_log_ins) == true){
    //insert data into salesmanagers table

    if($u_type == "salesmanager"){
      echo "Success!";
      $am_name = $_POST["am_name"];
      $sql_am_id = "SELECT * FROM areamanagers WHERE name = '".$am_name."'";
      $res_am_id = $conn->query($sql_am_id);
      if($res_am_id->num_rows){
        if($row_am_id = $res_am_id->fetch_assoc()){
          $am_id = $row_am_id["sno"];
        }
      }
      $sql_sm_ins = "INSERT INTO salesmanagers (sno,name,dob,disp_name,phone,email,uid,district,state,date_of_joining, area_manager_name,a_m_sno) VALUES ('$sno','$f_name','$dob','$d_name','$c_num','$email','$userid','$dist','$state','$date','$am_name','$am_id')";
      if($conn->query($sql_sm_ins)){
        $sql_md_ins = "INSERT INTO managers_data (sno,name,dob,uid,district,state,type) VALUES ('$sno','$f_name','$dob','$userid','$dist','$state','salesmanager')";
        if($conn->query($sql_md_ins)){
          header('Location:success.html');
        }
        else{
          header('Location:failure_reg.html');
        }

      }
    }
    elseif($u_type == "areamanager"){
      echo "Success!";
      $rm_name = $_POST["rm_name"];
      $sql_rm_id = "SELECT * FROM regionalmanagers WHERE name = '".$rm_name."'";
      $res_rm_id = $conn->query($sql_rm_id);
      if($res_rm_id->num_rows){
        if($row_rm_id = $res_rm_id->fetch_assoc()){
          echo "Success!";
          $rm_id = $row_rm_id["sno"];
        }
      }
      $sql_am_ins = "INSERT INTO areamanagers (sno,name,dob,disp_name,phone,email,uid,district,state,d_o_join, reg_m_name,reg_m_sno) VALUES ('$sno','$f_name','$dob','$d_name','$c_num','$email','$userid','$dist','$state','$date','$rm_name','$rm_id')";
      if($conn->query($sql_am_ins)){
        echo "Success!";
        $sql_md_ins = "INSERT INTO managers_data (sno,name,dob,uid,district,state,type) VALUES ('$sno','$f_name','$dob','$userid','$dist','$state','areamanager')";
        if($conn->query($sql_md_ins)){
          header('Location:success.html');
        }
        else{
          header('Location:failure_reg.html');
        }
      }
    }
    elseif($u_type == "regionalmanager"){
      $sql_sm_ins = "INSERT INTO regionalmanagers (sno,name,dob,disp_name,phone,email,uid,district,state,d_o_join) VALUES ('$sno','$f_name','$dob','$d_name','$c_num','$email','$userid','$dist','$state','$date')";
      if($conn->query($sql_sm_ins)){
        $sql_md_ins = "INSERT INTO managers_data (sno,name,dob,uid,district,state,type) VALUES ('$sno','$f_name','$dob','$userid','$dist','$state','regionalmanager')";
        if($conn->query($sql_md_ins)){
          header('Location:success.html');
        }
        else{
          header('Location:failure_reg.html');
        }
      }
    }
  }
}
/*
$str = "GH8130";
$id = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
echo "$id";
output:8130
*/
?>
