<?php
session_start();
if(!(isset($_SESSION["userid"]))){
  header('Location:login.html');
}
else{
  $d_name = $_SESSION["d_name"];
  $user_id = $_SESSION["userid"];

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <link rel="stylesheet" href="st_sales_dash.css">
  </head>
  <body>
    <div class="container-fluid" style='padding:0'>
      <nav class="navbar navbar-default navbar-dark bg-dark fixed-top" id = 'm_nav'>
        <div class="" style = 'width:111px; height:38px'>
          <a class="navbar-brand" href="sales_dash.php"> <img src="logonew.png" alt=""> </a>
        </div>
        <div class = 'drpdn_right'>
          <a class="nav-link dropdown-toggle menu" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style = 'color:black;'>
          <a class="dropdown-item" target = '_blank' href="profile/profile.php">Profile</a>
          <div><hr class ='style2'></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
        </div>
      </nav>
    </div>
    <div class="jumbotron jumbotron-fluid" id = 'j_main'>
      <div class="container">
        <h1 class="display-4" style = 'color:black;'>Welcome, <?php echo $d_name ?>!</h1>
        <p class="lead" style = 'color:black;'>Lets get you started!</p>
      </div>
      <br>
      <a href="sales_dash.php" class = 'links'>Dashboard</a>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="formdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Forms
        </a>
        <div class="dropdown-menu" aria-labelledby="formdropdown">
          <a class="dropdown-item" target = "_blank" href="forms/req_form.php">Request Form</a>
          <a class="dropdown-item" target = "_blank" href="forms/upload_quote.php">Upload A Competitive Quote</a>
        </div>
      </div>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="itidropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Itineraries
        </a>
        <div class="dropdown-menu" aria-labelledby="itidropdown">
          <a class="dropdown-item" href="#">Requested</a>
          <a class="dropdown-item" href="#">Recieved</a>
          <a class="dropdown-item" href="#">Confirmed</a>
          <a class="dropdown-item" href="#">Recent Packages</a>
        </div>
      </div>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="partdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Partners
        </a>
        <div class="dropdown-menu" aria-labelledby="partdropdown">
          <a class="dropdown-item" href="#">Super Partners</a>
          <a class="dropdown-item" href="#">Holiday Partners</a>
          <a class="dropdown-item" href="#">Sales Partners</a>
        </div>
      </div>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="tooldropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tools
        </a>
        <div class="dropdown-menu" aria-labelledby="tooldropdown">
          <a class="dropdown-item" target='_blank' href="Tools/currency_conv.html">Currency Converter</a>
          <a class="dropdown-item" target='_blank' href="https://www.google.com/maps/@17.4692184,78.3634493,16.04z" href="#">Maps</a>
        </div>
      </div>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="stdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Statements
        </a>
        <div class="dropdown-menu" aria-labelledby="stdropdown">
          <a class="dropdown-item" href="#">Issued Statements</a>
        </div>
      </div>
        <a href="#" class = 'links'>Clients</a>
        <a href="#" class = 'links'>Vouchers</a>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="moredropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            More
        </a>
        <div class="dropdown-menu" aria-labelledby="moredropdown">
          <a class="dropdown-item" href="#">Marketing Flyers</a>
          <a class="dropdown-item" target = "_blank" href="More/contacts.html">Contacts</a>
          <a class="dropdown-item" target = "_blank" href="More/international_sim_cards.html">International Sim Cards</a>
          <a class="dropdown-item" target = "_blank" href="More/travel_guide.html">Travel Guide</a>
          <a class="dropdown-item" target = "_blank" href="More/travel_insurance.html">Travel Insurance</a>
          <a class="dropdown-item" target = "_blank" href="More/travel_visa.html">Travel Visa</a>
          <a class="dropdown-item" target = "_blank" href="More/travel_definitions.html">Travel Definitions</a>
          <a class="dropdown-item" target = "_blank" href="More/terms.html">Terms And Conditions</a>
          <a class="dropdown-item" target = "_blank" href="More/faq.html">FAQs</a>

        </div>
      </div>
      <a target = '_blank' href="daily_activity/activity_report.php" class = 'links links_rt'>Daily Activity Report</a>
    </div>
    <div class="container-fluid">
        <div class="row">
          <div class="col-2 crd">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
              <div class="card-header">Total Itineraries Requested</div>
              <div class="card-body">

                <p class="card-text">0 </p>
              </div>
            </div>
          </div>
          <div class="col-2 crd">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
              <div class="card-header">Total Itineraries Recieved</div>
              <div class="card-body">

                <p class="card-text">0 </p>
              </div>
          </div>
        </div>
        <div class="col-2 crd">
          <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Total Itineraries Confirmed</div>
            <div class="card-body">
              <p class="card-text">0 </p>
            </div>
          </div>
        </div>
        <div class="col-2 crd">
          <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Total Volume Converted</div>
            <div class="card-body">
              <p class="card-text">0 </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-5">
          <canvas id="chart_2" class = 'graph' width="300" height="300">
          </canvas>
        </div>
        <div class="col-5">
          <canvas id="chart_1" class = 'graph' width="300" height="300">
          </canvas>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div style = 'width:100%;'>
          <hr class='style2'>
          <p style = 'margin-left:1%;'>&copy;GoGaGa Holidays 2016-2019 <br> All Rights Reserved.</p>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script type="text/javascript" src = 's_sales_dash.js'>

    </script>
  </body>
</html>
