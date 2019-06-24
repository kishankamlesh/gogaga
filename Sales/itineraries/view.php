<?php

require("config.php");
session_start();

    $ref_type=$_GET["r"];
    $ref_value=$_GET["q"];
    $userid=$_SESSION["userid"];

    $roomtype = "";

    $flight_loadperc = 0;
    $flightloadedprice = 0;

    $hotecheckindate = "";
    $hotecheckoutdate= "";



      //Update Itinerary as Submitted from Pending
      $sql ="UPDATE agent_form_data
              SET formstatus = 'submitted' 
              WHERE ref_num = '".$ref_value."' AND formstatus = 'pending'
            ";
      if($conn->query($sql) == true)
      {
          
      }
      else
      {
      
      }

 

      /* START OF PRINT WORK*/
        $sql = "SELECT * FROM agent_form_data a INNER JOIN login l ON a.currently_worked_by = l.userid WHERE a.ref_num = '$ref_value'";
                
                
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {  

            $emp_name = $row["username"];
            $emp_contact = $row["contact"];

              $clientname = $row["cust_firstname"] ." ".$row["cust_lastname"];
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
              
              $no_rooms =$row["no_rooms"];
              $no_rooms =$row["no_rooms"];
				$s_type = $row["s_type"];


            }
        }
        /* END OF PRINT WORK*/
$hotels ="";
$cur_year = date("Y");
$cur_month = date("m");

if($ref_type=="International")
{


        $sql = "SELECT * FROM itinerary_inter WHERE ghrno = '$ref_value'";
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {  
              // To Display Employee Details in PDF Form


                $calc_chosed_by  = $row["calc"];

                $no_of_pax  = $row["no_of_pax"];

                //get the flight loading percentage
                $flightprice = (int)$row["flightprice"];
                $flight_loadperc = (int)$row["flight_loadperc"];
                (int)$flightloadedprice = ($flightprice * $flight_loadperc) / 100;

                $totcost = (int)$row["totcost"];
                $totcostfl = (int)$row["totcostfl"];
                $baggagecost = (int)$row["baggagecost"];
                $itquoted = (int)$row["itquoted"];
                $ivquoted = (int)$row["ivquoted"];
                $roomtype = $row["roomtype"];

                // If itquoted is 0 then it is new itinerary ,else old itinerary
               
             




           } // End if 

        }// End of IF num rows for Itinerary inter   
 




        /* START OF PRINT WORK*/
         $sql = "SELECT * FROM hotels_inter WHERE ghrnno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                  
                  $hotecheckindate = $row["checkindate"];
                  $hotecheckoutdate = $row["checkoutdate"];

                  $hotels.="
                            <tr style='font-size:12px;'>
                            <td>".$row["hotel"]."</td>
                            <td>".$row["hotelstandard"]."</td>
                            <td>".$row["roomstandard"]."</td>
                            <td>".date_format(date_create($row["checkindate"]),"d-M-Y")."</td>
                            <td>".date_format(date_create($row["checkoutdate"]),"d-M-Y")."</td>
                        </tr>

                  ";


            }
        }
        /* END OF PRINT WORK*/
}
else
{

  $sql = "SELECT * FROM itinerary_domestic WHERE ghrnno = '$ref_value'";
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           if($row = $res->fetch_assoc()) 
           {  

                $calc_chosed_by  = $row["calc"];
                $no_of_pax  = $row["no_of_pax"];


                $totcost = (int)$row["totcost"];
                $totcostfl = (int)$row["totcostfl"];
                $baggagecost = (int)$row["baggagecost"];  

                $itquoted = (int)$row["itquoted"];
                $ivquoted = (int)$row["ivquoted"];

                //get the flight loading percentage
                $flightprice = (int)$row["flightprice"];
                $flight_loadperc = (int)$row["flight_loadperc"];
                (int)$flightloadedprice = ($flightprice * $flight_loadperc) / 100;
                


                $roomtype = $row["roomtype"];

                // If itquoted is 0 then it is new itinerary ,else old itinerary
          

           

           } // End if 

        }// End of IF num rows for Itinerary inter

        //$hotecheckindate = "";  

  $sql = "SELECT * FROM hotels_domestic WHERE ghrno = '$ref_value'";

        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                  $hotecheckindate = $row["checkindate"];
                  $hotecheckoutdate = $row["checkoutdate"];

                  $hotels.="
                            <tr style='font-size:12px;'>
                            <td>".$row["hotel"]."</td>
                            <td>".$row["hotelstandard"]."</td>
                            <td>".$row["roomstandard"]."</td>
                            <td>".$row["checkindate"]."</td>
                            <td>".$row["checkoutdate"]."</td>
                        </tr>

                  ";


            }
        }



}

/*

(ghrno,sno,airline,airport,arrdep,airdur,airdates,airtrav,airprice)

$'sno','$airline','$airport','$arrdep','$airdur','$airdates','$airtrav','$airprice')";

*/

$flightcontent = "";
$baggageweight = "";
$flightCount = 0;

        $sql = "SELECT * FROM flights_info WHERE ghrno = '".$ref_value."' ORDER BY sno";
                        
        $res = $conn->query($sql);
        if ($res->num_rows) 
        {     $fls = "yes";
              $flightCount = $res->num_rows;
              $addFlightLoading = $flightloadedprice/(int)$flightCount;
           while($row = $res->fetch_assoc()) 
           {
              
              $calcairtrav = (int)$row["airtrav"];
              $calcairprice = (int)$row["airprice"];
              //$flightloadingtobeadded = $flight_loadperc*;
              //$calcairprice = $calcairprice + $flightloadingtobeadded;
              //get the number of flights

              $calcairprice = $calcairprice + $addFlightLoading;

              $baggageweight = $row["baggageweight"];
              $baggageweightoneway = "";
              if($baggageweight!=""){
                $baggageweightoneway = "<td>".$row["baggageweight"]."</td>";
              }else{
                $baggageweightoneway = "";
              }

              $flighttype = $row["flighttype"];
              $airlinecheck = explode(',', $row["airline"]);

              if($flighttype == "return" && sizeof($airlinecheck) > 1){
                $airline = explode(',', $row["airline"]);
                $airport = explode(',',$row["airport"]);
                $arrdep = explode(',',$row["arrdep"]);
                $airdur = explode(',',$row["airdur"]);
                $airdates = explode(',', $row["airdates"]);
                $baggageweightreturn = "";
                if($baggageweight!=""){
                  //check if there's baggage weight field available
                $baggageweightreturn = "<td style='padding-top:3.5%;' rowspan='2'>".$row["baggageweight"]."</td>";
                }else{
                  $baggageweightreturn = "";
                }



                $flightcontent.= "<tr style='font-size:12px;text-align:center;'>
                                  <td>".$airline[0]."</td>
                                  <td>".$airport[0]."</td>
                                  <td>".$arrdep[0]."</td>
                                  <td>".$airdur[0]."</td>
                                  <td>".$airdates[0]."</td>
                                  <td style='padding-top:3.5%;' rowspan='2'> ".$calcairprice." for ".$calcairtrav." persons</td>
                                  ".$baggageweightreturn."
                              </tr><tr style='font-size:12px;'>
                                  <td>".$airline[1]."</td>
                                  <td>".$airport[1]."</td>
                                  <td>".$arrdep[1]."</td>
                                  <td>".$airdur[1]."</td>
                                  <td>".$airdates[1]."</td>
                                  
                                  
                              </tr>";

                              $flightCount++;

              }else{

             $flightcontent.= "<tr style='font-size:12px;text-align:center;'>
                                  <td>".$row["airline"]."</td>
                                  <td>".$row["airport"]."</td>
                                  <td>".$row["arrdep"]."</td>
                                  <td>".$row["airdur"]."</td>
                                  <td>".$row["airdates"]."</td>
                                  <td> ".$calcairprice." for ".$calcairtrav." persons</td>
                                  ".$baggageweightoneway."
                              </tr>";
              }

           }
        }
        else
        {
          $fls = "no";
        }      



  //intializing variables

    $pckg = "";
    $holiarea ="";
    $inclusion = "";
    $exclusion = "";
    $honeyincl = "";
    $search_image = "";

//making query
      $sql = "SELECT * from designdetails WHERE ghrno = '$ref_value'";

         if($conn->query($sql) == true)
      {
          //successfully executed 
        $res = $conn->query($sql) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                $pckg = $row["pckgtitle"];
                $holiarea = $pckg;
                $inclusion = $row["pckgincl"];
                $exclusion = $row["pckgexcl"];
                $honeyincl = $row["honeyincl"];
                $search_image = $row["imgname"];


            }
        }
      }


        //$holiarea =$_POST["holiarea"];
        //$pckg =$_POST["pckg"];
        //$holidesc =$_POST["holidesc"];
        $holidesc = "";
        //$inclusion =$_POST["inclusion"];
        //$exclusion =$_POST["exclusion"];

        //$honeyincl =$_POST["honeyincl"];
        //$roomtype =$_POST["roomtype"];
        $itpages ="";
        //$search_image = $_POST["search_image"]; // this is the imgname
        $imgdesc = ""; //empty description
        //use this to get the description from holiday_images
        $sqlToGetImgDesc = "SELECT imgdesc from holiday_images WHERE imgpath = '$search_image'";

        if($conn->query($sqlToGetImgDesc) == true)
      {
          //successfully executed sqlToGetImgDesc
        $res = $conn->query($sqlToGetImgDesc) ;
        if ($res->num_rows) 
        {     
           while($row = $res->fetch_assoc()) 
           {      
                  $imgdesc = $row["imgdesc"];
                  $holidesc = $imgdesc;

            }
        }
      }
        


     



    $sno=1;
    $count = 0;
    $date = array();

    $lastdate = "";
    $startdate = "";

    //get last date
    $sql = "SELECT date from itdaywise where ghrnno = '$ref_value' order by rowno desc LIMIT 1";

                          $res1 = $conn->query($sql) ;
                          if($res1->num_rows){
                            while($row = $res1->fetch_assoc()){
                              $lastdate = $row["date"];
                            }
                          }


//get start date
    $sql = "SELECT date from itdaywise where ghrnno = '$ref_value' order by rowno asc LIMIT 1";

    $res2 = $conn->query($sql) ;
    if($res2->num_rows){
      while($row = $res2->fetch_assoc()){
        $startdate = $row["date"];
      }
    }

     // Include code for inserting these day wise itinerary values in db for voucher issue

      $sql = "SELECT * FROM itdaywise WHERE ghrnno = '$ref_value' ORDER BY rowno";
       $res = $conn->query($sql) ;

       if ($res->num_rows) 
                    { 
                          //print_r($hotecheckindate);
                          //$row["date"];

                          


                          $begin = new DateTime("$startdate");
                          $end = new DateTime("$lastdate");

                          $interval = DateInterval::createFromDateString('1 day');
                          $period = new DatePeriod($begin, $interval, $end);

                          $i = 0;

                             foreach ( $period as $dt )
                           {        
                            $datecur = $dt;

                            $date[$i] = $dt->format( "d-m-Y" );
                            $i++;
                           }

                           //print_r($date);
                          
                           $i = 0;
                           $end = new DateTime("$lastdate");
                           $arraylen = sizeof($date);
                           $date[$arraylen] = date_format(date_create($hotecheckoutdate),"d-m-Y");

                       while($row = $res->fetch_assoc()) 
                          {  

                            //$row["day"];
                            //$hotecheckindate;

                            //$date[] = "";
                         
                            
                            $ittitle = $row["title"];
                            $ithotel = $row["hotelname"];
                            $itmeal = $row["mealplan"];
                            $itdesc = $row["description"];
                            //print_r($date);

                            if($date[$i] == $end){
                              $date[$i] = date_format(date_create($hotecheckoutdate),"d-M-Y");
                            }

                            $itpages .= " <div class='panel panel-default sche'>
                                                  <div class='panel-heading'>
                                                        <div class='row'>
                                                          <div class='col-md-3'>&nbsp;&nbsp;&nbsp;<strong>Day ".$sno." :</strong>".$date[$i]." </div>
                                                        </div> 
                                                  </div>
                                                  <div class='panel-body'>
                                                        
                                                        <div class='ro2w'>
                                                           <div class='col-md-3'><strong>".$ittitle."</strong></div>
                                                        
                                                         
                                                           <div class='col-md-3'><strong>".$ithotel."</strong></div>
                                                       
                                                        
                                                           <div class='col-md-3'><strong>".$itmeal."</strong></div>
                                                         
                                                        <br>
                                                    </div>
                                                        <div class='row'>
                                                            <div class='col-md-12'>
                                                              <br>
                                                              ".$itdesc."
                                                            </div>
                                                        </div>

                                                  </div>
                                        </div> "; 
                                        
                                        $sno++;
                                        $i++;
                                        



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

  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">


  <!--Script Tags-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> 


	<style>@import url('https://fonts.googleapis.com/css?family=Roboto|Source+Sans+Pro');</style>
<style type="text/css">
.* h1 h2 h3 h4 p div tr th table{
	padding: 0px;
	margin: 0px;
  font-family: 'Lato', sans-serif !important;
}

body h1 h2 h3 h4 p div tr th table{
  font-family: 'Lato', sans-serif !important;
}
.top_part
{
  position: absolute;
  top: 5px;
  left: 40px;
  width: 70%;
  font-family: 'Lato', sans-serif !important;
}
.logo
{
	position: absolute;
	right: 10px;
	top: 0px;
}
.sche{
	
	font-family: 'Lato', sans-serif;
}
.top_heading
{
	position:absolute;
	top: -20px;
	left:20px;
	width: 300px;
  font-family: 'Lato', sans-serif;
  font-family: 'Lato', sans-serif !important;
}
.content
{
	position: absolute;
	top: 470px;
	left: 50px;
	font-family: 'Lato', sans-serif; 


}
tr
{
	height: 40px;
  font-family: 'Lato', sans-serif !important;
}
.table1
{
	position: absolute;
	left: 100px;
  font-family: 'Lato', sans-serif !important;
}
.top_section
{	
	position: absolute;
	top: 60px;
	float: left;
  font-family: 'Lato', sans-serif !important;

}
.bot_travel
{	position: absolute;
	top: 900px;
  left: 50px;
  padding-right: 100px;
	height: 100px;
	width: 100%;
  font-family: 'Lato', sans-serif !important;
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
  font-family: 'Lato', sans-serif !important;
}
.ithead
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 250px;
  font-family: 'Lato', sans-serif !important;
}
.ithotel
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 250px;
  font-family: 'Lato', sans-serif !important;
}
.itmeal
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 150px;
  font-family: 'Lato', sans-serif !important;
}
.itdate
{
  float: left;
  height: 30px;
  padding-left: 10px;
  width: 150px;
  font-family: 'Lato', sans-serif !important;
}
.ptyp{
	font-size:20px;
	text-align:center;
	color:white;
	font-family: 'Lato', sans-serif !important;
}
#t_box{
padding:10px;
}
</style>

</head>


<body>

<!--<div class='top_part'>
  <b style='padding-left:25px;'>RIGHT NOW</b> &nbsp;&nbsp;&nbsp;INDIA
<?php
    date_default_timezone_set('Asia/Kolkata');
    echo "<b style='font-size:26px;'>" . date("h:i A")."</b>&nbsp;&nbsp;&nbsp;&nbsp;".date("d-m-Y")."";
  ?>
</div>
-->
<div class='logo'>

<img src="../images/logo_1.png" width='auto' height='50'>
</div>
<div>
	<?php
	session_start();
	$ref_value=$_GET["q"];
	$sql_p_type = "SELECT p_type FROM agent_form_data WHERE ref_num = '".$ref_value."'";
	$res_p_type = $conn->query($sql_p_type);
	if($res_p_type->num_rows){
		if($row_p_type = $res_p_type->fetch_assoc()){
			$p_type = $row_p_type["p_type"];
			if($p_type == "Budget"){
			  $clr = "red";
			}
			elseif($p_type == "Standard"){
				$clr = "blue";
			}
			elseif($p_type == "Luxury"){
				 $clr = "green";
			}
		}
	}
	echo"<p class = 'ptyp'><span id = 't_box' style = 'background-color: ".$clr.";'>".$p_type." Package</span></p>";
	?>
	
</div>
<div class='holipic'>
	<br><br>
	<?php echo "<img src='../stuff/".$search_image."' width='550' height='auto'>";?>
</div>

<div class='top_section'>
<div class='top_heading'>
    <h4>Travel Itinerary<br>
      <br><?php echo "$holiarea";?>:</h4>

  <p style='width:200px;'> <?php echo "$holidesc";?> 
  </p>

</div>


</div>
<br><br><br>
<div class='content'>
	<table class='table table-responsive' style='border:none;background-color: white;'>
               <tr>
                     <th style='width:400px;'>CLIENT NAME</th>
                     <td><?php echo "$clientname";?></td>
               </tr>
               <tr>
                     <th style='width:400px;'>NUMBER OF TRAVELLERS</th>
                     <td><?php echo "$nooftrav";?></td>
               </tr>  
               <tr>
                     <th style='width:400px;'>ITINERARY REFERENCE</th>
                     <td><?php $ref_str= 5000+$ref_value;
                     echo "GHRN$ref_str";?></td>
               </tr>
                <tr>
                     <th style='width:400px;'>HOLIDAY FROM</th>
                     <th>HOLIDAY TO</th>
               </tr>

               <tr>
                  	<td style='width:400px;'><?php echo "$travel_from";?></td>
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

                <tr>
                  	<td style='width:400px;'>PACKAGE HIGHLIGHTS</td>
                    <td style='width:300px;'><?php echo "$pckg";?>
                    </td>
               </tr>
               <tr>
                    <td style='width:400px;'>TRAVEL MANAGER</td>
                    <td style='width:300px;'><?php echo strtoupper($emp_name);?>
                    </td>
               </tr>

               <tr>
                    <td style='width:400px;'>PHONE NUMBER</td>
                    <td style='width:300px;'><?php echo $emp_contact;?>
                    </td>
               </tr>
				
	</table>

<?php //echo "<br><b style='font-size:15px;'>TRAVEL MANAGER - ".strtoupper($emp_name)."<br>CONTACT - $emp_contact<br><b>";?>

</div>

<div class='bot_travel'>
	<p style="text-align: center;">We thank you for giving us an opportunity to be your holiday service provider. We are commited to make your holiday fun filled with a hassle free experience. Below is your Itinerary.</p>
  <br>
  <h4 style='text-align:center;'>GOGAGA HOLIDAYS PRIVATE LIMITED<br><br>HYDERABAD</h4>
</div>

<br><br>



<br><br>
<div class='second_page'>

  <br>
  <h2 style='text-align:center;'>SCHEDULED ITINERARY</h2>
  <br>
    <p class = 'it_main'>
     <?php 
        echo "$itpages";

     ?> 
	</p>
  

  <br>
  <h2 style='text-align:center;'>ACCOMODATION DETAILS</h2>
  <br>
  
   <table class='table table-responsive' style='border:none;background-color: white;'>
      <tr>
      
        <td class='it_main'>NUMBER OF TRAVELLERS</td>
          <td></td>
        <td class='it_main'><?php echo "$nooftrav";?></td>
        
      </tr>
      <tr>
       
        <td class='it_main'>NUMBER OF ROOMS</td>
         <td></td>
        <td class='it_main'><?php echo "$no_rooms";?></td>
       
      </tr> 
      <tr>
       
        <td class='it_main'>SHARING TYPE</td>
         <td></td>  
        <td class='it_main'><?php echo "$s_type";?></td>
        
      </tr>
  </table>
  <br>
  <h2 style='text-align:center;'>HOTEL DETAILS</h2>
  <br>
     <table class='table table-responsive' style='border:none;background-color: white;'>
      <tr style='font-size:12px;'>
          <th>HOTEL NAME</th>
          <th>HOTEL STANDARD</th>
          <th>ROOM STANDARD</th>
          <th>CHECKIN DATE</th>
          <th>CHECKOUT DATE</th>
      </tr>
      <?php echo "$hotels";?>
  </table>
   <br>



  <h2 style='text-align:center;'>PACKAGE INCLUSIONS AND EXCLUSIONS</h2>
  <br>
 <table class='table table-responsive' style='border:none;background-color: white;text-align: center;'>

    <tr>
      <th style="text-align: center;">INCLUSIONS</th>
    </tr>
    <tr>
        <td>
            <?php echo "$inclusion";?>
        </td>
    </tr>
    <tr>
      <th style="text-align: center;">EXCLUSIONS</th>
    </tr>
    <tr>
        <td>
            <?php echo "$exclusion";?>  
        </td>
    </tr>
    <?php
        if(!empty($honeyincl))
        {
    ?>
    <tr>
      <th style="text-align: center;">HONEYMOON INCLUSIONS</th>
    </tr>
    <tr>
        <td>
            <?php echo "$honeyincl";?>  
        </td>
    </tr>
    <?php
       }
    ?>

 </table>

<br>
<?php

  if($fls=="yes" && $calcairprice != "0")
  {
?>
  <h2 style='text-align:center;'>FLIGHT DETAILS</h2>
  <br>
   
     <table class='table table-responsive' style='border:none;background-color: white;'>
       <tr style='font-size:12px;'>
          <th style='text-align:center;'>AIRLINES</th>
          <th style='text-align:center;'>AIRPORTS</th>
          <th style='text-align:center;'>ARRIVAL AND DEPARTURE</th>
          <th style='text-align:center;'>DURATION</th>
          <th style='text-align:center;'>DATES</th>
          <th style='text-align:center;'>PRICE</th>
          <?php
          if($baggageweight!=""){
            echo "<th>BAGGAGE</th>";
          }
          ?>

          
      </tr>

      <?php echo "$flightcontent";?>

  </table>

<br>
<?php
  }
?>
  <h2 style='text-align:center;'>PACKAGE COST</h2>
  <br>

<table class='table table-responsive' style='border:none;background-color: white;'>


<?php
$ref_value=$_GET["q"];
  if($calc_chosed_by == "By Person")
  {
	 $sql_pax = "SELECT * FROM agent_form_data WHERE ref_num = '$ref_value'";
	$res = $conn->query($sql_pax);
	if ($res->num_rows){
		if ($row = $res->fetch_assoc()){
			$adults = $row["no_of_adults"];
			$child = $row["no_of_childs"];
			$infants = $row["no_of_infants"];
		}
	}
	$tot_pax = (int)$adults + (int)child + (int)infants;
	$tot_pax = (int)$tot_pax;
	
    $totcost = $totcost / $tot_pax;
	$totcost = (int)$totcost;
    $totcostfl = $totcostfl / $tot_pax;
  }

if($calc_chosed_by == "By Person")
  {
?>
    <tr>
      <th>LAND PACKAGE COST PER PERSON</th>
      <td><?php echo "$totcost";?> INR</td>
    </tr>
<?php
  }
  else
  {
  ?>
     <tr>
      <th>LAND PACKAGE COST</th>
      <td><?php echo "$totcost";?> INR</td>
    </tr>

<?php
  }
                //$calc_chosed_by  = $row["calc"];
  if($fls=="yes" && $calcairprice != "0")
  {
    $fl_cost = (float)$totcostfl - (float)$totcost;
    $fl_cost = (int)$fl_cost;


if($calc_chosed_by == "By Person")
  {
?>

    <tr>
      <th>FLIGHT COST PER PERSON</th>
      <td><?php echo "$fl_cost";?> INR</td>
    </tr>

    <?php
    if($baggagecost!=""||0){
    echo "<tr>
      <th style='font-size: 10px;'>INCLUSIVE OF BAGGAGE COST</th>

      <td style='font-size: 11px;'>".$baggagecost." INR</td>
    </tr>";
}
?>
<?php
    $service_content = "";
 $sql = "SELECT * FROM additional_prices WHERE ghrno = '$ref_value' ORDER BY sno";

                $res = $conn->query($sql) ;
                if ($res->num_rows) 
                {    
                  //there's data.. so print it in rows
                   while($row = $res->fetch_assoc()) 
                   {  
                          
                    $servicename = $row["servicename"];
                    $serviceprice = $row["serviceprice"];
                     if($serviceprice!=""||0){
                    $service_content.=" <tr>
                                          <th>".$servicename."</th>  
                                          <td>".$serviceprice."INR</td>
                                        </tr>";
                    }

                   }

                }else{
                  //no data.. just print one empty row
                  
                }
                    

    if($service_content){
                    echo $service_content;
                  } ?>

                   <tr>
      <th>TOTAL PACKAGE COST INCLUDING FLIGHTS PER PERSON</th>  
      <td><?php echo "$totcostfl";?> INR</td>
    </tr>
<?php
  }
else
{
  ?>

    <tr>
      <th>FLIGHT COST</th>
      <td><?php echo "$fl_cost";?> INR</td>
    </tr>

    <?php
    //if baggage cost in available then dont show
    if($baggagecost!=""||0){
      echo "<tr>
          <th style='font-size: 10px;'>INCLUSIVE OF BAGGAGE COST</th>
          <td style='font-size: 11px;'>".$baggagecost." INR</td>
        </tr>";
    }
    ?>
  

  

  <?php
    $service_content = "";
 $sql = "SELECT * FROM additional_prices WHERE ghrno = '$ref_value' ORDER BY sno";

                $res = $conn->query($sql) ;
                if ($res->num_rows) 
                {    
                  //there's data.. so print it in rows
                   while($row = $res->fetch_assoc()) 
                   {  
                          
                    $servicename = $row["servicename"];
                    $serviceprice = $row["serviceprice"];

                    if($serviceprice!=""||0){
                    $service_content.=" <tr>
                                          <th>".$servicename."</th>  
                                          <td>".$serviceprice."INR</td>
                                        </tr>";
                       }
                   }

                }else{
                  //no data.. just print one empty row
                  
                }
                    

    if($service_content){
                    echo $service_content;
                  }

?>
  <tr>
      <th>TOTAL PACKAGE COST INCLUDING FLIGHTS</th>  
      <td><?php echo "$totcostfl";?> INR</td>
    </tr>


<?php 
}

}
?>




 </table>

 <br><br>
<h6 style='text-align:center;'>Looking forward for your revert which gives us an oppurtunity to make your holiday experience memorable</h6>

<img src="../stuff/bottompic.png"  width='100%' height='auto'>
<br><br>

<div class='col-md-12'>
  <br><br>

   <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong>IMPORTANT DEFINITIONS </strong></div>
                      </div> 
                </div>
                <div class="panel-body">
                    <strong style='color:red;'>Private Transfers:</strong><br>
           A private transfer is a taxi or other vehicle reserved solely for your party. Private transfers will be waiting for you on arrival to the destination airport, and will take you directly to your hotel or apartment, without any stops on route.
            <br><br>
            <strong style='color:red;'>SIC Transfers :</strong><br>
            SIC Transfers: SIC tours stands for Seat-in-Coach Basis Tours, which means you will share a coach or van with other tourists and you will be taken to all the scenic spots listed in the Itinerary that day.
           

                </div>
              </div>



      <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong>IMPORTANT NOTES </strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>
                            Please note any rescheduling, Cancellation, Amendments from Airlines, Any Corrections are subjected to Your Choosen Airlines policies. Gogaga Holidays will not hold any responsibility in regards to any above mentioned corrections.
                    <br><br>
                    Once Itinerary Vouchered, We cannot allow any corrections and Changes in the Itinerary, So we request you to go through the itinerary before confirmation. We also request you to check the Hotel room Standards, Star ratings and Reviews of the hotel, Services from your end through online before Confirming the Package. We recommend hotel on the basis of feedbacks received from our existing customers. 
                    <br><br>
                    On Confirmation all the travellers should follow the timings as per the Holiday Vouchers, and any  delay or no show in transfers the company will not hold and responsibility.
                    <br><br>
                    For any Public Holidays, Natural Calamaties, Sudden unexpected Government Decessions the company will not hold responsible for Sightseeings and transfers.

                </div>
      </div>


          <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp;<strong>TERMS AND CONDITIONS</strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>
                     <div class='row' style='padding:10px;'>Flight cancellation charges will depend on Airlines . INR 500/- Per Person will be applicable extra as Gogaga Holidays service fee. In case the name provided by the customer to book any ticket / hotel is not as per the passport, the customer will bear the charges for changing the name. We strongly recommend to mail us a scanned copy of passport before booking a ticket / hotel.  
                  </div>
                   <div class='row' style='padding:10px;'>Any flight cancellation / rescheduling / departure delay  or any changes in flights is purely subject to airlines management discussion . Any charges in airfare increase / decrease   rescheduling  is to be borne by the client as Gogaga Holidays do not hold any guarantee on Same.            
                  </div>
                    <div class='row' style='padding:10px;'> Final handover of Hotel vouchers / Air tickets / Visa etc. will be done only upon receiving full and final payment.
                  </div>
                    <div class='row' style='padding:10px;'> Universal hotel check-in time is between 1400 hrs-1500 hrs and check- out time is between 1100 hrs-1200 hrs depending upon the property. Early Check-In & Late Check- Out is subject to availability of room, it depends on hotel. Early Check in and late checkout will be at additional cost and subject to availability and complete discretion of the hotel. Hotel may or may not provide early check in or late checkout irrespective of availability. Gogaga Holidays Pvt. Ltd will not be responsible for any change in the policy of the hotel at any given time.
                  </div>
                    <div class='row' style='padding:10px;'> Gogaga Holidays Pvt. Ltd does not guarantee quality of service of the hotel and star rating of the hotel. We only recommend hotels basis their reviews and ratings placed on internet by the customers and our previous customer experience. Once a hotel is booked, the booking can be changed basis the cancelation policy of the hotel as well as Gogaga Holidays. We strongly recommend our customers to go through reviews and photographs of the hotels before making a booking.
                  </div>
                    <div class='row' style='padding:10px;'> All our packages are based on Night basis and the last day is for check out which will be as per the hotel policy. Gogaga Holidays will not be responsible for any extension of stay in the hotel unless explicitly approved in writing by Gogaga Holidays.
                  </div>
                     <div class='row' style='padding:10px;'>In case of any payment made on the online link through the Net Banking, credit or debit cards there will be a transaction charge of 2.5% of the total booking amount. In case of American Express Card the charges will be 6%.  This amount is completely non-refundable in case of ANY/ALL cancellations, refunds etc. at any given point of time. This payment gateway charges will be deducted from the refund amount unless there is a waiver commitment from Gogaga Holidays in writing. We strongly recommend all our customers to take all the details in writing through our official id.
                  </div>
                      <div class='row' style='padding:10px;'> The airfares and taxes are calculated as on a mentioned date and time and any increase in the taxes or airfares will be borne by the customer.                          
                  </div>
                    <div class='row' style='padding:10px;'>Grant of on Arrival visa depends on sole discretion of Immigration Authority and Gogaga Holidays is not responsible for any non grant of Visa to traveler. In case the immigration does not provide Visa on Arrival for any reason, the Cancelation policy of Gogaga Holidays Pvt. Ltd. will stand as it is.                         
                  </div>
                     <div class='row' style='padding:10px;'>Kindly avoid being Over drunk by intake of hard drinks during the flights to avoid any Inconvenience during Visa on Arrival, Immigration and Custom Process.                          
                    </div>
                   <div class='row' style='padding:10px;'>Passport copies are mandatory to send at the time of confirming the Booking & passport should be valid for minimum 6 months from the date of departure from destination.                          
                    </div> <div class='row' style='padding:10px;'>After confirmation of services, if any one wish to change your travel arrangements in any way, for example your chosen departure date or accommodation, we will do our utmost to make these changes but it may not always be possible. Any request for changes to be made must be in writing from the person who made the booking. All cost incurred due to amendment will be borne by yourself.                          
                    </div> <div class='row' style='padding:10px;'>You, or any member of your party, may cancel their travel arrangements at any time. Written notification or an e-mail to that effect from the person who made the booking must be received at our offices. The applicable cancellation charges are as per the published cancellation policy which is: Cancellation charges per person                         
                    </div> <div class='row' style='padding:10px;'>All the sightseeing tours and excursions are organized by local companies. The timings and days of operation are subject to alteration. Changes if any will be intimated at the time of booking.                          
                   </div> <div class='row'style='padding:10px;'> Sightseeing’s tours are strictly based on weather conditions and also local service providers have rights to cancel the sightseeing tours without prior notice.                         
                   </div>  <div class='row' style='padding:10px;'>Gogaga Holidays will not be responsible for any natural phenomenon like flight delay / cancellation due to fog / rain, flood in a respective country, Traffic Jams or any such situation where one doesn’t have a control.                          
                    </div>
                </div>
              </div>



      <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp;  <strong>CANCELLATION POLICY </strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>
                          
                          <p>Applicable on land Package</p>                          
                          <p>If you wants to cancel your booking, you must notify us in writing.</p>                         
                        <p>  No cancellation or changes are allowed after departure.  </p>                       
                          <p>Cancellations are subject to the following charges:</p>                         
                         <p> Up to 60 days prior to departure     : 40%   </p>                       
                          <p>59-46 days prior to departure        : 75%  </p>                        
                          <p>45-31 days prior to departure        : 80%     </p>                     
                          <p>30 days prior to departure             : 100%   </p>                      
                          <p>Surcharges on Christmas and New Year period. Few destinations which overrules the below policy and come under 100% cancellation.</p>                          
                          <p>Cancellations are subject to the following charges: </p>                        
                          <p>Up to 60 days prior to departure     : 75%    </p>                      
                          <p>59-46 days prior to departure        : 80%   </p>                       
                          <p>45-0 days prior to departure          : 100%  </p>                        
                                                    
                          <p>Applicable on Flights    </p>                     
                          <p>As per Airlines Terms and Conditions    </p>                      
      
                </div>
      </div>  

      <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong> PAYMENT AND PRICING </strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>

                  <p>The price of your holiday has been quoted in both USD / SGD and INR. Since these prices are subject to currency fluctuations – the higher of the two will be charged at the time of completion payment for your booking.                          
                  </p></p>We urge our esteemed customers to make the complete payment at the time of booking to avoid any charges arising out of fluctuations.                          
                  </p></p>In case of part payments, Gogaga Holidays.com reserves all rights to charge the higher value applicable as per the quote, till the time final payment does comes in                         
                  </p></p>We reserve the right to cancel your booking in case full and final payment is not made at the time of booking and later USD / SGD rate fluctuates . To avoid such situations, please make full and final payment at the time of booking.                          
                 </p>
                                            
                </div>
      </div>  

     
      <div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp;<strong>PAYMENT BY CREDIT CARDS</strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>

                    Your verbal authorization, given to your Travel Agent, for the use of your credit card indicates your compliance with our booking conditions and confirm your reservation whether or not you have actually signed the appropriate authorization form. In the case where the traveler pays with a third person credit card, a written proof of consent must be provided. Once a credit card has been forwarded to Gogaga Holidays to guarantee a reservation, the travel agent becomes responsible for payment and must keep a signed copy of the customer's authorization on file. In the event that a cardholder refuses to honor a charge due to the absence of signature, the Travel Agent will be held responsible for full payment of the services.                          

                            
                </div>
      </div>  
<div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp; <strong> KNOW YOUR CUSTOMER</strong></div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>
 <p>As per RBI Guidelines, for any international booking being made, Gogaga Holidays.com will need a copy of passport of all the passengers travelling to the destination                           
  </p><p>Travel Insurance: We strongly recommend customers to purchase travel insurance that covers the risks associated with travelling to a foreign country such as emergency medical assistance and hospitalization as well as cancellations coverage and lost baggage. Consult with your Travel Agent for the plan best suited to your needs.                          
 </p><p> During the period of traveling, any loss or damage caused to the customer, shall be the sole responsibility of the customer only in case the insurance is not done. In case the insurance is done then Insurance company is solely responsible for any such loss. Gogaga Holidays Pvt Ltd shall NOT be responsible for any loss or damage caused to the customer while traveling even if Gogaga Holidays has been instrumental in providing insurance to the customer through insurance company.                          
 </p><p> In the event of any dispute, the dispute shall be referred to the sole arbitrator to be appointed by Gogaga Holidays pvt Ltd in Hyderabad and the matter shall be subjected to the jurisdiction of Hyderabad Courts only.                           
</p>
                            
                </div>
      </div>  

<div class="panel panel-default">
                <div class="panel-heading">
                      <div class='row'>
                        <div class='col-md-3'>&nbsp;  <strong>PAYMENTS</strong> </div>
                      </div> 
                </div>
                <div class="panel-body" style='font-size:12px;'>

                    <p>Below Link will take you to our payment gateway                         
                    </p><p><a href="https://www.payumoney.com/paybypayumoney/#/7E497F48689CF72B7A73585C8F750CB8">PAYMENT GATEWAY LINK</a>                          
                           </p><p>                   
                    </p><p>We accept all credit cards and please note there will be an additional charge of 2.9% on all Master & Visa Credit Cards. For all other cards we charge 5%.                          
                          </p><p>                    
                    </p><p>Bank Details         :For Cash/ Cheque /NEFT                          
                    </p><p>Bank Name          : ICICI BANK Ltd.                          
                   </p><p> Account Name      : GOGAGA HOLIDAYS  PVT. LTD.                          
                    </p><p>Account Number   : 630805158633                         
                    </p><p>IFSC Code           : ICIC0006308                         
                    </p><p>Branch Address    : Kharkana, Secunderabad                          
                      </p>
                            
                </div>
      </div>  


</div>

</div>




</body>
<script type="text/javascript">


/*$(document).ready(function(){

    window.print();


});
*/




</script>
</html>
