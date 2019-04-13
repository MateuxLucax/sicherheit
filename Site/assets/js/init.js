(function($){
  $(function(){

    $('.sidenav').sidenav();

  });
})(jQuery);

var d = new Date();
var n = d.getFullYear();
document.getElementById("copyright-js").innerHTML = " &copy; " + n;