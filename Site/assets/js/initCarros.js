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
  document.getElementById('tipoPesquisa').value = 'simples';
  $(document).ready(function () {
    var ckbox = $('#checkboxPesquisaAvancada'); 
  
    $('input').on('click',function () {
      if (ckbox.is(':checked')) {
        document.getElementById('tipoPesquisa').value = 'avancada';
        $( "#pesquisaAvancada" ).show( "fast" );
        $( "#pesquisaAvancada" ).value( "fast" );
      } else {
        $( "#pesquisaAvancada" ).hide( "fast" );
        document.getElementById('tipoPesquisa').value = 'simples';
      }
    });
  });
  
  function periodo() {
    var selectFiltro = document.getElementById('selectFiltro').value;
    if (selectFiltro == 'Periodo') {
      $( ".divOptionPeriodo" ).show( "fast" );
    } else {
      $( ".divOptionPeriodo" ).hide( "fast" );
    }
  }
  
  var d = new Date();
  var n = d.getFullYear();
  document.getElementById("copyright-js").innerHTML = " &copy; " + n;
  