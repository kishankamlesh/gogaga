<?php
session_start();
if(isset($_POST['send'])){
$to = 'kishankamlesh@gmail.com';
$subject = 'demo';
$message = $_POST['act'];
$header = 'From: webmaster@example.com' . "\r\n" .
    	  'Reply-To: webmaster@example.com' . "\r\n" .
    	  'X-Mailer: PHP/' . phpversion();
mail($to,$subject,$message,$header);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Daily Activity Report</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_common.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
	<div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Daily Activity Report</strong></p>
    </div>
    <br>
    <div class = 'container'>
    	<h3>Daily Activity</h3>
    	<small>Let's Catch up! What have you been upto lately?</small>
    	<form action="" method="post" accept-charset="utf-8">
    		<div class  = 'section'>
	    		<h2>Activity Details</h2>
	            <div class="form-group row">
	              <label for="act" class="col-sm-2 col-form-label">Please Describe your activity today:</label>
	              <div class="col-sm-10">
	                <textarea  class="form-control" rows="3" cols="40" name='act' id = 'act'></textarea>
	              </div>
	            </div>
	            <div class="form-group row">
	            	<div class = 'col-4'>
	            		
	            	</div>
	              <div class="col-4">
	                <button class = 'form-control btn btn-lg btn-primary' type="submit" name = 'send'>Send</button>
	              </div>
	              <div class = 'col-4'>
	            		
	            	</div>
	            </div>
    		</div>
    	</form>
    </div>
</body>
</html>