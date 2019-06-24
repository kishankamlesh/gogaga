$(document).ready(function(){
  //alert("Ready!");
  $("#p_sel").change(function(){
    var part = $("#p_sel").val();
    $("#p_name").val(part);
  });
});
