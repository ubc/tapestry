var H5P = H5P || {};

H5P.BranchVideo = (function ($) {
  /**
   * Constructor function.
   */
  function C(options, id) {
    this.$ = $(this);
    // Extend defaults with provided options
    this.options = $.extend(true, {}, {
      mainBranchedVideo:{
        branchedVideos: [
          {
            slug: '',
            title: '',
            description: '',
            length: 0,
            sourceFiles: {},
            subBranches: {}
          }
        ],
        mainBranchSlug: ''
      }
    }, options);
    // Keep provided id.
    this.id = id;
  };



  /**
   * Attach function called by H5P framework to insert H5P content into
   * page
   *
   * @param {jQuery} $container
   */
  C.prototype.attach = function ($container) {
    // container.  Allows for styling later.
    $container.addClass("h5p-greetingcard");

    var currentVideoPlaying = '';


    // initialize and create associative array
    var numOfBranches = this.options.mainBranchedVideo.branchedVideos.length;
//    var i;
    var $branchedVideos = {};
    for (var i = 0 ; i < numOfBranches ; i++){
      var tempSlug = this.options.mainBranchedVideo.branchedVideos[i].slug;
      $branchedVideos[tempSlug] = this.options.mainBranchedVideo.branchedVideos[i];
    }


    // handle onTimeUpdate EDITED
    var $timeKeeper = {};
    var $progressKeeper = {};
    for (var i = 0; i< numOfBranches; i++){
      var tempSlug = this.options.mainBranchedVideo.branchedVideos[i].slug;
      $timeKeeper[tempSlug] = 0;
      $progressKeeper[tempSlug] = 0;
      // temporary just to display
      $container.append(
        $('<p/>')
          .hide() //FOR DEMO
          .attr("id", tempSlug + "Time")
          .append(document.createTextNode("playback position of " + tempSlug + " : "))
      );
    }


    /**
     * handles the time updates, for each of the slider feature by adding event listener
     * @param {string} key - unique slugID of currentBranch playing
     */
    function attachTimeUpdateHandler(key){
      $('#' + key).bind('timeupdate', function(){
          timeUpdateHandler(key);
      })
    }

    // helper for attachTimeUpdateHandler
    function timeUpdateHandler(key){
      var currentVideo = document.getElementById(key);
      $timeKeeper[key] = currentVideo.currentTime;
      $progressKeeper[key] = ($progressKeeper[key] < $timeKeeper[key])? $timeKeeper[key] : $progressKeeper[key];
      // this updates the sliders value everytime the video progresses
      document.getElementById(key + 'Slider').value = ($timeKeeper[key] / $branchedVideos[key].length) * 100;
      // temporary just to display current time and max time on top of video
      $('#' + key + 'Time').html("playback position of " + key + " : " + currentVideo.currentTime + " // maxprogress: " + $progressKeeper[key]);
      var val = ($('#' + key + 'Slider').val() - $('#' + key + 'Slider').attr('min')) / ($('#' + key + 'Slider').attr('max') - $('#' + key + 'Slider').attr('min'));
      $('#' + key + 'SliderDiv').removeClass('start-slider');
      $('#' + key + 'SliderDiv').addClass('selected-slider');
      $('#' + key + 'Slider').css({'background-image':
        '-webkit-gradient(linear, left top, right top, '
        + 'color-stop(' + val + ', #1BB1FF), '
        + 'color-stop(' + val + ', #000000))'
      });

      var lengthTime = $branchedVideos[key].length;
      var minsEnd = Math.floor(lengthTime / 60);
      var secondsEnd = Math.floor(lengthTime % 60);
      if (secondsEnd < 10){
        secondsEnd = "0"+ secondsEnd;
      }
      var textEnd = minsEnd + ':' + secondsEnd;
      var currentTime = currentVideo.currentTime;
      var minsStart = Math.floor(currentTime /60);
      var secondsStart = Math.floor(currentTime %60);
      if (secondsStart < 10){
        secondsStart = "0"+ secondsStart;
      }
      var textStart = minsStart + ':' + secondsStart;
      var time = document.getElementById(key + 'TimeText');
      time.innerHTML = textStart + '/' + textEnd;

    }




    /**
     * adds a button to full screen whole div  // might not be necessary for now
     * on click it will fullscreen the entire div, including the button
     * @param {string} key - unique slugID of currentBranch playing
     */
    function addFullScreenButton(key){
      $('#' + key + 'Div').append(
        $('<button/>')
          .hide() // FOR DEMO
          .attr({
              type: "button",
              id: key + "Button"
            })
          .append(document.createTextNode(key + "FS"))
          .css({
              "position": "absolute",
              "z-index": 1,
              "left": "90%",
              "top": "90%"
            })
          .on('click', function(){
              if (
                  document.fullscreenElement ||
                  document.webkitFullscreenElement ||
                  document.mozFullScreenElement ||
                  document.msFullscreenElement
                ) {// this exits full fullscreen
                  if (document.exitFullscreen) {
                    document.exitFullscreen();
                  } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                  } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                  } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                  }
                } else {// this enters full screen
                  element = document.getElementById(key+"Div");
                  if (element.requestFullscreen) {
                    element.requestFullscreen();
                  } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                  } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                  } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                  }
                }
              }
            )
        );
    }


    // EDITED
    // for html Videos: attach all of them to the screen but hide all, handles timeupdate
    for(var key in $branchedVideos){
      var videoURL = $branchedVideos[key].sourceFiles[0].src;
      // creates each div, each containing each video
      $container.append(
        $('<div/>')
          .attr({
              id: key + "Div",
            })
          .css({
             'line-height' : 0
            })
          // .append(document.createTextNode(key + "Div")) FOR DEMO
          .append(
              $('<video/>')
                .attr({
                    id: key,
                    src: videoURL,
                    frameborder: 0
                  })
                .on('ended', function(){
                  $('#pause-button').hide();
                  $('#play-button').show();
                })
            )
          .hide()
      );
      attachTimeUpdateHandler(key);
      addFullScreenButton(key);
      $('#' + key)[0].autoplay = true;
      $('#' + key).get(0).pause();
    }


    // given slug in the editor, shows the main video
    var mainSlug = this.options.mainBranchedVideo.mainBranchSlug;
    var mainBranchVideo = document.getElementById(mainSlug + "Div");
    $(mainBranchVideo).show();
    mainBranchVideo.preload = "auto";
    currentVideoPlaying = mainSlug;


    /**
     * handles creation of branch interactions
     * @param {string} currSlug - unique slugID of currentBranch playing
     * @param {int} j - current iteration, identify which subranch from currentBranch
     */
    function processSubBranches(currSlug, j){
      var currentVideo = document.getElementById(currSlug);
      var startTime = $branchedVideos[currSlug].subBranches[j].branchTimeFrom;
      var endTime = $branchedVideos[currSlug].subBranches[j].branchTimeTo;
      var goToSlug = $branchedVideos[currSlug].subBranches[j].branchSlug;
      var currSubBranch = $branchedVideos[currSlug].subBranches[j];
      var shouldShow = true;
      var currID = "";
      $('#' + currSlug).bind('timeupdate', function(){
        if (currentVideo.currentTime > startTime && currentVideo.currentTime < endTime && shouldShow){
          currID = createBubble(currSlug,j);
          shouldShow = false;
        } else if(currentVideo.currentTime > endTime && !shouldShow || currentVideo.currentTime < startTime && !shouldShow){
          shouldShow = true;
          //document.getElementById(currID).style.display = "none";
          $('#' + currID).hide();
        }
      })
    }

    // try adding event listeners
    for(var key in $branchedVideos){
      var numOfSubBranches = $branchedVideos[key].subBranches.length;
      for (var j=0; j<numOfSubBranches ; j++){
        processSubBranches(key, j);
      }
    }

    // NEW IMPLEMENTATION
/*
    function processSubBranches(currSlug){
      var len = $branchedVideos[currSlug].subBranches.length;
      for (var j = 0; j < len ; j++){
        var currentVideo = document.getElementById(currSlug);
        var startTime = $branchedVideos[currSlug].subBranches[j].branchTimeFrom;
        var endTime = $branchedVideos[currSlug].subBranches[j].branchTimeTo;
        var goToSlug = $branchedVideos[currSlug].subBranches[j].branchSlug;
        var currSubBranch = $branchedVideos[currSlug].subBranches[j];
        var shouldShow = true;
        var currID = "";
        if (currentVideo.currentTime > startTime && currentVideo.currentTime < endTime && shouldShow){
          console.log('button should show');
          currID = createBubble(currSlug,j);
          shouldShow = false;
        } else if(currentVideo.currentTime > endTime && !shouldShow){
          shouldShow = true;
          $('#' + currID).hide();
        }
      }
    }


    for(var key in $branchedVideos){
      $('#' + key).bind('timeupdate', function(){
          processSubBranches(key);
      }); // end of jquery
    }
*/
    /**
     * helper function to handle jumping from one branch to another
     * @param {string} currSlug - unique slugID of currentBranch playing, (Jump From)
     * @param {string} nextSlug - unique slugID of nextBranch we want to play, (Jump To)
     */
    function jump(currSlug, nextSlug){
      stopVideo(currSlug);
      playVideo(nextSlug);
    }

    // helper function for jump
    // pauses and hides current video
    function stopVideo(slug){
      $('#' + slug).get(0).pause();
      $('#' + slug + "Div").hide();
      $('#' + slug + 'SliderDiv').attr('class', 'unselected-slider');
    }


    // helper function for jump
    // shows and plays next video
    function playVideo(slug){
      currentVideoPlaying = slug;
      $('#pause-button').show();
      $('#play-button').hide();
      $('#' + slug + "Div").show();
      $('#' + slug).get(0).play();
      $('#' + slug + 'SliderDiv').attr('class', 'selected-slider');
      // should place this inbetween show and play from above, but for readability temporarily here
      if (// if current is full screen, the jump has to be full screen too
          document.fullscreenElement ||
          document.webkitFullscreenElement ||
          document.mozFullScreenElement ||
          document.msFullscreenElement
        ){
          var element = document.getElementById(slug+"Div");

          if (document.exitFullscreen) {
            document.exitFullscreen();
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
          } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
          } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
          }

          if (element.requestFullscreen) {
            element.requestFullscreen();
          } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
          } else if (element.webkitRequestFullscreen) {
            var tempFun = function(param){element.webkitRequestFullscreen(param)};
            setTimeout(tempFun, 1000, Element.ALLOW_KEYBOARD_INPUT);
          } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
          }
        }
    }


    // creates a return bubble, called when the button created by
    // createBubble function is clicked
    /**
     * creates a return bubble,
     * called when the button created by createBubble function is clicked
     * @param {string} currSlug - the slug that we are leaving and want to return to
     * @param {string} nextSlug - the slug we are going to and want to return from
     */
    function createReturnBubble(currSlug, goToSlug){
      // actually create bubble
      $('#' + goToSlug + 'Div').append(
        $('<button/>')
          .attr({
              type: 'button',
              class: 'branch-button'
            })
          .css({
              'position': 'absolute',
              'z-index': 2147483647,
              'left': '' + 28 + '%',
              'top': '' + 28 + '%'
            })
          .append(document.createTextNode("would you like to go back to " + currSlug))
          .click(function(){
              $(this).hide();
              jump(goToSlug, currSlug);
          })
      );
      $('#pause-button').hide();
      $('#play-button').show();
    }


    /**
     * creates a button from start time to end time when called
     * @param {string} currSlug - unique slugID of currentBranch playing
     * @param {int} j - current iteration, identify which subranch to jump to
     * @return {string} button ID so that we can remove later on
     */
    function createBubble(currSlug, j){
      var currSubBranch = $branchedVideos[currSlug].subBranches[j];
      var goToSlug = currSubBranch.branchSlug;
      var xPos = currSubBranch.bubble.positionX;
      var yPos = currSubBranch.bubble.positionY;
      var text = currSubBranch.bubble.text;
      var id = goToSlug + xPos + yPos;
      var currButton = document.getElementById(id);
      if (currButton != null){
        // if it exists just show
        //console.log('already exists, no need to create just show');
        currButton.style.display = 'inline';
        return id;
      }
      $('#' + currSlug + 'Div').append(
        $('<button/>')
          .attr({
              type: "button",
              id: id,
              class: 'branch-button'
            })
          .css({
              "position": "absolute",
              "z-index": 2147483647,
              "left": "" + xPos + "%",
              "top": "" + yPos + "%"
            })
          .append(document.createTextNode(text))
          .click(function(){
              $(this).hide();
              //handle return
              $('#' + goToSlug + 'SlantedBar').attr('class', 'played-slanted-bar');
              $('#' + goToSlug).on('ended', function(){createReturnBubble(currSlug, goToSlug)});
              //handle current jump
              jump(currSlug, goToSlug);
            })
      );
      return id;
    }





// NAVIGATION BAR SECTION


    /**
     * helper function that attaches slider to video
     * @param {string} slug - unique slugID of currentBranchedVideo playing
     */
    function attachVideoAndSlider(slug){
        var slider = document.getElementById(slug + "Slider");
        slider.oninput = function(){
          document.getElementById(slug).currentTime = (slider.value / slider.max) * $branchedVideos[slug].length;
          if(currentVideoPlaying != slug){
            jump(currentVideoPlaying, slug);
          }
        }
        // ontimeupdate of videos that changes slider value is on another function
        // this only updates the video time if slider input is there
    }

    /**
     * helper function that draws the unused bar where it branches from
     * @param {double} x1 - start X
     * @param {double} y1 - start Y
     * @param {double} x2 - end X
     * @param {double} y2 - end Y
     */
    function drawSlantedBar(par, x1, y1, x2, y2 , lastLev, level){
      var div = document.getElementById('seeker');
      var barDiv = document.createElement('div');
      barDiv.className = 'slanted-bar';
      barDiv.id = par + 'SlantedBar';
      barDiv.style.position = 'absolute';
      var bar = document.createElement('input');
      var width = 15 * lastLev;
      bar.type = 'range';
      bar.min = 0;
      bar.max = 1;
      bar.value = 0;
      bar.style.position = 'absolute';
      bar.style.width = width + 8 + 'px';
      var slantedDiff = Math.abs(Math.sqrt(((Math.pow((width/2),2))/2)));
      bar.style.left = x1 - (width/2) + 4 + slantedDiff + 'px'; // left refers to where the x would have been if it were horizontal
      if (level > 0){
        bar.style.transform = 'rotate(-45deg)';
      } else {
        bar.style.transform = 'rotate(45deg)';
      }
      bar.style.top = y2 + (width/2)  +  'px'; //top refers to center of slider
      if (width > 16){ //fast solution
        bar.style.top = y2 + (width/2) -1  +  'px';
        bar.style.width = width + 12 + 'px';
        bar.style.left = x1 - (width/2) + 4 + slantedDiff + 'px';
        slantedDiff += 2;
      }
      if (level < 0){
        bar.style.top = y2 - (width/2) + 'px';
      }

      bar.style.zIndex = '1';
      //console.log(bar);
      barDiv.appendChild(bar);
      div.appendChild(barDiv);
      return slantedDiff * 2 + 8 ;
    }


    // draws each slider for each subbranch
    /**
     * helper function that creates a slider for each video
     * @param {string} par - unique slugID of the slider we are creating
     * @param {double} xpos - x position of where we want slider to be
     * @param {double} ypos - y position of where we want slider to be
     * @param {int} level - the level we want to draw, multiplyer for future y positions
     * @return {int} - returns the level after incrementing too keep track
     */
    function draw(par, xpos, ypos, level){
    	//console.log( par + " at " + xpos + " " + ypos);
    	var div = document.getElementById('seeker');
      // create div
      var currSliderDiv = document.createElement('div');
      currSliderDiv.id = par + 'SliderDiv';
      currSliderDiv.className = 'start-unselected-slider';
      currSliderDiv.style.position = 'absolute'; //added
      currSliderDiv.style.top = ypos + 'px'; //  switched from beloed
      currSliderDiv.style.left = xpos +  'px'; // switched from below

      // create slider
      var currSlider = document.createElement("input");
      currSlider.id = par + "Slider";
      currSlider.type = "range";
      currSlider.min = 0;
      currSlider.max = 100;
      currSlider.style.width = 150 + 'px';
      currSlider.value = 0;
      currSlider.style.position = "absolute";
      currSlider.style.zIndex = '5';
      currSliderDiv.appendChild(currSlider);
      div.appendChild(currSliderDiv);
      if (level > 0){
        // if top
        level++;
      } else {
        // if bottom
        level--;
      }

      // create time text
      var lengthTime = $branchedVideos[par].length;
      var mins = Math.floor(lengthTime / 60);
      var seconds = Math.floor(lengthTime % 60);
      if (seconds < 10){
        seconds = "0"+ seconds;
      }
      var para = document.createElement('p');
      var text = document.createTextNode("0:00/" + mins + ':' + seconds);
      para.id = par + 'TimeText';
      para.classList.add('time-text');
      para.style.position = 'absolute';
      para.style.left = xpos + 150 + 5 + 'px';
      para.style.top = ypos - 3 + 'px';
      para.appendChild(text);
      div.appendChild(para);

      // create branch text
      var branchText = document.createElement('p');
      branchText.appendChild(document.createTextNode(par));
      branchText.classList.add('time-text');
      branchText.style.color = "white";
      branchText.style.position = "absolute";
      branchText.style.top = - 10 + 'px';
      if (level < 0 ){
        branchText.style.top = 4 + 'px';
      }

      currSliderDiv.appendChild(branchText);


      // returns level
      return level;
    }


    /**
     * helper function that recursively draws its slider and subranches sliders
     * @param {string} par - unique slugID of the slider we are creating
     * @param {double} xPos - x position of where we want slider to be
     * @param {double} yPos - y position of where we want slider to be
     * @param {int} lev - the level we want to draw, multiplyer for future y positions
     * @param {int} lastLev - the last level, for drawSlantedBar function specifications
     */
    function drawSubBranches(par, xPos, yPos, lev, lastLev){
      if ($branchedVideos[par] == undefined){
          return ; //case where its empty but the subbranch still has 1
        }
	     var len = $branchedVideos[par].subBranches.length;
       var level = lev;
       var addX = drawSlantedBar(par, xPos, yPos, xPos, yPos - 15*level , lastLev, level);
       level = draw(par, xPos + addX ,  yPos-15*level , level);
       attachVideoAndSlider(par);
       for (var i = len-1 ; i >= 0; i--){
          var startTime = $branchedVideos[par].subBranches[i].branchTimeFrom;
          var nextSlug = $branchedVideos[par].subBranches[i].branchSlug;
          var duration = $branchedVideos[par].length;
          var nextXPos = ((startTime / duration) * 150) + addX;
          var lastLevTemp = len - i;
          if (level > 0){
            // if top
            drawSubBranches(nextSlug , xPos + nextXPos , yPos, level++ , lastLevTemp);
          } else {
            // if bottom
            drawSubBranches(nextSlug , xPos + nextXPos , yPos, level-- , lastLevTemp);
          }

        }
    }

    /**
     * creates navigationBar
     * @param {string} mainSlug - unique starting slugID
     */
    function initializeSeeker(mainSlug){
	    // create start bar
      var w = 80; // width of the navbar
      var h = 150; // starting y loc = h/2
      $container.append(
        $('<div/>')
          .attr({
              id: 'tapestry-navbar',
              class: 'main-container'
            })
          .css({
              'position': 'relative',
              'height': h + 'px',
              'width': '100%'
           })
          .append( // all the left controls
            $('<div/>')
              .attr({
                class: 'left-controls'
              })
              .append(
                $('<button/>')
                  .hide()
                  .attr({
                      type: "button",
                      id: "pause-button",
                      class: "pause-button"
                    })
                  .click(function(){
                      $('#' + currentVideoPlaying).get(0).pause();
                      $('#play-button').show();
                      $(this).hide();
                    })
              )
              .append(
                $('<button/>')
                  .attr({
                      type: "button",
                      id: "play-button",
                      class: "play-button"
                    })
                  .click(function(){
                      $('#' + currentVideoPlaying).get(0).play();
                      $('#pause-button').show();
                      $(this).hide();
                    })
              )
          )
          .append( // all the right controls
            $('<div/>')
              .attr({
                class: 'right-controls'
              })
              .append(
                $('<button/>')
                  .attr({
                      type: "button",
                      id: "speaker-button",
                      class: "speaker-button"
                    })
              )
              .append(
                $('<button/>')
                  .attr({
                      type: "button",
                      id: "settings-button",
                      class: "settings-button"
                    })
              )
              .append(
                $('<button/>')
                  .attr({
                      type: "button",
                      id: "full-screen-button",
                      class: "full-screen-button"
                    })
              )
          )
          .append(// middle controls
            $('<div/>')
              .attr({
                id:"seeker",
                //class: 'middle-controls'
                })
              .css({
                'position': 'relative',
                'top': h/2 + 'px',
                'left': 75 +'px',
                'width': 70 + '%',
                'z-index': 10
                })
              .append(
                $('<div/>') //main slider div
                  .attr({
                    class: 'start-slider',
                    id: mainSlug + "SliderDiv"
                    })
                  .css({
                    'position': 'absolute',
                    'width': 100 + '%',
                    'z-index': 10
                    })
                  .append( // appending the actual slider
                    $('<input/>')
                      .attr({
                        id: mainSlug + "Slider",
                        type: 'range',
                        min: '0',
                        max: '100',
                        value: '0'
                        })
                      .css({
                        'position': 'absolute',
                        'z-index': 10,
                        'width': '100%'
                        })
                        .change(function () {
                          var val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));
                          $('#' + mainSlug + 'SliderDiv').removeClass('start-slider');
                          $('#' + mainSlug + 'SliderDiv').addClass('selected-slider');
                          $(this).css({'background-image':
                          '-webkit-gradient(linear, left top, right top, '
                          + 'color-stop(' + val + ', #1BB1FF), '
                          + 'color-stop(' + val + ', #000000))'
                          });
                      })
                    )
              ) //end of append slider input
              .append(
                $('<p/>')
                  .attr({
                      id: mainSlug + "TimeText",
                      value: '0:00/0:00',
                      class: 'time-text'
                    })
                  .css({
                      'position': 'absolute',
                      'width': 50 + 'px',
                      'top': -3 + 'px',
                      'right': -10 + '%',
                      'z-index': 10
                    })
                  .html('0:00/0:00')
              ) // end of append timetext
          )
      );
      attachVideoAndSlider(mainSlug);
      // handle subranches

      var temp_len = $branchedVideos[mainSlug].subBranches.length;
      var even_start = temp_len -1; // last index
      var odd_start = temp_len -1; // last index
      //console.log(even_start % 2);
      if (even_start % 2 == 0){ // if even index is last
         odd_start--;
      } else { // if odd index is last
        even_start--;
      }

      // do all evens which is top
      var level = 1;
      for (var temp_i = even_start; temp_i>=0 ; temp_i-= 2){
        var startTime = $branchedVideos[mainSlug].subBranches[temp_i].branchTimeFrom;
        var nextSlug = $branchedVideos[mainSlug].subBranches[temp_i].branchSlug;
        var duration = $branchedVideos[mainSlug].length;
        var mainXLoc = ((startTime / duration) * $('#' + mainSlug + 'SliderDiv').width() ) + 5;
        //console.log(nextSlug + ': ');
        var lastLevTemp = temp_len - temp_i;
        if (temp_i != temp_len -1){
          lastLevTemp--;
        }
        drawSubBranches(nextSlug, mainXLoc, 0,level , lastLevTemp);
        level++;
      }

      // do all odds which is bottom
      var level = -1;
      for (var temp_i = odd_start; temp_i>=0 ; temp_i-= 2){
        var startTime = $branchedVideos[mainSlug].subBranches[temp_i].branchTimeFrom;
        var nextSlug = $branchedVideos[mainSlug].subBranches[temp_i].branchSlug;
        var duration = $branchedVideos[mainSlug].length;
        var mainXLoc = ((startTime / duration) * $('#' + mainSlug + 'SliderDiv').width()  ) + 5;
        //console.log(nextSlug + ': ');
        var lastLevTemp = temp_len - temp_i;
        if (temp_i != temp_len -1){
          lastLevTemp--;
        }
        drawSubBranches(nextSlug, mainXLoc, 0,level , lastLevTemp);
        level --;
      }

    }

    initializeSeeker(mainSlug);





    // just temporary text for main slug branch
    /* FOR DEMO
    $container.append('<div class="greeting-text">' + this.options.mainBranchedVideo.mainBranchSlug + '</div>');
*/
  };
  return C;
})(H5P.jQuery);
