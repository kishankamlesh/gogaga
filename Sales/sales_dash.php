<?php
$conn = mysqli_connect('localhost', 'root', '','gogaga')or die('Not connected : Ah sh*t ' . mysqli_connect_error());
session_start();
if(!(isset($_SESSION["userid"]))){
  header('Location:login.html');
}
else{
  $d_name = $_SESSION["d_name"];
  $user_id = $_SESSION["userid"];
  $sno = $_SESSION["sno"];
}
$sql_m_type = "SELECT * FROM managers_data WHERE sno = '".$sno."'";
$res_m_type = $conn->query($sql_m_type);
if($res_m_type->num_rows){
  if($row_m_type = $res_m_type->fetch_assoc()){
    $m_type = $row_m_type["type"];
  }
}
$pen_iti = 0;
$rec_iti = 0;
$cnf_iti = 0;
$vol_conv = 0;
$curr_m = date("m");
$curr_y = date("Y");
switch($m_type){
  case "salesmanager":

  //salespartners forms

  $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
  $res_sp = $conn->query($sql_sp);
  if($res_sp->num_rows){
    while($row_sp = $res_sp->fetch_assoc()){
      //sno of the salespartenr
      $sno_sp = $row_sp["sno"];
      //pending forms
      $sql_pen_sp = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$sno_sp."'";
      $res_pen_sp = $conn->query($sql_pen_sp);
      if($res_pen_sp->num_rows){
        while($row_pen_sp = $res_pen_sp->fetch_assoc()){
          $sent_date = $row_pen_sp["datesent"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$pen_iti;
          }
        }
      }
      //recieved
      $sql_rec_sp = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$sno_sp."'";
      $res_rec_sp = $conn->query($sql_rec_sp);
      if($res_rec_sp->num_rows){
        while($row_rec_sp = $res_rec_sp->fetch_assoc()){
          $rec_date = $row_rec_sp["senttocustomerdate"];
          $rec_m = date("m", strtotime($rec_date));
          $rec_y = date("Y", strtotime($rec_date));
          if(($rec_m == $curr_m) && ($rec_y == $curr_y)){
            ++$rec_iti;
          }
        }
      }
      //confirmed
      $sql_cnf_sp = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sno."'";
      $res_cnf_sp = $conn->query($sql_cnf_sp);
      if($res_cnf_sp->num_rows){
        while($row_cnf_sp = $res_cnf_sp->fetch_assoc()){
          $cnf_date = $row_cnf_sp["confirmeddate"];
          $cnf_m = date("m", strtotime($cnf_date));
          $cnf_y = date("Y", strtotime($cnf_date));
          if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
            ++$cnf_iti;
          }
        }
      }
    }
  }


  //holidaypartner forms
  $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    if($row_sm = $res_sm->fetch_assoc()){
      //holiday partner sno
      $hp_sno = $row_sm["hp_sno"];
      //pending forms
      $sql_pen_hp = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$hp_sno."'";
      $res_pen_hp = $conn->query($sql_pen_hp);
      if($res_pen_hp->num_rows){
        while($row_pen_hp = $res_pen_hp->fetch_assoc()){
          $sent_date = $row_pen_hp["datesent"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$pen_iti;
          }
        }
      }
      //recieved
      $sql_rec_hp = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$hp_sno."'";
      $res_rec_hp = $conn->query($sql_rec_hp);
      if($res_rec_hp->num_rows){
        while($row_rec_hp = $res_rec_hp->fetch_assoc()){
          $sent_date = $row_rec_hp["senttocustomerdate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$rec_iti;
          }
        }
      }
      //confirmed
      $sql_cnf_hp = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$hp_sno."'";
      $res_cnf_hp = $conn->query($sql_cnf_hp);
      if($res_cnf_hp->num_rows){
        while($row_cnf_hp = $res_cnf_hp->fetch_assoc()){
          $sent_date = $row_cnf_hp["confirmeddate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$cnf_iti;
          }
        }
      }
    }
  }

  //superpartner forms
  $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    if($row_sm = $res_sm->fetch_assoc()){
    //holiday partner sno
    $hp_sno = $row_sm["hp_sno"];
    $sql_sup = "SELECT * FROM holidaypartners WHERE sno = '".$hp_sno."'";
    $res_sup = $conn->query($sql_sup);
    if($res_sup->num_rows){
      if($row_sup = $res_sup->fetch_assoc()){
        //super partner's id
        $sup_id = $row_sup["super_partner_sno"];
        //pending
        $sql_pen_sup = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$sup_id."'";
        $res_pen_sup = $conn->query($sql_pen_sup);
        if($res_pen_sup->num_rows){
          while($row_pen_sup = $res_pen_sup->fetch_assoc()){
            $sent_date = $row_pen_sup["datesent"];
            $sent_m = date("m", strtotime($sent_date));
            $sent_y = date("Y", strtotime($sent_date));

            if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
              ++$pen_iti;
            }
          }
        }
        //recieved
        $sql_rec_sup = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$sup_id."'";
        $res_rec_sup = $conn->query($sql_rec_sup);
        if($res_rec_sup->num_rows){
          while($row_rec_sup = $res_rec_sup->fetch_assoc()){
            $sent_date = $row_rec_sup["senttocustomerdate"];
            $sent_m = date("m", strtotime($sent_date));
            $sent_y = date("Y", strtotime($sent_date));

            if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
              ++$rec_iti;
            }
          }
        }
        //confirmed
        $sql_cnf_sup = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sup_id."'";
        $res_cnf_sup = $conn->query($sql_cnf_sup);
        if($res_cnf_sup->num_rows){
          while($row_cnf_sup = $res_cnf_sup->fetch_assoc()){
            $sent_date = $row_cnf_sup["confirmeddate"];
            $sent_m = date("m", strtotime($sent_date));
            $sent_y = date("Y", strtotime($sent_date));

            if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
              ++$cnf_iti;
            }
          }
        }
      }
    }
  }
  }
  break;
  case "areamanager":
  //salespartners forms
  $sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    while($row_sm = $res_sm->fetch_assoc()){
		    $sm_id = $row_sm["sno"];
		    $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sm_id."'";
		    $res_sp = $conn->query($sql_sp);
		    if($res_sp->num_rows){
          while($row_sp = $res_sp->fetch_assoc()){
            //sales Partner sno
            $sno_sp = $row_sp["sno"];
            //pending
            $sql_pen_sp = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$sno_sp."'";
            $res_pen_sp = $conn->query($sql_pen_sp);
            if($res_pen_sp->num_rows){
              while($row_pen_sp = $res_pen_sp->fetch_assoc()){
                $sent_date = $row_pen_sp["datesent"];
                $sent_m = date("m", strtotime($sent_date));
                $sent_y = date("Y", strtotime($sent_date));

                if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
                  ++$pen_iti;
                }
              }
            }
            //recieved
            $sql_rec_sp = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$sno_sp."'";
            $res_rec_sp = $conn->query($sql_rec_sp);
            if($res_rec_sp->num_rows){
              while($row_rec_sp = $res_rec_sp->fetch_assoc()){
                $rec_date = $row_rec_sp["senttocustomerdate"];
                $rec_m = date("m", strtotime($rec_date));
                $rec_y = date("Y", strtotime($rec_date));
                if(($rec_m == $curr_m) && ($rec_y == $curr_y)){
                  ++$rec_iti;
                }
              }
            }
            //confirmed
            $sql_cnf_sp = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sno."'";
            $res_cnf_sp = $conn->query($sql_cnf_sp);
            if($res_cnf_sp->num_rows){
              while($row_cnf_sp = $res_cnf_sp->fetch_assoc()){
                $cnf_date = $row_cnf_sp["confirmeddate"];
                $cnf_m = date("m", strtotime($cnf_date));
                $cnf_y = date("Y", strtotime($cnf_date));
                if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
                  ++$cnf_iti;
                }
              }
            }
          }
        }
    }
  }
  //holidaypartner forms
  $sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
  $res_hp = $conn->query($sql_hp);
  if($res_hp->num_rows){
    while($row_hp = $res_hp->fetch_assoc()){
      //holiday partner's id
      $hp_sno = $row_hp["sno"];
      //pending
      $sql_pen_hp = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$hp_sno."'";
      $res_pen_hp = $conn->query($sql_pen_hp);
      if($res_pen_hp->num_rows){
        while($row_pen_hp = $res_pen_hp->fetch_assoc()){
          $sent_date = $row_pen_hp["datesent"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$pen_iti;
          }
        }
      }
      //recieved
      $sql_rec_hp = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$hp_sno."'";
      $res_rec_hp = $conn->query($sql_rec_hp);
      if($res_rec_hp->num_rows){
        while($row_rec_hp = $res_rec_hp->fetch_assoc()){
          $sent_date = $row_rec_hp["senttocustomerdate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$rec_iti;
          }
        }
      }
      //confirmed
      $sql_cnf_hp = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$hp_sno."'";
      $res_cnf_hp = $conn->query($sql_cnf_hp);
      if($res_cnf_hp->num_rows){
        while($row_cnf_hp = $res_cnf_hp->fetch_assoc()){
          $sent_date = $row_cnf_hp["confirmeddate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$cnf_iti;
          }
        }
      }
    }
  }
  //superpartner forms
  $sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
  $res_hp = $conn->query($sql_hp);
  if($res_hp->num_rows){
  	if($row_hp = $res_hp->fetch_assoc()){
  		$sup_id = $row_hp["super_partner_sno"];
      //pending
      $sql_pen_sup = "SELECT datesent FROM agent_form_data WHERE formstatus = 'pending' AND sales_partner_name = '".$sup_id."'";
      $res_pen_sup = $conn->query($sql_pen_sup);
      if($res_pen_sup->num_rows){
        while($row_pen_sup = $res_pen_sup->fetch_assoc()){
          $sent_date = $row_pen_sup["datesent"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$pen_iti;
          }
        }
      }
      //recieved
      $sql_rec_sup = "SELECT senttocustomerdate FROM agent_form_data WHERE formstatus = 'submitted' AND sales_partner_name = '".$sup_id."'";
      $res_rec_sup = $conn->query($sql_rec_sup);
      if($res_rec_sup->num_rows){
        while($row_rec_sup = $res_rec_sup->fetch_assoc()){
          $sent_date = $row_rec_sup["senttocustomerdate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$rec_iti;
          }
        }
      }
      //confirmed
      $sql_cnf_sup = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sup_id."'";
      $res_cnf_sup = $conn->query($sql_cnf_sup);
      if($res_cnf_sup->num_rows){
        while($row_cnf_sup = $res_cnf_sup->fetch_assoc()){
          $sent_date = $row_cnf_sup["confirmeddate"];
          $sent_m = date("m", strtotime($sent_date));
          $sent_y = date("Y", strtotime($sent_date));

          if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
            ++$cnf_iti;
          }
        }
      }
  	}
  }
  break;
  case "regionalmanager":
  $sql_pen = "SELECT datesent  FROM agent_form_data WHERE formstatus = 'pending'";
  $res_pen = $conn->query($sql_pen);
  if($res_pen->num_rows){
    while($row_pen = $res_pen->fetch_assoc()){
      $sent_date = $row_pen["datesent"];
      $sent_m = date("m", strtotime($sent_date));
      $sent_y = date("Y", strtotime($sent_date));

      if(($sent_m == $curr_m) && ($sent_y == $curr_y)){
        ++$pen_iti;
      }
    }
  }
  $sql_rec = "SELECT senttocustomerdate  FROM agent_form_data WHERE formstatus = 'submitted'";
  $res_rec = $conn->query($sql_rec);
  if($res_rec->num_rows){
    while($row_rec = $res_rec->fetch_assoc()){
      $rec_date = $row_rec["senttocustomerdate"];
      $rec_m = date("m", strtotime($rec_date));
      $rec_y = date("Y", strtotime($rec_date));

      if(($rec_m == $curr_m) && ($rec_y == $curr_y)){
        ++$rec_iti;
      }
    }
  }
  $sql_cnf = "SELECT confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed'";
  $res_cnf = $conn->query($sql_cnf);
  if($res_cnf->num_rows){
    while($row_cnf = $res_cnf->fetch_assoc()){
      $cnf_date = $row_cnf["confirmeddate"];
      $cnf_m = date("m", strtotime($cnf_date));
      $cnf_y = date("Y", strtotime($cnf_date));
      if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
        ++$cnf_iti;
      }
    }
  }
  break;
}
//total volume conversion Logic

switch($m_type){
  case "salesmanager":
  $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
  $res_sp = $conn->query($sql_sp);
  if($res_sp->num_rows){
    while($row_sp = $res_sp->fetch_assoc()){
      //sno of the salespartenr
      $sno_sp = $row_sp["sno"];
      $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sno_sp."'";
      $res_cnf = $conn->query($sql_cnf);
      if($res_cnf->num_rows){
        while($row_cnf = $res_cnf->fetch_assoc()){
          $cnf_date = $row_cnf["confirmeddate"];
          $cnf_m = date("m", strtotime($cnf_date));
          $cnf_y = date("Y", strtotime($cnf_date));
          if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
            $ghrn = $row_cnf["ref_num"];
            $h_type = $row_cnf["holi_type"];
            if($h_type == "International"){
              $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
              $res_cnf_int = $conn->query($sql_cnf_int);
              if($res_cnf_int->num_rows){
                while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                  $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                }
              }
            }
            else if($h_type == "Domestic"){
              $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
              $res_cnf_dom = $conn->query($sql_cnf_dom);
              if($res_cnf_dom->num_rows){
                while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                  $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                }
              }
            }
          }
        }
      }
    }
  }
  $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    if($row_sm = $res_sm->fetch_assoc()){
      //holiday partner sno
      $hp_sno = $row_sm["hp_sno"];
      $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$hp_sno."'";
      $res_cnf = $conn->query($sql_cnf);
      if($res_cnf->num_rows){
        while($row_cnf = $res_cnf->fetch_assoc()){
          $cnf_date = $row_cnf["confirmeddate"];
          $cnf_m = date("m", strtotime($cnf_date));
          $cnf_y = date("Y", strtotime($cnf_date));
          if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
            $ghrn = $row_cnf["ref_num"];
            $h_type = $row_cnf["holi_type"];
            if($h_type == "International"){
              $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
              $res_cnf_int = $conn->query($sql_cnf_int);
              if($res_cnf_int->num_rows){
                while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                  $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                }
              }
            }
            else if($h_type == "Domestic"){
              $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
              $res_cnf_dom = $conn->query($sql_cnf_dom);
              if($res_cnf_dom->num_rows){
                while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                  $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                }
              }
            }
          }
        }
      }
    }
  }
  $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
  $res_sm = $conn->query($sql_sm);
  if($res_sm->num_rows){
    if($row_sm = $res_sm->fetch_assoc()){
    //holiday partner sno
    $hp_sno = $row_sm["hp_sno"];
    $sql_sup = "SELECT * FROM holidaypartners WHERE sno = '".$hp_sno."'";
    $res_sup = $conn->query($sql_sup);
    if($res_sup->num_rows){
      if($row_sup = $res_sup->fetch_assoc()){
        //super partner's id
        $sup_id = $row_sup["super_partner_sno"];
        $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sup_id."'";
        $res_cnf = $conn->query($sql_cnf);
        if($res_cnf->num_rows){
          while($row_cnf = $res_cnf->fetch_assoc()){
            $cnf_date = $row_cnf["confirmeddate"];
            $cnf_m = date("m", strtotime($cnf_date));
            $cnf_y = date("Y", strtotime($cnf_date));
            if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
              $ghrn = $row_cnf["ref_num"];
              $h_type = $row_cnf["holi_type"];
              if($h_type == "International"){
                $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
                $res_cnf_int = $conn->query($sql_cnf_int);
                if($res_cnf_int->num_rows){
                  while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                  }
                }
              }
              else if($h_type == "Domestic"){
                $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
                $res_cnf_dom = $conn->query($sql_cnf_dom);
                if($res_cnf_dom->num_rows){
                  while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                  }
                }
              }
            }
          }
        }
      }
    }
  }
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
          while($row_sp = $res_sp->fetch_assoc()){
            //sales Partner sno
            $sno_sp = $row_sp["sno"];
            $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sno_sp."'";
            $res_cnf = $conn->query($sql_cnf);
            if($res_cnf->num_rows){
              while($row_cnf = $res_cnf->fetch_assoc()){
                $cnf_date = $row_cnf["confirmeddate"];
                $cnf_m = date("m", strtotime($cnf_date));
                $cnf_y = date("Y", strtotime($cnf_date));
                if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
                  $ghrn = $row_cnf["ref_num"];
                  $h_type = $row_cnf["holi_type"];
                  if($h_type == "International"){
                    $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
                    $res_cnf_int = $conn->query($sql_cnf_int);
                    if($res_cnf_int->num_rows){
                      while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                        $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                      }
                    }
                  }
                  else if($h_type == "Domestic"){
                    $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
                    $res_cnf_dom = $conn->query($sql_cnf_dom);
                    if($res_cnf_dom->num_rows){
                      while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                        $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    $sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
    $res_hp = $conn->query($sql_hp);
    if($res_hp->num_rows){
      while($row_hp = $res_hp->fetch_assoc()){
        //holiday partner's id
        $hp_sno = $row_hp["sno"];
        $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$hp_sno."'";
        $res_cnf = $conn->query($sql_cnf);
        if($res_cnf->num_rows){
          while($row_cnf = $res_cnf->fetch_assoc()){
            $cnf_date = $row_cnf["confirmeddate"];
            $cnf_m = date("m", strtotime($cnf_date));
            $cnf_y = date("Y", strtotime($cnf_date));
            if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
              $ghrn = $row_cnf["ref_num"];
              $h_type = $row_cnf["holi_type"];
              if($h_type == "International"){
                $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
                $res_cnf_int = $conn->query($sql_cnf_int);
                if($res_cnf_int->num_rows){
                  while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                  }
                }
              }
              else if($h_type == "Domestic"){
                $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
                $res_cnf_dom = $conn->query($sql_cnf_dom);
                if($res_cnf_dom->num_rows){
                  while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                  }
                }
              }
            }
          }
        }
      }
    }
    $sql_hp = "SELECT * FROM holidaypartners WHERE area_manager_sno = '".$sno."'";
    $res_hp = $conn->query($sql_hp);
    if($res_hp->num_rows){
      if($row_hp = $res_hp->fetch_assoc()){
        $sup_id = $row_hp["super_partner_sno"];
        $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed' AND sales_partner_name = '".$sup_id."'";
        $res_cnf = $conn->query($sql_cnf);
        if($res_cnf->num_rows){
          while($row_cnf = $res_cnf->fetch_assoc()){
            $cnf_date = $row_cnf["confirmeddate"];
            $cnf_m = date("m", strtotime($cnf_date));
            $cnf_y = date("Y", strtotime($cnf_date));
            if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
              $ghrn = $row_cnf["ref_num"];
              $h_type = $row_cnf["holi_type"];
              if($h_type == "International"){
                $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
                $res_cnf_int = $conn->query($sql_cnf_int);
                if($res_cnf_int->num_rows){
                  while($row_cnf_int = $res_cnf_int->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
                  }
                }
              }
              else if($h_type == "Domestic"){
                $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
                $res_cnf_dom = $conn->query($sql_cnf_dom);
                if($res_cnf_dom->num_rows){
                  while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
                    $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
                  }
                }
              }
            }
          }
        }
      }
    }
  break;
  case "regionalmanager":
  $sql_cnf = "SELECT ref_num, holi_type,confirmeddate FROM agent_form_data WHERE formstatus = 'confirmed'";
  $res_cnf = $conn->query($sql_cnf);
  if($res_cnf->num_rows){
    while($row_cnf = $res_cnf->fetch_assoc()){
      $cnf_date = $row_cnf["confirmeddate"];
      $cnf_m = date("m", strtotime($cnf_date));
      $cnf_y = date("Y", strtotime($cnf_date));
      if(($cnf_m == $curr_m) && ($cnf_y == $curr_y)){
        $ghrn = $row_cnf["ref_num"];
        $h_type = $row_cnf["holi_type"];
        if($h_type == "International"){
          $sql_cnf_int = "SELECT * FROM itinerary_inter WHERE ghrno = '".$ghrn."'";
          $res_cnf_int = $conn->query($sql_cnf_int);
          if($res_cnf_int->num_rows){
            while($row_cnf_int = $res_cnf_int->fetch_assoc()){
              $vol_conv = (int)$row_cnf_int["totcostfl"] + $vol_conv;
            }
          }
        }
        else if($h_type == "Domestic"){
          $sql_cnf_dom = "SELECT * FROM itinerary_domestic WHERE ghrnno = '".$ghrn."'";
          $res_cnf_dom = $conn->query($sql_cnf_dom);
          if($res_cnf_dom->num_rows){
            while($row_cnf_dom = $res_cnf_dom->fetch_assoc()){
              $vol_conv = (int)$row_cnf_dom["totcostfl"] + $vol_conv;
            }
          }
        }
      }
    }
  }
  break;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script  src="https://code.jquery.com/jquery-3.4.1.js"  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <link rel="stylesheet" href="st_sales_dash.css">
    <script type="text/javascript">
      $(document).ready(function(){
        var m_type = '<?php echo $m_type?>'
        console.log(m_type);
        if(m_type == "salesmanager"){
          $("#sm_pen_iti").removeClass("hidden");
        }
        else if(m_type == "areamanager"){
          $("#am_activity_tab").removeClass("hidden");
        }
        else if(m_type == "regionalmanager"){
          $("#reg_activity_tab").removeClass("hidden");
        }
        $(".other").click(function(){
          var ind = $(".other").index(this);
          console.log(ind);
          var act_sno = $(".other").eq(ind).attr("value");
          console.log(act_sno);
          $.ajax({
            type:"POST",
            url: "set_oth_act.php",
            data:"act_id="+act_sno,
            success: function(data){
              console.log(data);
            }
          });
        });
        $(".rec").click(function(){
          var ind = $(".other").index(this);
          console.log(ind);
          var act_sno = $(".other").eq(ind).attr("value");
          console.log(act_sno);
          $.ajax({
            type:"POST",
            url: "set_rec_act.php",
            data:"act_id="+act_sno,
            success: function(data){
              console.log(data);
            }
          });
        });
        $(".sal").click(function(){
          var ind = $(".other").index(this);
          console.log(ind);
          var act_sno = $(".other").eq(ind).attr("value");
          console.log(act_sno);
          $.ajax({
            type:"POST",
            url: "set_sal_act.php",
            data:"act_id="+act_sno,
            success: function(data){
              console.log(data);
            }
          });
        });
      });
    </script>
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
          <a class="dropdown-item" target = "_blank" href="itineraries/req_iti.php">Requested</a>
          <a class="dropdown-item" target = "_blank" href="itineraries/rec_iti.php">Recieved</a>
          <a class="dropdown-item" target = "_blank" href="itineraries/conf_iti.php">Confirmed</a>
          <a class="dropdown-item" target = "_blank" href="itineraries/recent_iti.php">Recent Packages</a>
        </div>
      </div>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="partdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Partners
        </a>
        <div class="dropdown-menu" aria-labelledby="partdropdown">
          <a class="dropdown-item" target = "_blank" href="partners/super_p.php">Super Partners</a>
          <a class="dropdown-item" target = "_blank" href="partners/holiday_p.php">Holiday Partners</a>
          <a class="dropdown-item" target = "_blank" href="partners/sales_p.php">Sales Partners</a>
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
          <a class="dropdown-item" target = "_blank" href="statements/statements_init.php">Issued Statements</a>
        </div>
      </div>
        <a class = 'links' target='_blank' href="clients/clients.php">Clients</a>
        <a class = 'links' target='_blank' href="vouchers/vouchers.php">Vouchers</a>
      <div class = 'drpdn'>
        <a class="dropdown-toggle links" href="#" role="button" id="moredropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            More
        </a>
        <div class="dropdown-menu" aria-labelledby="moredropdown">
          <a class="dropdown-item" target = "_blank" href="daily_activity/ytd.php">YTD Reports</a>
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

                <p class="card-text" style = 'font-size:20px;'><?php echo $pen_iti;?></p>
              </div>
            </div>
          </div>
          <div class="col-2 crd">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
              <div class="card-header">Total Itineraries Recieved</div>
              <div class="card-body">

                <p class="card-text" style = 'font-size:20px;'><?php echo $rec_iti;?> </p>
              </div>
          </div>
        </div>
        <div class="col-2 crd">
          <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Total Itineraries Confirmed</div>
            <div class="card-body">
              <p class="card-text" style = 'font-size:20px;'><?php echo $cnf_iti;?> </p>
            </div>
          </div>
        </div>
        <div class="col-2 crd">
          <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Total Volume Converted</div>
            <div class="card-body">
              <p class="card-text" style = 'font-size:20px; letter-spacing:0.05em;'><?php echo $vol_conv;?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid hidden" id = 'sm_pen_iti'>
      <h4>Pending Itineraries</h4>
      <div class="row">
        <div class="section">
          <?php
          //getting sales partner forms who are under him
          $sql_sp = "SELECT * FROM salespartners WHERE sales_manager_sno = '".$sno."'";
          $res_sp = $conn->query($sql_sp);
          if($res_sp->num_rows){
            while($row_sp = $res_sp->fetch_assoc()){
              $sp_sno = $row_sp["sno"];
              $sql_sp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sp_sno."' AND formstatus = 'pending' ORDER BY datesent DESC";
              $res_sp_forms = $conn->query($sql_sp_forms);
              if($res_sp_forms->num_rows){
                echo "<br><h6>Sales Partner Requests</h6><br>
                      <table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>GHR Number</th>
                          <th scope='col'>Customer Name</th>
                          <th scope='col'>Form Raised By</th>
                          <th scope='col'>Partner's Name</th>
                          <th scope='col'>Destination</th>
                          <th scope='col'>Start Date</th>
                          <th scope='col'>End Date</th>
                          <th scope='col'>Duration</th>
                          <th scope='col'>Form Requested on</th>
                        </tr>
                      </thead>
                      ";
                      while($row_sp_forms = $res_sp_forms->fetch_assoc()){
                        $datesent =date_create($row_sp_forms["datesent"]);
                        $datesent =date_format($datesent,"d-M-Y");
                        echo "<tr>
                                <td>GHRN".(5000+(int)$row_sp_forms["ref_num"])."</td>
                                <td>".$row_sp_forms["cust_firstname"]." ".$row_sp_forms["cust_lastname"]."</td>
                                <td>".$row_sp_forms["form_filled_by"]."</td>
                                <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                <td>".$row_sp_forms["holi_dest"]."</td>
                                <td>".$row_sp_forms["date_of_travel"]."</td>
                                <td>".$row_sp_forms["return_date_of_travel"]."</td>
                                <td>".$row_sp_forms["duration"]."</td>
                                <td>".$datesent."</td>
                                </tr>";
                      }
                      echo"</table>";
              }
            }
          }
          //getting holiday partner forms
          $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
          $res_sm = $conn->query($sql_sm);
          if($res_sm->num_rows){
            if($row_sm = $res_sm->fetch_assoc()){
              $hp_id = $row_sm["hp_sno"];
              $sql_hp_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$hp_id."' AND formstatus = 'pending' ORDER BY datesent DESC";
              $res_hp_forms = $conn->query($sql_hp_forms);
              if($res_hp_forms->num_rows){
                echo "<br><h6>Holiday Partner Requests</h6><br>
                      <table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>GHR Number</th>
                          <th scope='col'>Customer Name</th>
                          <th scope='col'>Form Raised By</th>
                          <th scope='col'>Partner's Name</th>
                          <th scope='col'>Destination</th>
                          <th scope='col'>Start Date</th>
                          <th scope='col'>End Date</th>
                          <th scope='col'>Duration</th>
                          <th scope='col'>Form Requested on</th>
                        </tr>
                      </thead>
                      ";
                      while($row_hp_forms = $res_hp_forms->fetch_assoc()){
                        $datesent =date_create($row_hp_forms["datesent"]);
                        $datesent =date_format($datesent,"d-M-Y");
                        echo "<tr>
                                <td>GHRN".(5000+(int)$row_hp_forms["ref_num"])."</td>
                                <td>".$row_hp_forms["cust_firstname"]." ".$row_hp_forms["cust_lastname"]."</td>
                                <td>".$row_hp_forms["form_filled_by"]."</td>
                                <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                <td>".$row_hp_forms["holi_dest"]."</td>
                                <td>".$row_hp_forms["date_of_travel"]."</td>
                                <td>".$row_hp_forms["return_date_of_travel"]."</td>
                                <td>".$row_hp_forms["duration"]."</td>
                                <td>".$datesent."</td>
                                </tr>";
                      }
                      echo"</table>";
                }
              }
            }
            //getting super partner forms
            $sql_sm = "SELECT * FROM salesmanagers WHERE sno = '".$sno."'";
            $res_sm = $conn->query($sql_sm);
            if($res_sm->num_rows){
              if($row_sm = $res_sm->fetch_assoc()){
                $hp_id = $row_sm["hp_sno"];
                $sql_hp = "SELECT * FROM holidaypartners WHERE sno = '".$hp_id."'";
                $res_hp = $conn->query($sql_hp);
                if($res_hp->num_rows){
                        if($row_hp = $res_hp->fetch_assoc()){
                          $sup_id = $row_hp["super_partner_sno"];
                          $sql_sup_forms = "SELECT * FROM agent_form_data WHERE sales_partner_name = '".$sup_id."' AND formstatus = 'pending' ORDER BY datesent DESC";
                          $res_sup_forms = $conn->query($sql_sup_forms);
                          if($res_sup_forms->num_rows){
                            echo "<br><h6>Super Partner Requests</h6><br>
                                  <table class='table'>
                                  <thead class='thead-light'>
                                    <tr>
                                      <th scope='col'>GHR Number</th>
                                      <th scope='col'>Customer Name</th>
                                      <th scope='col'>Form Raised By</th>
                                      <th scope='col'>Partner's Name</th>
                                      <th scope='col'>Destination</th>
                                      <th scope='col'>Start Date</th>
                                      <th scope='col'>End Date</th>
                                      <th scope='col'>Duration</th>
                                      <th scope='col'>Form Requested on</th>
                                    </tr>
                                  </thead>
                                  ";
                            while($row_sup_forms = $res_sup_forms->fetch_assoc()){
                              $datesent =date_create($row_sup_forms["datesent"]);
                              $datesent =date_format($datesent,"d-M-Y");
                              echo "<tr>
                                      <td>GHRN".(5000+(int)$row_sup_forms["ref_num"])."</td>
                                      <td>".$row_sup_forms["cust_firstname"]." ".$row_sup_forms["cust_lastname"]."</td>
                                      <td>".$row_sup_forms["form_filled_by"]."</td>
                                      <td>".$row_sp_forms["holi_partner_loc"]."</td>
                                      <td>".$row_sup_forms["holi_dest"]."</td>
                                      <td>".$row_sup_forms["date_of_travel"]."</td>
                                      <td>".$row_sup_forms["return_date_of_travel"]."</td>
                                      <td>".$row_sup_forms["duration"]."</td>
                                      <td>".$datesent."</td>
                                      </tr>";
                            }
                            echo"</table>";
                          }
                        }
                  }
                }
              }
          ?>
        </div>
      </div>
    </div>
    <div class="container-fluid hidden" id = 'am_activity_tab'>
      <h4>Recent Activity</h4>
      <div class="row">

        <div class="section">

          <?php
          $data = 0;
          $sql_sm = "SELECT * FROM salesmanagers WHERE a_m_sno = '".$sno."'";
          $res_sm = $conn->query($sql_sm);
          if($res_sm->num_rows){
            while($row_sm = $res_sm->fetch_assoc()){
              $sm_id = $row_sm["sno"];
              $sql_sal_act = "SELECT * FROM sales_activity_track WHERE man_id = '".$sm_id."' ORDER BY activity_date LIMIT 3";
              $res_sal_act = $conn->query($sql_sal_act);
              if($res_sal_act->num_rows){
                $data = 1;
                echo "<h6>Sales Activity</h6>";
                echo "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>Manager ID</th>
                          <th scope='col'>Manager Name</th>
                          <th scope='col'>Activity Type</th>
                          <th scope='col'>Activity Date</th>
                          <th scope='col'>Review Status</th>
                          <th scope='col'>Review Activity</th>
                        </tr>
                      </thead>";
                while($row_sal_act = $res_sal_act->fetch_assoc()){
                  echo "<tr>
                        <td>".$row_sal_act["man_id"]."</td>
                        <td>".$row_sal_act["man_name"]."</td>
                        <td>Sales</td>
                        <td>".$row_sal_act["activity_date"]."</td>
                        <td>".$row_sal_act["review_status"]."</td>
                        <td><a class='btn btn-sm btn-info sal' value = '".$row_sal_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_sal_act["sno"]."&typ=Sales'>Review Activity</a></td>
                        </tr>";
                }
                echo"</table>";
              }
              $sql_rec_act = "SELECT * FROM rec_activity_track WHERE man_id = '".$sm_id."' ORDER BY activity_date LIMIT 3";
              $res_rec_act = $conn->query($sql_rec_act);
              if($res_rec_act->num_rows){
                $data = 1;
                echo "<h6>Recruitment Activity</h6>";
                echo "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>Manager ID</th>
                          <th scope='col'>Manager Name</th>
                          <th scope='col'>Activity Type</th>
                          <th scope='col'>Activity Date</th>
                          <th scope='col'>Review Status</th>
                          <th scope='col'>Review Activity</th>
                        </tr>
                      </thead>";
                while($row_res_act = $res_rec_act->fetch_assoc()){
                  echo "<tr>
                        <td>".$row_res_act["man_id"]."</td>
                        <td>".$row_res_act["man_name"]."</td>
                        <td>Recruitment</td>
                        <td>".$row_res_act["activity_date"]."</td>
                        <td>".$row_sal_act["review_status"]."</td>
                        <td><a class='btn btn-sm btn-info rec' value = '".$row_res_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_res_act["sno"]."&typ=Recruitment'>Review Activity</a></td>
                        </tr>";
                }
                echo"</table>";
              }
              $sql_ot_act = "SELECT * FROM other_activity_track WHERE man_id = '".$sm_id."' ORDER BY activity_date LIMIT 3";
              $res_ot_act = $conn->query($sql_ot_act);
              if($res_ot_act->num_rows){
                $data = 1;
                echo "<h6>Other Activity</h6>";
                echo "<table class='table'>
                      <thead class='thead-light'>
                        <tr>
                          <th scope='col'>Manager ID</th>
                          <th scope='col'>Manager Name</th>
                          <th scope='col'>Activity Type</th>
                          <th scope='col'>Activity Date</th>
                          <th scope='col'>Review Status</th>
                          <th scope='col'>Review Activity</th>
                        </tr>
                      </thead>";
                while($row_ot_act = $res_ot_act->fetch_assoc()){
                  echo "<tr>
                        <td>".$row_ot_act["man_id"]."</td>
                        <td>".$row_ot_act["man_name"]."</td>
                        <td>".$row_ot_act["act_type"]."</td>
                        <td>".$row_ot_act["activity_date"]."</td>
                        <td>".$row_ot_act["review_status"]."</td>
                        <td><a class='btn btn-sm btn-info other' value = '".$row_ot_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_ot_act["sno"]."&typ=Other'>Review Activity</a></td>
                        </tr>";
                }
                echo"</table>";
              }
            }
          }
          if($data == 0){
            echo "Hmm! Interestingly Enough, we did not find any activity you should be notified of! No worries, they'll show up here when there are some!";
            echo "<br><br>";
          }
          ?>
        </div>
      </div>
    </div>
    <div class="container-fluid hidden" id = 'reg_activity_tab'>
      <h4>Recent Activity</h4>
      <div class="row">

        <div class="section">

          <?php
          $data = 0;
          $sql_sal_act = "SELECT * FROM sales_activity_track ORDER BY activity_date";
          $res_sal_act = $conn->query($sql_sal_act);
          if($res_sal_act->num_rows){
            $data = 1;
            echo "<h6>Sales Activity</h6>";
            echo "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Manager ID</th>
                      <th scope='col'>Manager Name</th>
                      <th scope='col'>Activity Type</th>
                      <th scope='col'>Activity Date</th>
                      <th scope='col'>Review Status</th>
                      <th scope='col'>Review Activity</th>
                    </tr>
                  </thead>";
            while($row_sal_act = $res_sal_act->fetch_assoc()){
              echo "<tr>
                    <td>".$row_sal_act["man_id"]."</td>
                    <td>".$row_sal_act["man_name"]."</td>
                    <td>Sales</td>
                    <td>".$row_sal_act["activity_date"]."</td>
                    <td>".$row_sal_act["review_status"]."</td>
                    <td><a class='btn btn-sm btn-info sal' value  = '".$row_sal_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_sal_act["sno"]."&typ=Sales'>Review Activity</a></td>
                    </tr>";
            }
            echo"</table>";
          }
          ?>
          <?php
          $sql_rec_act = "SELECT * FROM rec_activity_track ORDER BY activity_date";
          $res_rec_act = $conn->query($sql_rec_act);
          if($res_rec_act->num_rows){
            $data = 1;
            echo "<h6>Recruitment Activity</h6>";
            echo "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Manager ID</th>
                      <th scope='col'>Manager Name</th>
                      <th scope='col'>Activity Type</th>
                      <th scope='col'>Activity Date</th>
                      <th scope='col'>Review Status</th>
                      <th scope='col'>Review Activity</th>
                    </tr>
                  </thead>";
            while($row_res_act = $res_rec_act->fetch_assoc()){
              echo "<tr>
                    <td>".$row_res_act["man_id"]."</td>
                    <td>".$row_res_act["man_name"]."</td>
                    <td>Recruitment</td>
                    <td>".$row_res_act["activity_date"]."</td>
                    <td>".$row_res_act["review_status"]."</td>
                    <td><a class='btn btn-sm btn-info rec' value = '".$row_res_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_res_act["sno"]."&typ=Recruitment'>Review Activity</a></td>
                    </tr>";
            }
            echo"</table>";
          }
          ?>
          <?php
          $sql_ot_act = "SELECT * FROM other_activity_track ORDER BY activity_date";
          $res_ot_act = $conn->query($sql_ot_act);
          if($res_ot_act->num_rows){
            $data = 1;
            echo "<h6>Other Activity</h6>";
            echo "<table class='table'>
                  <thead class='thead-light'>
                    <tr>
                      <th scope='col'>Manager ID</th>
                      <th scope='col'>Manager Name</th>
                      <th scope='col'>Activity Type</th>
                      <th scope='col'>Activity Date</th>
                      <th scope='col'>Review Status</th>
                      <th scope='col'>Review Activity</th>
                    </tr>
                  </thead>";
            while($row_ot_act = $res_ot_act->fetch_assoc()){
              echo "<tr>
                    <td>".$row_ot_act["man_id"]."</td>
                    <td>".$row_ot_act["man_name"]."</td>
                    <td>".$row_ot_act["act_type"]."</td>
                    <td>".$row_ot_act["activity_date"]."</td>
                    <td>".$row_ot_act["review_status"]."</td>
                    <td><a class='btn btn-sm btn-info other' value = '".$row_ot_act["sno"]."' role='button' target='_blank' href='daily_activity/view_act_det.php?sn=".$row_ot_act["sno"]."&typ=Other'>Review Activity</a></td>
                    </tr>";
            }
            echo"</table>";
          }
          if($data == 0){
            echo "Hmm! Interestingly Enough, we did not find any activity you should be notified of! No worries, they'll show up here when there are some!";
            echo "<br><br>";
          }
          ?>
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
    <script type="text/javascript" src = 's_sales_dash.js'>

    </script>
  </body>
</html>
