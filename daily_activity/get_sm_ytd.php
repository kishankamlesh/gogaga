<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$am_id = $_POST["am_id"];
$sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$am_id."'";
$res_sm = $conn->query($sql_sm);
if($res_sm->num_rows){
	echo "<option>Select Manager Name</option>";
	while($row_sm = $res_sm->fetch_assoc()){
		echo "<option value = '".$row_sm["name"]."'>".$row_sm["name"]."</option>";
	}
}
else{
	echo "No Sales managers Found";
}
?>