(function($){
  $(function(){

    $('.sidenav').sidenav();
    $('select').formSelect();
    $('.modal').modal();

  });
})(jQuery);

// Pesquisa avançada
$( "#pesquisaAvancada" ).hide();
$( ".divOptionPeriodo" ).hide();
$(document).ready(function () {
  var ckbox = $('#checkboxPesquisaAvancada'); 

  $('input').on('click',function () {
    if (ckbox.is(':checked')) {
      $( "#pesquisaAvancada" ).show( "fast" );
      $( "#pesquisaAvancada" ).value( "fast" );
    } else {
      $( "#pesquisaAvancada" ).hide( "fast" );
    }
  });
});

var d = new Date();
var n = d.getFullYear();
document.getElementById("copyright-js").innerHTML = " &copy; " + n;
