<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$am_id = $_POST["am_id"];
$sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$am_id."'";
$res_hp = $conn->query($sql_hp);
if($res_hp->num_rows){
	if($row_hp = $res_hp->fetch_assoc()){
		$sup_sno = $row_hp["super_partner_sno"];
	}
}
$sql_sup = "SELECT * FROM superpartners WHERE sno = '".$sup_sno."'";
$res_sup = $conn->query($sql_sup);
if($res_sup->num_rows){
	echo "<option value = ''>Choose Holiday Partner</option>";
	if($row_sup = $res_sup->fetch_assoc()){
		echo "<option value = '".$row_sup["sno"]."'>".$row_sup["name"]."</option>";
	}
}
else{
	echo "<option>No data</option>";
}
?>