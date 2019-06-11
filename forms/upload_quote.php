<?php

session_start();


//upload data
$msg = "";
if(isset($_POST["submit"])) {

  include "../config.php";
  
  $username = $_SESSION['username'];
  $file_desc = "";
  if(isset($_POST["description"])) {
    $file_desc = mysqli_real_escape_string($conn, $_POST["description"]);
  }
	if(isset($_POST["ghr"])) {
		$ghrn = $_POST["ghr"];
	}
  $date = date('Y-m-d');

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["quotation"]["name"]);
  $uploadOk = 1;
  $filename = basename($_FILES["quotation"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
      //echo "Sorry, only PDF, Word, JPG, PNG  files are allowed.";
    $msg = "Sorry, only PDF, Word, JPG, PNG  files are allowed.<br>";
      $uploadOk = 0;
  }
  // Check if file already exists
  if (file_exists($target_file)) {
      $randomizer = rand(1,100000);
      $target_file = $target_dir . $randomizer . $_FILES["quotation"]["name"];
      $filename = $randomizer . $_FILES["quotation"]["name"];
  }

  // Check file size approx 10 mb
  if ($_FILES["quotation"]["size"] > 10000000) {
      //echo "Sorry, your file is too large.";
    $msg .= "Sorry, your file is too large.<br>";
      $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      //echo "Sorry, your file was not uploaded.";
        $msg .= "Sorry, your file was not uploaded.<br>";

  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["quotation"]["tmp_name"], $target_file)) {
          //echo "The file ". basename( $_FILES["quotation"]["name"]). " has been uploaded.";

        
        //now post this info in database..

        $sql = "INSERT INTO uploadedquotations (partnersno,GHRN ,partnername, file_location, file_desc, date) VALUES('$partnersno','$ghrn','$username','$filename','$file_desc','$date')";

        if($conn->query($sql) == true){
          //inserted successfully
          $msg .= "The File has been uploaded successfully!<br>";
        }

      } else {
          //echo "Sorry, there was an error uploading your file.";
        $msg .= "Sorry, there was an error uploading your file.<br>";
      }

  }

} 
?>
<!DOCTYPE html>
<html>
<head>
	<title> Upload A Competitive Quote</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="st_upload_quote.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
	<div id = 'top_box' class='container-fluid' style = 'box-shadow:0px 5px grey;'>
      <a href="https://www.gogagaholidays.com"><img src="logonew.png" alt="Company Logo" id = 'logo'></a>
      <p style = 'float:right; color:white; display:inline; margin-top:1.5%;'><strong>Quotation Upload</strong></p>
    </div>
    <br>
    <div class = 'container'>
    	<form action="" method="post">
    		<div class="alert alert-secondary" role="alert">
			  Please Make Sure the file is in the correct format to make sure we can use it!
			  <?php echo "<br>".$msg;	 ?>
			</div>
    		<div class = 'section'>
	    		<h2>Upload A Quotation</h2>
	    		<hr>
	            <div class="form-group row">
	              <label for="ghr" class="col-sm-2 col-form-label">GHRN Number:</label>
	              <div class="col-sm-10">
	                <input type="text" class="form-control" name = '' id="ghr" placeholder = "GHRN7578" required>
	              </div>
	    		</div>
	    		<div class="form-group row">
	              <div class="custom-file ">
					  <input type="file" class="custom-file-input" id="file" name = 'quotation'>
					  <label class="custom-file-label" for="file" id = 'l_file'>Choose a PNG,JPEG or PDF file</label>
				  </div>
	    		</div>
	    		<div class="form-group row">
	              <label for="ghr" class="col-sm-2 col-form-label">Description:</label>
	              <div class="col-sm-10">
                    <textarea  class="form-control" rows="3" cols="40" name='description' id = 'desc'></textarea>
   	              </div>
	    		</div>
    		</div>
    		<div class="row">
            <div class="form-group col-4">
            </div>
            <div class="form-group col-4">
              <button type="submit" name="submit" id='sub_but' class = 'form-control btn btn-lg btn-success' data-toggle="tooltip" data-placement="top" title="One Click away!">Upload</button>
            </div>
            <div class="form-group col-4">
            </div>
          </div>
    	</form>
    </div>
</body>
</html>