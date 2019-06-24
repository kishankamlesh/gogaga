<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$am_id = $_POST["am_id"];
$sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$am_id."'";
$res_sm = $conn->query($sql_sm);
if($res_sm->num_rows){
	while($row_sm = $res_sm->fetch_assoc()){
		$sm_id = $row_sm["sno"];
		$sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sm_id."'";
		$res_sp = $conn->query($sql_sp);
		if($res_sp->num_rows){
			echo "<option value = ''>Choose Sales Partner</option>";
			while($row_sp = $res_sp->fetch_assoc()){
			echo "<option value = '".$row_sp["sno"]."'>".$row_sp["name"]."</option>";
		}
		}
		else{
			echo "<option>No data</option>";
		}
	}
}
?>