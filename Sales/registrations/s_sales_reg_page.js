$(document).ready(function(){
  

  //console.log(utyp);
  $("#u_type").change(function(){
    var utyp = document.getElementById('u_type').value;
    if(utyp == "regionalmanager"){
      $("#am_name").addClass("hidden");
      $("#rm_name").addClass("hidden");
      $("#hp_name").addClass("hidden");
    }
    else if(utyp == "areamanager"){
      //$("#desg").text("Regional ");
      $("#am_name").addClass("hidden");
      $("#rm_name").removeClass("hidden");
      $("#hp_name").addClass("hidden");
      $.ajax({
        type:"POST",
        url:"get_rm.php",
        success: function(data){
          $("#rm_nam").html(data);
        }
      });

    }
    else if (utyp == "salesmanager") {
      $("#am_name").removeClass("hidden");
      $("#hp_name").removeClass("hidden");
      $("#rm_name").addClass("hidden");
      $.ajax({
        type:"POST",
        url:"get_hp.php",
        success: function(data){
          $("#hp_nam").html(data);
        }
      });
    }
  });

});
