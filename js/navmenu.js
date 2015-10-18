/**
 *
 */

(function($) {
  
  var toggle = function(name) {
    var menu = $('#'+name),
        menuWidth = menu.outerWidth(true);
    console.log(menu);
    if(menu.is(':visible')) {
      console.log('hidden');
      menu.css('display', 'none');
    } else {
      console.log('displayed');
      menu.css('display', 'block');
    }
  };
  
  $.fn.sidemenu = function(options) {
    var settings = $.extend({
      name : 'nav'
    }, options);
    
    //sideMenu = $('#'+settings.name);
    console.log(this);
    this.click(function(e) {
      console.log('clicked');
      e.preventDefault();
      toggle(settings.name);
    });
  };
}(jQuery));

$(document).ready(function() {
  console.log('loaded');
  $('#nav-menu').sidemenu();
});