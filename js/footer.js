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
    jQuery('.search-bar').hide();
  });
  jQuery('#show-search').click(function(){
    jQuery('.search-bar').toggle();
    if (jQuery('#show-nav').css('display') !== 'none' ){
      jQuery('.nav-list').hide();
    }
    if (jQuery('.search-bar').css('display') !== 'none'){
      jQuery('.search-bar input').focus();
    }
  });

});
