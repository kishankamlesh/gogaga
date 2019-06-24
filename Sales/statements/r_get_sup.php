<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$sql_sup = "SELECT * FROM superpartners";
$res_sup = $conn->query($sql_sup);
if($res_sup->num_rows){
	echo "<option value = ''>Choose Super Partner</option>";
	while($row_sup = $res_sup->fetch_assoc()){
		echo "<option value = '".$row_sup["sno"]."'>".$row_sup["name"]."</option>";
	}
}
else{
	echo "<option>No Super Partners</option>";
}
?>