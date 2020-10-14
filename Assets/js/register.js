$(document).ready(function() {
  $("#hideLogin").click(function() {
    $("#loginform").hide();
    $("#registerForm").show();

  });

  $("#hideRegister").click(function(){
    $("#loginform").show();
    $("#registerForm").hide();

});
});
