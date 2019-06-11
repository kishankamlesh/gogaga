<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$id = $_POST["sp_id"];
if(isset($id)){
	$sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$id."'";
	$res_sp = $conn->query($sql_sp);
	if($res_sp->num_rows){
		echo "<option value = ''>Choose Sales Partner</option>";
		while($row_sp = $res_sp->fetch_assoc()){
			echo "<option value = '".$row_sp["sno"]."'>".$row_sp["name"]."</option>";
		}
	}
}
else{
	echo "<option>No data</option>";
}
?>