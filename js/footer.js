jQuery(document).ready(function() {

  /* Navbar show/hide code */
  jQuery(window).resize(function(){
    if (jQuery('#show-nav').css('display') === 'none' ){
      jQuery('.nav-list').show();
    } else {
      jQuery('.nav-list').hide();
    }
  });
  jQuery('#show-nav').click(function(){
    jQuery('.nav-list').toggle();
    jQuery('.search').hide();
  });
  jQuery('#show-search').click(function(){
    jQuery('.search').toggle();
    if (jQuery('#show-nav').css('display') !== 'none' ){
      jQuery('.nav-list').hide();
    }
  });

  /* Slick gallary initialization */
  jQuery('.gallery-container').each(function (i, element) {
    jQuery('.arrow-left', element).attr('id', 'prev-' + i);
    jQuery('.arrow-right', element).attr('id', 'next-' + i);
    jQuery('.slicktarget', element).attr('id', 'gallery-' + i);
  });
  jQuery('.gallery').each(function (i, element) {
    jQuery('#gallery-' + i).on('init reInit beforeChange', function(event, slick, currentSlide, nextSlide){
      var index = (nextSlide ? nextSlide : 0) + 1;
      jQuery('.slick-counter', this).text(index + '/' + slick.slideCount);
    });
    jQuery(element).slick({
      prevArrow: '#prev-' + i,
      nextArrow: '#next-' + i,
      dots: false
    });
  });

});