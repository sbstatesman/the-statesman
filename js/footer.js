jQuery(document).ready(function() {
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