<?php

//require("../config.php");
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
 $ref_value = $_GET["ref"];
 $ref_type = $_GET["type"]; 
 //$userid= $_SESSION["userid"];

 $sql = "SELECT * FROM login l INNER JOIN agent_form_data a ON (l.userid = a.currently_worked_by) WHERE a.ref_num = '$ref_value'";
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {
              $username = $row["username"];
              $contact = $row["contact"];
              $mailid = $row["mailid"];
              $bookingdate =date("d-M-Y");
              $contact_timings = "09:00AM-07:00PM HRS";
           }
        }

$tourmng = "";
$confir_no = "";
$paxnames = "";

$sql = "SELECT * FROM vouchertable WHERE ref_num ='".$ref_value."'"; 

$res = $conn->query($sql);

  if($res->num_rows){
    if($row = $res->fetch_assoc()){
      $tourmng = $row["tourmng"];
      $confir_no = $row["confir_no"];
      $paxnames = $row["paxnames"];

    }
  }
    
    
$itpages = "";

 $sql = "SELECT * FROM itdaywise WHERE ghrnno = '$ref_value' ORDER BY day";
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {
              $itpages .= " <div class='panel panel-default'>
                                                  <div class='panel-heading'>
                                                        <div class='row'>
                                                          <div class='col-md-3'>&nbsp;&nbsp;&nbsp;<strong>Day ".$row["day"]." :</strong> ".$row["date"]."</div>
                                                        </div> 
                                                  </div>
                                                  <div class='panel-body'>
                                                        
                                                        <div class='ro2w' style='float:left;'>
                                                           <div class='col-md-3'><strong>".$row["title"]."</strong></div>
                                                        </div> <br>
                                                         <div class='row1' style='float:left;'>
                                                           <div class='col-md-3'><strong>".$row["hotelname"]."</strong></div>
                                                        </div>
                                                        <div class='row1' style='float:left;'>
                                                           <div class='col-md-3'><strong>".$row["mealplan"]."</strong></div>
                                                        </div> 
                                                         
                                                        <br>
                                                        <div class='row' style='float:left;'>
                                                            <div class='col-md-12'>
                                                              <br>
                                                              ".$row["description"]."
                                                            </div>
                                                        </div>

                                                  </div>
                                        </div> ";
           }
        }

        $sql = "SELECT * FROM agent_form_data WHERE ref_num = '$ref_value'";
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           { 
                    $clientname = $row["cust_firstname"] ." ".$row["cust_lastname"];
                    $customer_phone = $row["contact_phone"];
              $adults =$row["no_of_adults"];
              $childs =$row["no_of_childs"];
              $infants =$row["no_of_infants"];
              $nooftrav = "$adults Adults,";
                if(!empty($childs))
                  $nooftrav .="$childs Childs,";
                elseif(!empty($infants))
                  $nooftrav .="$infants Infants,";
              $travel_from =$row["trip_start_loc"];
                    $travel_to =$row["holi_dest"];
                  $date_of_travel =$row["date_of_travel"];
                  $return_date_of_travel =$row["return_date_of_travel"];
                  $duration = $row["duration"];
                  $no_rooms =$row["no_rooms"];
              $acc_type =$row["acc_type"];

            }
        }

$hotels ="";
if($ref_type=="International")
{
  $sql = "SELECT * FROM itinerary_inter WHERE ghrno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {  
             $transp_vehicle_type =$row["transp_vehicle_type"];
             $transp_vehicle =$row["transp_vehicle"];
           }
         }




         $sql = "SELECT * FROM hotels_inter WHERE ghrnno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                  $hotels.="
                        <tr style='font-size:12px;'>
                            <td><b>".$row["hotel"]."</b><br><br>".$row["hoteladdr"]."</td>
                            <td>".$row["hotelstandard"]."</td>
                            <td>".$row["roomstandard"]."</td>
                            <td>".$row["checkindate"]." , <b>".$row["checkintime"]."</b></td>
                            <td>".$row["checkoutdate"]." , <b>".$row["checkouttime"]."</b></td>
                        </tr>

                  ";


            }
        }
}
else{
    

  $sql = "SELECT * FROM itinerary_domestic WHERE ghrnno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {  
             $transp_vehicle_type =$row["transp_vehicle_type"];
             $transp_vehicle =$row["transp_vehicle"];
           }
         }

  $sql = "SELECT * FROM hotels_domestic WHERE ghrno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                  $hotels.="
                            <tr style='font-size:12px;'>
                            <td><b>".$row["hotel"]."</b><br><br>".$row["hoteladdr"]."</td>
                            <td>".$row["hotelstandard"]."</td>
                            <td>".$row["roomstandard"]."</td>
                            <td>".$row["checkindate"]." , <b>".$row["checkintime"]."</b></td>
                            <td>".$row["checkoutdate"]." , <b>".$row["checkouttime"]."</b></td>
                        </tr>

                  ";
            }
        }
  }

?>


<html>
<head>
	  <title>Format</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--CSS Tags-->
  <link rel="icon" href="images/logo_icon.png"/>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <!--Script Tags-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> 
<style>@import url('https://fonts.googleapis.com/css?family=Roboto|Source+Sans+Pro');</style>
<style type="text/css">
.*{
	padding: 0px;
	margin: 0px;
}
.top_part
{
  position: absolute;
  top: 5px;
  left: 40px;
  width: 70%;
}
.logo
{
	position: absolute;
	right: 10px;
	top: 0px;
}

.top_heading
{
	position:absolute;
	top: -20px;
	left:20px;
	
	width: 300px;
}
.content
{
	position: absolute;
	top: 70px;
	left: 50px;
	font-family: 'Source Sans Pro', sans-serif; 

}
tr
{
	height: 40px;
}
.table1
{
	position: absolute;
	left: 100px;
}
.top_section
{	
	position: absolute;
	top: 60px;
	float: left;

}
.bot_travel
{	position: absolute;
	top: 900px;
  left: 50px;
  padding-right: 100px;
	height: 100px;
	width: 100%;
}
.holipic
{
  position:absolute;top:20px;right:10px;
}
.second_page
{
  position: absolute;
  top: 1000px;
  width: 100%;
}
.itday
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 50px;
}
.ithead
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 250px;
}
.ithotel
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 250px;
}
.itmeal
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 150px;
}
.itdate
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 150px;
}
</style>

</head>


<body>

<div class='logo'>
<img src="../images/logo_1.png" width='auto' height='50'>
</div>



<br>
<div class='content'>
  <h1 style='text-align:center;'>CONFIRMATION VOUCHER</h1><br>
  <table class='table table-responsive' style='border:none;background-color: white;'>
                 <tr>
                     <th style='width:400px;'>CLIENT NAME</th>
                     <td><?php echo "$clientname";?></td>
               </tr>
                <tr>
                     <th style='width:400px;'>CLIENT PHONE</th>
                     <td><?php echo "$customer_phone";?></td>
               </tr>
               <tr>
                     <th style='width:400px;'>NUMBER OF TRAVELLERS</th>
                     <td><?php echo "$nooftrav";?></td>
               </tr>  
               <tr>
                     <th style='width:400px;'>BOOKING ID</th>
                     <td><?php $ref_str=5000+$ref_value;
                          echo "GHRN$ref_str";?></td>
               </tr>
              <tr>
                    <th style='width:400px;'>CONFIRMATION NUMBER</th>
                    <td style='width:300px;'><?php echo "$confir_no";?></td>
               </tr>
               <tr>
                     <th style='width:400px;'>TOUR MANAGER DETAILS</th>
                     <td><?php echo "<b>$tourmng</b>";?></td>
               </tr>  
               
                <tr>
                     <th style='width:400px;'>PAX NAMES</th>
                     <td style='width:400px;'><?php echo "$paxnames";?></td>
               </tr>
                <tr>
                     <th style='width:400px;'>HOLIDAY FROM</th>
                     <td style='width:400px;'><?php echo "$travel_from";?></td>
               </tr>

               <tr>
                     <th>HOLIDAY TO</th>
                    <td><?php echo "$travel_to";?></td>
               </tr>
                <tr>
                     <th style='width:400px;'>TRIP START DATE</th>
                     <th>TRIP END DATE</th>
               </tr>

               <tr>
                    <td style='width:400px;'><?php echo "$date_of_travel";?></td>
                    <td><?php echo "$return_date_of_travel";?></td>
               </tr>
        
  </table>
  <br>
  <table class='table table-responsive' style='border:none;background-color: white;'>
                 <tr>
                     <th style='width:400px;'>ITINERARY MANAGER</th>
                     <td><?php echo "$username";?></td>
               </tr>
               <tr>
                     <th style='width:400px;'>CONTACT NO</th>
                     <td><?php echo "$contact";?></td>
               </tr>
               <tr>
                     <th style='width:400px;'>CONTACT TIMINGS</th>
                     <td><?php echo "$contact_timings";?></td>
               </tr>    
               <tr>
                     <th style='width:400px;'>MAIL ID</th>
                     <td><?php echo "$mailid";?></td>
               </tr>
              <tr>
                    <th style='width:400px;'>BOOKING DATE</th>
                    <td style='width:300px;'><?php echo "$bookingdate";?></td>
               </tr>
        
  </table>
  <p style='font-size:12px;'>
  Thank you for using Gogaga Holidays to book your Holiday Package / Hotel Accommodations. Please  Kindly note, your booking is CONFIRMED and required to contact the hotel or Gogaga Holidays to reconfirm the same. You will need to carry a copy of this
   e-mail and present it at the hotel at the time of check in with valid ID proof for all the pax.  We hope you have a pleasant stay and look forward to assisting again!</p>
</div>

<br><br>
<div class='second_page'>

  
  <h2 style='text-align:center;'>HOTEL DETAILS</h2>
  <br>
     <table class='table table-responsive' style='border:none;background-color: white;'>
      <tr style='font-size:12px;'>
          <th>HOTEL DETAILS</th>
          <th>HOTEL STANDARD</th>
          <th>ROOM STANDARD</th>
          <th>CHECKIN DATE & TIMINGS</th>
          <th>CHECKOUT DATE & TIMINGS</th>
      </tr>
      <?php echo "$hotels";?>
  </table>
   <br>


  <?php
        if(!empty($transp_vehicle))
        {

  ?>
  
  <h2 style='text-align:center;'>TRANSPORT DETAILS</h2>
  <br>
     <table class='table table-responsive' style='border:none;background-color: white;'>
      <tr style='font-size:12px;'>
          <th>TRANSPORT VEHICLE DETAILS</th>
          <td><?php echo "$transp_vehicle";?></td>
      </tr>
      <tr style='font-size:12px;'>
          <th><?php echo strtoupper($transp_vehicle_type);?> TRANSFERS DEFINITION</th>
          <td><?php
             if($transp_vehicle_type == "sic")
              echo "SIC tours stands for Seat-in-Coach Basis Tours, which means you will share a coach or van with other tourists and you will be taken to all the scenic spots listed in the Itinerary that day.";
            else
              echo "A private transfer is a taxi or other vehicle reserved solely for your party. Private transfers will be waiting for you on arrival to the destination airport, and will take you directly to your hotel or apartment, without any stops on route.";

          ?></td>
      </tr>
  </table>
   <br>
   <?php 
    }
   ?>

<br>
  <h2 style='text-align:center;'>DAY WISE ITINERARY</h2>
  <br>
    
     <?php 
        echo "$itpages";

     ?> 
 
    <br>














<?php
$flightcontent ="";
$sql = "SELECT * FROM flights_info WHERE ghrno = '".$ref_value."'  ORDER BY sno";
                 $res = $conn->query($sql) ;
                          if ($res->num_rows) 
                          { 
                             while($row = $res->fetch_assoc()) 
                                { 
                  
                     $flightcontent .= "<tr style='font-size:12px;'>
                                            <td>".$row["airline"]."</td>
                                            <td>".$row["airport"]."</td>
                                            <td>".$row["arrdep"]."</td>
                                            <td>".$row["airdur"]."</td>
                                            <td>".$row["airdates"]."</td>
                                          </tr>";
                                }
                           }



                        if(!empty($flightcontent))
                     echo "<h2 style='text-align:center;'>FLIGHT DETAILS</h2>
                          <br>
                             <table class='table table-responsive' style='border:none;background-color: white;'>
                             <tr style='font-size:11px;'>
                               <th>AIRLINES</th>
                               <th>AIPORTS</th>
                               <th>ARRIVAL & DEPARTURE</th>
                               <th>DURATION</th>
                                <th>DATES</th>
                          </tr>
                          ".$flightcontent."
                          </table>
                            <br> 

                          ";
                    ?>
    
   
  




<div class='col-md-12'>
  <br><br> <br><br> <br><br>





<div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong> IMPORTANT NOTES</strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>
 <p>1) All the travellers sould reach the airport 2 hours before the Flight departure.
  </p><p>2) All the travellers are advised to know the flight delay orCancellations in advance from the airlines to avoid trip cancellation
 </p><p> 3) Please carry baggage as per the tickets issued and any excess baggage additonal to the baggage provided will be charged by the airlines as per the airlines baggage policy
 </p><p>4) Please note any rescheduling, Cancellation, Amendments from Airlines, Any Corrections are subjected to Your Choosen Airlines policies. Gogaga Holidays will not hold any responsibility in regards to any above mentioned corrections.
 </p><p>5) The Voucher is not allowed for any corrections and Changes, further any additonal services can be provided subject to service availability and on payment of additional charges.   
 </p><p>6) The hotels envisaged in the Vouchers cannot be changed, and no refund is allowed on the booking of hotel and services  
 </p><p>7) All the travellers should follow the timings as per the Holiday Vouchers, and any  delay or no show in transfers the company will not hold and responsibility.
  </p><p>8) For any Public Holidays, Natural Calamaties, Sudden unexpected Government Decessions the company will not hold responsible for Sightseeings and transfers.
</p>
                            
                </div>
      </div>  




   <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong>CANCELLATION POLICY </strong></div>
                      </div> 
                </div>
                <div class="panel-body">
                    <?php echo "Cancellation / Amendment notice received       Cancellation charges per person <br>    
                    Up to 30 days prior to date of departure      Initial deposit amount or 25% of tour cost if full paid <br>    
                    Between 15 days to 29 days prior to departure     50% of tour cost<br>
                    Less than 14 days to 8 days     75% of tour cost<br>
                    Less than 8 days to 72 hrs.     100% non refundable <br>
                    Note : Cancellation Policy is not negotiable in any condition and air ticket Cancellation as per airlines policy. <br>";
                    ?>

                </div>
    </div>


<h6 style='text-align:center;'>Special Note : Tour Plan & hotels will not be changed once tour starts & tour will remain as per itinerary.</h6>
<br>
   <h5 style='text-align:center;'> GOGAGA HOLIDAYS PVT.LTD </h5>        
<h6 style='text-align:center;'> Head Office Regus, 4TH Floor,Gumidelli towers,old airport road, Begumper,Hyderabad - 500016 India </h6>
 <h6 style='text-align:center;'> www.gogagaholidays.com  </h6>        
            
</div>

</div>

</body>
<script type="text/javascript">


$(document).ready(function(){

    window.print();

});


</script>
</html>
