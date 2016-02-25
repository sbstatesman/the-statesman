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
        width: '100%',
        position: 'absolute'
      }).animate({left: 0 + 'px'}, speed);
    } else {
      menu.css({'display': 'block', 'left': 0});
      body.css({
        width: '100%',
        position: 'absolute'
      }).animate({left: menuWidth + 'px'}, speed);
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

  $(document).ready(function() {
    $('#nav-menu').sidemenu();

    $('img').each(function () { // add data-lazy attribute for slick's lazy-loading
      $(this).attr('data-lazy', $(this).data('src'));
    }); 
    $('.slidecontainer').each(function (i, element) {
      $('.arrow-left', element).attr('id', 'prev-' + i);
      $('.arrow-right', element).attr('id', 'next-' + i);
      $('.slicktarget', element).attr('id', 'slidelist-' + i);
    });

    $('.slidelist').each(function (i, element) {
      $('.slidelist').on('beforeChange', function(event, slick){ 
        $('html, body').scrollTop(0);            //jump to top when sliding
      }).slick({
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '#prev-' + i,
        nextArrow: '#next-' + i,
        dots: true,
        draggable: false,
        touchMove: false,
        swipe: false,
        lazyLoad: 'ondemand', // To use lazy loading, set a data-lazy attribute on your img tags and leave off the src
        cssEase: 'linear',
        adaptiveHeight: true,   // this plus height change of .slick-slide in slick.css needed to change slicktarget heights
        appendDots: $('#nav'),
        customPaging: function(slider, i) {
          var title = $('#side-menu-item-'+i).html();
          //return '<li class="side-menu-item">'+title+'</li>';
          return title;
        }
      });
    });
  });
}(jQuery));