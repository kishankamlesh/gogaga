<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
$act_id = $_POST["act_id"];
$sql_other = "UPDATE sales_activity_track SET review_status = 'Reviewed' WHERE sno = '".$act_id."'";
if($conn->query($sql_other)){
	echo "Success";
}
else{
	echo "Failure";
}
?>