/*console.log('\n' +
'                        @@@@@@@@@@@@@@@                    \n' +
'                      @@@@        @@@@@                    \n' +
'                    @@@@             @@@                   \n' +
'                   @@@@               @@                   \n' +
'                   @@@@                                    \n' +
'                   @@@@@                                   \n' +
'                   @@@@@@                                  \n' +
'                    @@@@@@@                                \n' +
'                     @@@@@@@@@                             \n' +
'                       @@@@@@@@@                           \n' +
'                          @@@@@@@@@                        \n' +
'                             @@@@@@@@                      \n' +
'                                @@@@@@@                    \n' +
'                                  @@@@@@                   \n' +
'                                   @@@@@@                  \n' +
'                                    @@@@@                  \n' +
'                 @                   @@@@                  \n' +
'                 @@                 @@@@                   \n' +
'                 @@@                @@@                    \n' +
'                  @@@@@           @@@@                     \n' +
'                  @@@@@@@@@@@@@@@@@@                       \n' +
'                         @@@@@@                            \n\n' +
'Join the Statesman Web & Graphics Section \n' +
'https://www.facebook.com/groups/1481474198792246/ \n\n');*/
console.log('jquery version: '+$().jquery);

/* A JQuery plugin for producing a sliding list. Should be independent of
 * display. Is called on a jquery object like so:
 * $(selector).slidelist({id: 0});
 */
$.fn.slidelist = function(options) {
  
  /* The settings of the widget; can be input by the caller */
  var settings = $.extend({
    id: 0,
    startingSlide: 0,
    postsPerSlide: 4
  }, options );
  
  /* Number of total posts we can slide through */
  var totalPosts = $(this).find('li').length;
  
  /* The current state of the slider widget */
  var curSlideState = [0, settings.postsPerSlide-1];
  
  /* Initiates the list of states of the slider, based on how many posts 
   * there are, how many posts to display per slide, and which slide to start
   * on.
   */
  var initSlideStates = function() {
    slideStates = [];
    for(var i=curSlideState[0];i<totalPosts;i+=settings.postsPerSlide) {
      var prevInd = i;
      var nextInd = i+settings.postsPerSlide-1;
      slideStates.push([prevInd, nextInd]);
    }
    return slideStates;
  }
  
  /* A list of the various states the slider can be in */
  var slideStates = initSlideStates();
  
  /*  */
  var updateArrow = function(arrow, hideArrow, callback) {
    //Check if arrow image is displayed or not
    if(hideArrow) {
      arrow.unbind('click');
      arrow.children('img').hide();
      arrow.children('img').css('cursor', 'default');
    } else {
      arrow.unbind('click');
      arrow.bind('click', callback);
      //Jquery show() and css() are idempotent
      arrow.children('img').show();
      arrow.children('img').css('cursor', 'pointer');
    }
  }
  
  /*  */
  var updateArrows = function() {
    //toggleArrow('prev');
    var prevArrow = $('[data-slidelist-'+settings.id+'-prev]')
    var nextArrow = $('[data-slidelist-'+settings.id+'-next]')
    if(curSlideState[0]<=0) {
      updateArrow(prevArrow, true, null);
    } else {
      updateArrow(prevArrow, false, function() {
        moveSlide(curSlideState[0]-4)
      });
    }
    if(curSlideState[1]>=totalPosts-1) {
      updateArrow(nextArrow, true, null);
    } else {
      updateArrow(nextArrow, false, function() {
        moveSlide(curSlideState[1]+1)
      });
    }
  }

  /* Update the state variable to represent the current state of the slider */
  var updateState = function(startIndex) {
    slideStates.forEach(function(element) {
      if(element[0]===startIndex) {
        curSlideState = element;
      }
    });
  }

  /* Changes display of the slider, that is, shows only ths posts within the
   * the current state. Takes the starting index of the state as parameter */
  var moveSlide = function(startIndex) {
    $('[data-slidelist-'+settings.id+'-list]>li').hide();
    for(var i=startIndex;i<startIndex+settings.postsPerSlide;i++) {
      $('[data-slidelist-'+settings.id+'-list]>[data-slidelist-'+settings.id+'-item-'+i+']').show();
    }
    updateState(startIndex);
    updateArrows();
    return startIndex;
  };
  
  /* Initiate the display of the slider widget.*/
  moveSlide(settings.startingSlide)
  return this;
};

$(document).ready(function(){
  $('.slickmebaby').slick({
    prevArrow: '#prev',
    nextArrow: '#next',
    dots: true
  });
});