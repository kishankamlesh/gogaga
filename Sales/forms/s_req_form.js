$(document).ready(function(){
  $("#p_sel").change(function(){
    var part = $("#p_sel").val();
    $("#p_name").val(part);
  })
  $("#h_name").change(function(){
    var part_i = $("#h_name").val();
    $("#hp_name").val(part_i);
  })
  $("#sup_name").change(function(){
    $("#l_s_name").removeClass("hidden");
    $("#super_name").removeClass("hidden");
    var sup_p = $("#sup_name").val();
    $("#super_name").val(sup_p);
  });
});
