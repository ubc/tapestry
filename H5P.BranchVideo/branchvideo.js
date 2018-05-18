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
            slug: 'slugDefault',
            title: 'titleDefault',
            description: 'descDefault',
            length: 0,
            sourceFiles: {},
            subBranches: {}
          }
        ],
        mainBranchSlug: 'main SLUG'
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

    // initialize and create associative array
    var $main = this;
    var numOfBranches = this.options.mainBranchedVideo.branchedVideos.length;
    console.log("number of branches: " + numOfBranches);
    var i;
    var $branchedVideos = {};
    for (i = 0 ; i < numOfBranches ; i++){
      var tempSlug = this.options.mainBranchedVideo.branchedVideos[i].slug;
      $branchedVideos[tempSlug] = this.options.mainBranchedVideo.branchedVideos[i];
    }



    // for html Videos: attach all of them to the screen but hide all
    for(var key in $branchedVideos){
      var videoURL = $branchedVideos[key].sourceFiles[0].src;
      var branchID = $branchedVideos[key].slug;
      $container.append('<video id="' + branchID + '" class="greeting-image" src="'
      + videoURL + '" frameborder="0" allowfullscreen controls> </video>');
      var currentVideo = document.getElementById(branchID);
      $(currentVideo).hide();
    }


    // given slug in the editor, shows the main video
    var mainSlug = this.options.mainBranchedVideo.mainBranchSlug;
    var mainBranchVideo = document.getElementById(mainSlug);
    $(mainBranchVideo).show();
    mainBranchVideo.preload = "auto";



    var processSubBranches = function(currSlug, j){
      var currentVideo = document.getElementById(currSlug);
      var startTime = $branchedVideos[currSlug].subBranches[j].branchTimeFrom;
      var endTime = $branchedVideos[currSlug].subBranches[j].branchTimeTo;
      var goToSlug = $branchedVideos[currSlug].subBranches[j].branchSlug;
      var currSubBranch = $branchedVideos[currSlug].subBranches[j];
      var shouldShow = true;
      var currID = "";

      currentVideo.addEventListener("timeupdate", function(){
        if (currentVideo.currentTime > startTime && currentVideo.currentTime < endTime && shouldShow){
          console.log("BRANCH NOW TO: " + goToSlug);
          currID = createBubble(currSlug, j);
          console.log("currID: " + currID);
          shouldShow = false;
        } else if(currentVideo.currentTime > endTime && !shouldShow){
          console.log("remove interaction");
          shouldShow = true;
          document.getElementById(currID).style.display = "none";
        }
      }, false);
      console.log("we want to start at: " + startTime + " and end at: " + endTime);
    }


    // try adding event listeners
    for(var key in $branchedVideos){
      var j = 0;
      var numOfSubBranches = $branchedVideos[key].subBranches.length;
      console.log("the number of subranches here is: " + numOfSubBranches);
      for (j=0; j<numOfSubBranches ; j++){
        processSubBranches(key, j);
      }
    }


    // handles jumping from branch to branch
    var jump = function(currSlug, nextSlug){
      var currVid = document.getElementById(currSlug);
      var nextVid = document.getElementById(nextSlug);

      currVid.pause();
      currVid.style.display = "none";
      nextVid.style.display = "inline";
      nextVid.play();
    }


    var createReturnBubble = function(currSlug, goToSlug){
      // currSlug = the slug that we are leaving and want to return to
      // goToSlug = the slug we are going to and return from
      var goToSlugVid = document.getElementById(goToSlug);
      var returnBubble = document.createElement("button");
      returnBubble.type = "button";
      returnBubble.style= 'position:absolute;  z-index:1;';
      returnBubble.style.left = "" + 25 + "%";
      returnBubble.style.top = "" + 25 + "%";
      var returnTextNode = document.createTextNode("would you like to go back to " + currSlug);
      returnBubble.appendChild(returnTextNode);
      $container.append(returnBubble);

      returnBubble.addEventListener('click', function(){
        returnBubble.style.display = "none";
        // jump (from,to) , thats why its reversed
        jump(goToSlug, currSlug);
      });
    }

    // creates a bubble function
    function createBubble(currSlug, j){
      var currSubBranch = $branchedVideos[currSlug].subBranches[j];
      var goToSlug = currSubBranch.branchSlug;
      var xPos = currSubBranch.bubble.positionX;
      var yPos = currSubBranch.bubble.positionY;
      var text = currSubBranch.bubble.text;
      var id = goToSlug + xPos + yPos;
      console.log("/slug: " + goToSlug + " /pos: " + xPos + " " + yPos + " /with text: text" );
      //$container.append('<button type="button" id="'+ id + '" style="position:absolute;  z-index:1; left:' + xPos + '%; top:' + yPos + '%;" >' + text + '</button>');
      var inputBubble = document.createElement("button");
      inputBubble.type = "button";
      inputBubble.id = id;
      inputBubble.style= 'position:absolute;  z-index:1;';
      inputBubble.style.left = "" + xPos + "%";
      inputBubble.style.top = "" + yPos + "%";
      var newTextNode = document.createTextNode(text);
      inputBubble.appendChild(newTextNode);

      inputBubble.addEventListener('click', function(){
        inputBubble.style.display = "none";
        //handle return
        var goToSlugVid = document.getElementById(goToSlug);
        goToSlugVid.onended = function(){createReturnBubble(currSlug, goToSlug)};
        //handle jump
        jump(currSlug, goToSlug);
      });

      $container.append(inputBubble);
      return id;

    }
    $container.append('<div class="greeting-text">' + this.options.mainBranchedVideo.mainBranchSlug + '</div>');

  };



  return C;
})(H5P.jQuery);
