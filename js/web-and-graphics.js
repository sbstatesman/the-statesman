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
    //var arrow = $('[data-slidelist-'+settings.id+'-'+arrowName+']');
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
      //$('[data-slidelist-'+settings.id+'-prev]').unbind('click');
      //$('[data-slidelist-'+settings.id+'-prev]>img').hide();
      //$('[data-slidelist-'+settings.id+'-prev]>img').css('cursor', 'default');
    } else {
      updateArrow(prevArrow, false, function() {
        moveSlide(curSlideState[0]-4)
      });
      //$('[data-slidelist-'+settings.id+'-prev]').unbind('click');
      //$('[data-slidelist-'+settings.id+'-prev]').bind('click', function() {
      //  moveSlide(curSlideState[0]-4)
      //});
      //$('[data-slidelist-'+settings.id+'-prev]>img').show();
      //$('[data-slidelist-'+settings.id+'-prev]>img').css('cursor', 'pointer');
    }
    if(curSlideState[1]>=totalPosts-1) {
      updateArrow(nextArrow, true, null);
      //$('[data-slidelist-'+settings.id+'-next]').unbind('click');
      //$('[data-slidelist-'+settings.id+'-next]>img').hide();
      //$('[data-slidelist-'+settings.id+'-next]>img').css('cursor', 'default');
    } else {
      updateArrow(nextArrow, false, function() {
        moveSlide(curSlideState[1]+1)
      });
      //$('[data-slidelist-'+settings.id+'-next]').unbind('click');
      //$('[data-slidelist-'+settings.id+'-next]').bind('click', function() {
      //  moveSlide(curSlideState[1]+1)
      //});
      //$('[data-slidelist-'+settings.id+'-next]>img').show();
      //$('[data-slidelist-'+settings.id+'-next]>img').css('cursor', 'pointer');
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

$(document).ready(function() {
  /* Initiate three sliders.
   * TODO: should only be called on the multimedia page. */
  $('[data-slidelist-0]').slidelist({id: 0});
  $('[data-slidelist-1]').slidelist({id: 1});
  $('[data-slidelist-2]').slidelist({id: 2});
  
  /* test code for animation, currently inactive. */
  var $item = $('div.newitem'), //Cache your DOM selector
    visible = 4, //Set the number of items that will be visible
    index = 0, //Starting index
    endIndex = ( $item.length / visible ) - 1; //End index
  
  $('div#newprev').click(function(){
    if(index < endIndex ){
      index++;
      $item.animate({'left':'-=300px'});
    }
  });
  
  $('div#newnext').click(function(){
    if(index > 0){
      index--;            
      $item.animate({'left':'+=300px'});
    }
  });
});












































