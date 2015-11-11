/**
 *
 */

(function($) {
  
  var toggle = function(name) {
    var menu = $('#'+name),
        body = $('body'),
        speed = 200,
        menuWidth = menu.outerWidth(true);
    if(menu.is(':visible')) {
      menu.css({'display': 'none', 'left': 0});
      body.css({
        width: body.width(),
        position: 'absolute'
      }).animate({left: 0 + 'px'}, speed);
    } else {
      menu.css({'display': 'block', 'left': 0});
      body.css({
        width: body.width(),
        position: 'absolute'
      }).animate({left: menuWidth + 'px'}, speed);
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