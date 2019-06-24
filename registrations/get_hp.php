<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$sql_hp = "SELECT * FROM holidaypartners";
$res_hp = $conn->query($sql_hp);
if($res_hp ->num_rows){
	echo "<option value = ''>Choose Holiday Partner</option>";
	while($row_hp = $res_hp->fetch_assoc()){
		echo "<option value = '".$row_hp["sno"]."'>".$row_hp["name"]."</option>";
	}
}
else{
	echo "<option value = ' '>No Holiday Partners</option>";
}
?>