<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$id = $_POST["sp_id"];
if(isset($id)){
	$sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$id."'";
	$res_sm = $conn->query($sql_sm);
	if($res_sm->num_rows){
		if($row_sm = $res_sm->fetch_assoc()){
			$hp_id  = $row_sm["hp_sno"];
			$sql_hp = "SELECT * FROM holidaypartners WHERE sno = '".$hp_id."'";
			$res_hp = $conn->query($sql_hp);
			if($res_hp->num_rows){				
				while($row_hp = $res_hp->fetch_assoc()){
					$sup_id = $row_hp["super_partner_sno"];
					$sql_sup = "SELECT * FROM superpartners WHERE sno = '".$sup_id."'";
					$res_sup = $conn->query($sql_sup);
					if($res_sup->num_rows){
						echo "<option value = ''>Choose Super Partner</option>";
						while($row_sup = $res_sup->fetch_assoc()){
							echo "<option value = '".$row_sup["sno"]."'>".$row_sup["name"]."</option>";
						}
					}
				}
			}
		}
	}
}
else{
	echo "<option>No data</option>";
}
?>