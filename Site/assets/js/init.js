(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('select').formSelect();
    $('.modal').modal();

  });
})(jQuery);

$( "#pesquisaAvancada" ).hide();
$(document).ready(function () {
  var ckbox = $('#checkboxPesquisaAvancada');
  $('input').on('click',function () {
      if (ckbox.is(':checked')) {
          $( "#pesquisaAvancada" ).show( "fast" );
      } else {
          $( "#pesquisaAvancada" ).hide( "fast" );
      }
  });
});

var d = new Date();
var n = d.getFullYear();
document.getElementById("copyright-js").innerHTML = " &copy; " + n;