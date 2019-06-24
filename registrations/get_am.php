<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$sql_am = "SELECT * FROM areamanagers";
$res_am = $conn->query($sql_am);
if($res_am ->num_rows){
	echo "<option value = ''>Choose Area Manager</option>";
	while($row_am = $res_am->fetch_assoc()){
		echo "<option value = '".$row_am["name"]."'>".$row_am["name"]."</option>";
	}
}
else{
	echo "<option value = ' '>No Area Managers</option>";
}
?>