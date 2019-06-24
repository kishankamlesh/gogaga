<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$sql_rm = "SELECT * FROM regionalmanagers";
$res_rm = $conn->query($sql_rm);
if($res_rm ->num_rows){
	echo "<option value = ''>Choose Regional Manager</option>";
	while($row_rm = $res_rm->fetch_assoc()){
		echo "<option value = '".$row_rm["name"]."'>".$row_rm["name"]."</option>";
	}
}
else{
	echo "<option value = ' '>No Reginonal Managers</option>";
}
?>