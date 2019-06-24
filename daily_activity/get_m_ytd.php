<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$am_id = $_POST["am_id"];
$sql_m = "SELECT * FROM managers_data WHERE type = 'areamanager' OR type = 'salesmanager'";
$res_m = $conn->query($sql_m);
if($res_m->num_rows){
	echo "<option>Select Manager Name</option>";
	while($row_m = $res_m->fetch_assoc()){

		echo "<option value = '".$row_m["name"]."'>".$row_m["name"]."</option>";
	}
}
else{
	echo "No managers Found";
}
?>