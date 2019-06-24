<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
  $user_id = $_SESSION["userid"];
  $sql_m_d = "SELECT * FROM managers_data WHERE uid ='".$user_id."' ";
  $res_m_d = $conn->query($sql_m_d);
  if($res_m_d->num_rows){
  	while($row_m_d = $res_m_d->fetch_assoc()){
  		$em_id = $row_m_d["sno"]; 
  		$name = $row_m_d["name"];
  		$district = $row_m_d["district"];
  		$state = $row_m_d["state"];
  		$type = $row_m_d["type"];
  	}
  }
  $type_fin = $type."s";
  $sql_dat = "SELECT * FROM ".$type_fin." WHERE uid ='".$user_id."' ";
  $res_dat = $conn->query($sql_dat);
  if($res_dat->num_rows){
  	while($row_dat = $res_dat->fetch_assoc()){
  		if($type == "salesmanager"){
		  	$d_type = "Sales Manager";
		  	$doj = $row_dat["date_of_joining"];
  			$am_name = $row_dat["area_manager_name"];
  			$d_name = $row_dat["disp_name"];
		 }
		  else if($type == "areamanager"){
		  	$d_type = "Area Manager";
		  	$doj = $row_dat["d_o_join"];
  			$am_name = $row_dat["reg_m_name"];
  			$d_name = $row_dat["disp_name"];
		 }
		  else if($type == "regionalmanager"){
		  	$d_type = "Regional Manager";		  	
		  	$doj = $row_dat["d_o_join"];
  			$d_name = $row_dat["disp_name"];
		 }  		  	
  	}
  }
  //display data
  $show_date = date("d-M-Y", strtotime($doj));
  if($type == "salesmanager"){
  	$d_type = "Sales Manager";
  }
  else if($type == "areamanager"){
  	$d_type = "Area Manager";
  }
  else if($type == "regionalmanager"){
  	$d_type = "Regional Manager";
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
	<div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Profile</strong></p>      
    </div>
    <br>
    <div class='container-fluid'>
    	<h3>Profile</h3>
    	<small>Here is all we know about you!</small>
    	<div class = 'row'>
    	 	<div class = 'col-2' style = 'border:2px dashed lightgrey; padding-top: 10px;'>

    	 		<img src="sample.png" alt="profile picture" id  = 'prof_pic'>
    	 		<br> <br>
    	 		<p align = 'center'><?php echo $d_name;?></p>
    	 		<button class = 'btn btn-sm btn-warning' type="submit" style = 'margin-left:12%'>Change Profile Picture</button>
    	 		<br> <br>
    	 	</div>
    	 	<div class = 'col-10' style = 'border:2px dashed lightgrey; padding-top:10px;'>
    	 		<table class = 'table table-striped'>    	 
    	 			<tbody>
    	 				<tr>
    	 					<td><strong>Name</strong></td>
    	 					<td><?php echo $name;?></td>
    	 				</tr>
    	 				<tr>
    	 					<td><strong>Empolyee ID</strong></td>
    	 					<td><?php echo $em_id;?></td>
    	 				</tr>
    	 				<tr>
    	 					<td><strong>Designation</strong></td>
    	 					<td><?php echo $d_type;?></td>
    	 				</tr>
    	 				<tr>
    	 					<td><strong>District</strong></td>
    	 					<td><?php echo $district;?></td>
    	 				</tr>
    	 				<tr>
    	 					<td><strong>State</strong></td>
    	 					<td><?php echo $state;?></td>
    	 				</tr>
    	 				<tr>
    	 					<td><strong>Date of Joining</strong></td>
    	 					<td><?php echo $show_date;?></td>
    	 				</tr>
    	 			</tbody>
    	 		</table>
    	 	</div>
    	 </div> 
    </div>
</body>
</html>