$(document).ready(function(){
  

  //console.log(utyp);
  $("#u_type").change(function(){
    var utyp = document.getElementById('u_type').value;
    if(utyp == "regionalmanager"){
      $("#am_name").addClass("hidden");
      $("#rm_name").addClass("hidden");
      
    }
    else if(utyp == "areamanager"){
      //$("#desg").text("Regional ");
      $("#am_name").addClass("hidden");
      $("#rm_name").removeClass("hidden");

    }
    else if (utyp == "salesmanager") {
      $("#am_name").removeClass("hidden");
      $("#rm_name").addClass("hidden");

    }
  });

});
