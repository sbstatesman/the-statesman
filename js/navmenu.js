/**
 *
 */

(function($) {
  var toggle = function(name) {
    var menu = $('#'+name),
        body = $('body'),
        menuWidth = menu.outerWidth(true);
    if(menu.is(':visible')) {
      menu.css({'display': 'none', 'left': 0});
    } else {
      menu.css({'display': 'block', 'left': 0});
    }
  };
  
  $.fn.sidemenu = function(options) {
    var settings = $.extend({
      name : 'nav'
    }, options);
    
    //sideMenu = $('#'+settings.name);
    this.click(function(e) {
      e.preventDefault();
      toggle(settings.name);
    });
  };
}(jQuery));

$(document).ready(function() {
  $('#nav-menu').sidemenu();
});