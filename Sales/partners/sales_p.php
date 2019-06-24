<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
$name = $_SESSION["name"];
$userid = $_SESSION["userid"];
$sno = $_SESSION["sno"];
$d_name = $_SESSION["d_name"];
$sql_m_type = "SELECT * FROM managers_data WHERE sno = '".$sno."'";
$res_m_type = $conn->query($sql_m_type);
if($res_m_type->num_rows){
  if($row_m_type = $res_m_type->fetch_assoc()){
    $m_type = $row_m_type["type"];
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sales Partners</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="st_common.css">
</head>
<body>
	<div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
		<a href="../sales_dash.php"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
		<p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Partners</strong></p>
	</div>
	<br>
	<div class="container-fluid">
		<h3>Sales Partners</h3>
		<small>Hey, <?php echo $d_name ?>! Here are your Sales Partners</small>
    <br>    
		<?php
		switch($m_type){
			case "salesmanager":
      $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
	     $res_sp = $conn->query($sql_sp);
	      if($res_sp->num_rows){
		        echo "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Partner Sno</th>
                      <th scope='col'>Partner Name</th>
                      <th scope='col'>Contact</th>
                      <th scope='col'>Email</th>
                    </tr>
                  </thead>";
		          while($row_sp = $res_sp->fetch_assoc()){
			             echo "<tr>
                       <td>".($row_sp["sno"])."</td>
                       <td>".$row_sp["name"]."</td>
                       <td>".$row_sp["phone"]."</td>
                       <td>".$row_sp["email"]."</td>
                       </tr>";
		               }
                   echo "</table>";
	                }
      break;
      case "areamanager":
      $sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$sno."'";
      $res_sm = $conn->query($sql_sm);
      if($res_sm->num_rows){
	       while($row_sm = $res_sm->fetch_assoc()){
		         $sm_id = $row_sm["sno"];
		           $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sm_id."'";
		             $res_sp = $conn->query($sql_sp);
		               if($res_sp->num_rows){
			                  echo "<table class='table'>
                              <thead class='thead-light'>
                                <tr>
                                  <th scope='col'>Partner Sno</th>
                                  <th scope='col'>Partner Name</th>
                                  <th scope='col'>Contact</th>
                                  <th scope='col'>Email</th>
                                </tr>
                              </thead>";
			                  while($row_sp = $res_sp->fetch_assoc()){
			                     echo "<tr>
                               <td>".($row_sp["sno"])."</td>
                               <td>".$row_sp["name"]."</td>
                               <td>".$row_sp["phone"]."</td>
                               <td>".$row_sp["email"]."</td>
                               </tr>";
		                    }
                        echo "</table>";
		                }
          }
      }
      break;
      case "regionalmanager":
      $sql_sp = "SELECT * FROM salespartners";
      $res_sp = $conn->query($sql_sp);
      if($res_sp->num_rows){
	       echo "<table class='table'>
               <thead class='thead-light'>
                 <tr>
                   <th scope='col'>Partner Sno</th>
                   <th scope='col'>Partner Name</th>
                   <th scope='col'>Contact</th>
                   <th scope='col'>Email</th>
                 </tr>
               </thead>";
	        while($row_sp = $res_sp->fetch_assoc()){
		          echo "<tr>
                  <td>".($row_sp["sno"])."</td>
                  <td>".$row_sp["name"]."</td>
                  <td>".$row_sp["phone"]."</td>
                  <td>".$row_sp["email"]."</td>
                  </tr>";
	           }
             echo "</table>";
           }
      break;
		}
		?>
	</div>
</body>
</html>
