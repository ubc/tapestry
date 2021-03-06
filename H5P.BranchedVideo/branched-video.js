var H5P = H5P || {};

H5P.BranchedVideo = (function ($) {
  /**
   * Constructor function.
   */
  function C(options, id) {

    this.$ = $(this);

    // Extend defaults with provided options
    this.options = $.extend(true, {}, {
        branchedVideos: [],
        mainBranchSlug: ''
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

    /************************************
     * INITIALIZE
     ************************************/

    var self = this;
    self.helpMode = false;
    self.closedCaption = false;
    self.BranchedVideos = {};
    self.currentPlayingSlug = self.options.mainBranchSlug;

    self.isMobile = false;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        self.isMobile = true;
    }

    createAllBranches(this.options.branchedVideos);

    // sets background to black (workaround for full-screen)
    $container.css({'background-color':'#000001'});

    /* Done! Everything after here is supportive */

    /************************************
     * CLASS: BRANCH
     ************************************/
    function Branch(par){

      this.slug = par.slug;
      this.title = decodeHTMLEntities(par.title);
      this.description = par.description;
      this.type = '';
      this.videoLength = par.length;
      this.currentTime = 0.00;
      this.watchedTime = 0.00;
      this.nodes = [];  // array of node objects
      this.playedTime = [[0,0]];

      /************************************
       * VIDEOS
       ************************************/

      this.createVideoDivHTML = function(){
        var videoDiv = document.createElement('div');
        videoDiv.id = 'tapestry-wrapper-video-' + this.slug;
        videoDiv.className = 'tapestry-video-container';
        videoDiv.style.position = 'relative';
        var video = document.createElement('video');
        video.id = 'tapestry-video-' + this.slug;
        video.className = 'tapestry-video-container';
        video.frameborder = 0;
        video.setAttribute('playsinline', 'playsinline');
        video.controls = false;
        videoDiv.appendChild(video);

        // provides source
        var videoSource = document.createElement('source');
        videoSource.type = 'video/mp4';
        videoSource.src = this.source;
        video.appendChild(videoSource);

        // provides vtt
        if(this.ccSource != null){
          var videoVTT = document.createElement('track');
          videoVTT.label = 'english';
          videoVTT.kind = 'subtitles';
          videoVTT.srclang= 'en';
          videoVTT.src = this.ccSource;
          video.appendChild(videoVTT);
          video.textTracks[0].mode = 'hidden';
        }
        return videoDiv;
      }
      this.getVideoDivHTML = function(){
        return document.getElementById('tapestry-wrapper-video-' + this.slug);
      }
      this.getVideoHTML = function(){
        return document.getElementById('tapestry-video-' + this.slug);
      }

      // hide and pause video div
      this.stopVideo = function(){
        var videoDiv = this.getVideoDivHTML();
        videoDiv.style.display = 'none';
        var video = this.getVideoHTML();
        video.pause();
      }
      // show and play video div
      this.playVideo = function(){
        var videoDiv = this.getVideoDivHTML();
        videoDiv.style.display = 'block';
        var video = this.getVideoHTML();
        video.play();
      }
      // sets type of videos
      this.setType = function(text){
        this.type = text;
      }
      // gets type of Videos
      this.getType = function(){
        return this.type;
      }
      // moves closed caption  if exists
      // location(String): 'up', 'down'
      this.moveClosedCaption = function(location){
        var lineVal = 'auto';
        if (location == 'up'){
          lineVal = 1;
          // sets the line value to 1 for the cues, which moves it up
        }
        var track = this.getVideoHTML().textTracks[0];
        if (track){
          for (var x = 0; x < track.cues.length; x++){
            track.cues[x].line = lineVal;
          }
        }
      }
      // updates the attribute playedTime, which is an array of pairs of doubles which represents the watched time
      // @time double: the currentTime of video playing
      this.updatePlayedTime = function(time) {

        var roundedTime = Math.round(time*10)/10; // make it 1 decimal
        var arrayOfPlayedTime = this.getPlayedTime();
        var index = getIndexForCurrentTime();
        updateArrayOfPlayedTime();
        this.playedTime = arrayOfPlayedTime;

        // uses the time parameter for current time
        // gets index of where the current time is in the arrayOfPlayedTime
        // if it doesn't exist, it creates the pair of [currentTime,currentTime+0.1] for current time
        function getIndexForCurrentTime() {
          var length = arrayOfPlayedTime.length;
          for (var i = 0 ; i < length; i++){
            var bottom = arrayOfPlayedTime[i][0];
            var top = arrayOfPlayedTime[i][1];
            if (time <= top + 1 && time >= bottom){
              return i;
            }
          }
          return insertPair();
        }

        // creates a new pair for current time that doesn't exist
        // 2 cases:
        // - checks all the pairs so that the current time is between the current top and next bottom, insert, then sort the rest
        // - or adds it to the back of the arrayOfPlayedTime
        function insertPair() {
          var length = arrayOfPlayedTime.length;
          for (var j = 0; j < length-1; j++){
            var currentTop = arrayOfPlayedTime[j][1];
            var nextBottom = arrayOfPlayedTime[j +1][0];
            if (time > currentTop && time < nextBottom){
              arrayOfPlayedTime.push([roundedTime, roundedTime + 0.1]);
              for (var i = j+1; i < length+1; i++){
                //sorts it
                var temp = arrayOfPlayedTime[length];
                arrayOfPlayedTime[length] = arrayOfPlayedTime[i];
                arrayOfPlayedTime[i] = temp;
              }
              return j+1;
            }
          }
          arrayOfPlayedTime.push([roundedTime,roundedTime + 0.1]);
          return length;
        }

        // uses variable index that was used earlier in the function
        // if the current top is equal or greate than the next bottom, merges it
        function updateArrayOfPlayedTime(){
          var top = arrayOfPlayedTime[index][1];
          if (roundedTime > top){
            arrayOfPlayedTime[index][1] = roundedTime;
          }
          var next = arrayOfPlayedTime[index+1];
          if (next){
            var nextBottom = next[0];
            if(nextBottom < time){
              arrayOfPlayedTime[index][1] = arrayOfPlayedTime[index+1][1];
              arrayOfPlayedTime.splice(index+1, 1);
            }
          }
        }
      }

      /************************************
       * VIDEO PREVIEW
       ************************************/
      this.createVideoPreview = function(){
        var videoPreview = document.createElement('video');
        videoPreview.id = 'tapestry-video-preview-' + this.slug;
        videoPreview.className = 'tapestry-video-preview-normal';
        videoPreview.frameborder = 0;
        videoPreview.controls = false;
        videoPreview.src = this.source;
        return videoPreview;
      }
      this.getVideoPreview = function(){
        return document.getElementById('tapestry-video-preview-' + this.slug);
      }

      /************************************
       * SLIDERS
       ************************************/
      this.createSliderDivHTML = function(){
        var sliderDiv = document.createElement('div');
        sliderDiv.id = 'tapestry-wrapper-slider-' + this.slug;
        sliderDiv.className = 'tapestry-slider';
        sliderDiv.style.position = 'absolute';
        var slider = document.createElement('input');
        slider.id = 'tapestry-slider-' + this.slug;
        slider.type = 'range';
        slider.value = 100;
        slider.min = 0;
        slider.max = 100;
        slider.style.zIndex = 5;
        slider.style.position = 'absolute';
        slider.style.width = '100%';
        sliderDiv.appendChild(slider);
        // create branch text
        var branchText = document.createElement('p');
        branchText.appendChild(document.createTextNode(this.title));
        branchText.id = 'tapestry-branch-text-' + this.slug;
        branchText.classList.add('tapestry-time-text');
        branchText.style.position = "absolute";
        sliderDiv.appendChild(branchText);
        // creates the time text
        var lengthTime = this.videoLength;
        var mins = Math.floor(lengthTime / 60);
        var seconds = Math.floor(lengthTime % 60);
        if (seconds < 10){
          seconds = "0"+ seconds;
        }
        var timeText = document.createElement('p');
        var text = document.createTextNode("0:00 / " + mins + ':' + seconds);
        timeText.id = 'tapestry-time-text-' + this.slug;
        timeText.classList.add('tapestry-time-text');
        timeText.style.position = 'absolute';
        timeText.appendChild(text);
        sliderDiv.appendChild(timeText);

        // return it
        return sliderDiv;
      }

      this.getSliderDivHTML = function(){
        return this.sliderDivHTML;
      }
      this.getSliderHTML = function(){
        return document.getElementById('tapestry-slider-' + this.slug);
      }
      this.getBranchTextHTML = function(){
        return document.getElementById('tapestry-branch-text-' + this.slug);
      }
      this.getTimeTextHTML = function(){
        return document.getElementById('tapestry-time-text-' + this.slug);
      }

      /************************************
       * NODES (BUBBLES)
       ************************************/
      this.createAllNodes = function(){
        // sort it here
        var arr = [];
        for(var i = 0; i < par.subBranches.length; i ++){
          if (par.subBranches[0].branchSlug == undefined){return [];}
          var node = new Node(par.subBranches[i] , this.slug);
          if (node != null){
            arr.push(node);
            var currVideoDiv = this.getVideoDivHTML();
            var currNodeHTML = node.getNodeHTML();
            currVideoDiv.appendChild(currNodeHTML);
          }
        }
        return arr;
      }
      this.getNodes = function(){
        return this.nodes;
      }

      /************************************
       * CITATIONS
       ************************************/
      this.createAllCitationLinks = function(){
        var arr = [];
        if (par.links == undefined){
          return arr;
        }
        for(var i = 0; i < par.links.length; i ++){
          if (par.links[0].branchSlug == undefined){return [];}
          var node = new Node(par.links[i] , this.slug);
          if (node != null){
            arr.push(node);
            var currVideoDiv = this.getVideoDivHTML();
            var currNodeHTML = node.getNodeHTML();
            currNodeHTML.className = 'tapestry-citation-button';
            currVideoDiv.appendChild(currNodeHTML);
          }
        }
        return arr;
      }
      this.getCitationLinks = function(){
        return this.citationLinks;
      }

      // TODO: remove limitation where author must put video source first and vtt second
      this.source = par.sourceFiles[0].src; //assume this is source for now
      if (par.sourceFiles[1] != null){
        this.ccSource = par.sourceFiles[1].src;
      }

      // if we dont append it, can't call get documentByID
      var videoDivHTML = this.createVideoDivHTML();
      $container.append(videoDivHTML);
      this.sliderDivHTML = this.createSliderDivHTML();
      this.nodes = this.createAllNodes();
      this.citationLinks = this.createAllCitationLinks();

      this.getPlayedTime = function() {
        return this.playedTime;
      }

    } // End of Branch()

    /************************************
     * CLASS: NODE
     ************************************/
    function Node(subBranch, parentSlug){

      if (subBranch.branchSlug == undefined) {
        return null;
      }

      this.startTime = subBranch.branchTimeFrom;
      this.endTime = subBranch.branchTimeTo;
      this.branchSlug = subBranch.branchSlug;
      this.link =  new Link(subBranch.bubble, this.branchSlug);

      this.getNodeHTML = function(){
        return this.link.getLinkHTML();
      }
      this.showLink = function(){
        var linkHTML = this.getNodeHTML();
        linkHTML.style.display='block';
      }
      this.hideLink = function(){
        var linkHTML = this.getNodeHTML();
        linkHTML.style.display='none';
      }

    } // End of Node()

    /************************************
     * CLASS: LINK
     ************************************/
    function Link(bubble, slug){

      this.text = bubble.text;
      this.style = bubble.style;
      this.color = bubble.color;
      this.positionX = bubble.positionX;
      this.positionY = bubble.positionY;

      this.createLinkHTML = function(){
        if (slug == undefined){
          return null;
        }
        var currentLink = document.createElement('button');
        currentLink.id = 'tapestry-link-' + slug;
        currentLink.className = 'tapestry-branch-button';
        currentLink.type = 'button';
        currentLink.innerHTML = this.text;
        currentLink.style.position = 'absolute';
        currentLink.style.left = this.positionX + '%';
        currentLink.style.top = this.positionY + '%';
        currentLink.style.zIndex = 2147483647;
        currentLink.style.display = 'none';
        return currentLink;
      }
      this.getLinkHTML = function(){
        return this.linkHTML;
      }

      this.linkHTML = this.createLinkHTML();

    } // End of Link()

    /************************************
     * GENERAL
     ************************************/

    // given slug, returns branch
    function getBranch(slug) {
      return self.BranchedVideos[slug];
    }

    // handles jump and jump helpers
    function jump(goToSlug) {

      var currentBranch = getBranch(self.currentPlayingSlug);
      var nextBranch = getBranch(goToSlug);
      var currentSliderDiv = currentBranch.getSliderDivHTML();
      var nextSliderDiv = nextBranch.getSliderDivHTML();

      // hides return link everytime we jump, regardless if we click or not
      var retLink = document.getElementById('tapestry-link-return-' + self.currentPlayingSlug);
      if(retLink != null){
        retLink.style.display = 'none';
      }

      // handle audio
      var currVid = currentBranch.getVideoHTML();
      var nextVid = nextBranch.getVideoHTML();
      nextVid.volume = currVid.volume;

      // handle closed caption
      if(self.closedCaption){
        if (currVid.textTracks[0]){
          currVid.textTracks[0].mode = 'hidden';
          getBranch(self.currentPlayingSlug).moveClosedCaption('down');
        }
        if (nextVid.textTracks[0]){
          nextVid.textTracks[0].mode = 'showing';
          if (H5P.isFullscreen){
            getBranch(goToSlug).moveClosedCaption('up');
          }
        }
      }

      // handle playback speed
      nextVid.playbackRate = currVid.playbackRate;

      //handle bars
      currentSliderDiv.classList.remove('tapestry-selected-slider');
      nextSliderDiv.classList.add('tapestry-selected-slider');

      // handle showing/hiding of videos
      currentBranch.stopVideo();
      nextBranch.playVideo();
      self.currentPlayingSlug = goToSlug;

      // gotta show the play button and hide the pause button
      var playButton = document.getElementsByClassName('tapestry-play-button')[0];
      playButton.style.display = 'none';
      var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
      pauseButton.style.display = 'block';
    }

    // gives type to the branch and sets type to itself and all its subranches
    function setTypeBranches(slug, type) {

      var branch = getBranch(slug);
      var lon = branch.getNodes();
      branch.setType(type);
      for(var i = 0; i < lon.length ; i++){
        var nextSlug = lon[i].branchSlug;
        setTypeBranches(nextSlug,type)
      }
    }

    //attaches the sliders
    // parameters: parentSlug, listOfNodes
    function attachSliders(parentSlug, listOfNodes, w , acc) {
      var branch = getBranch(parentSlug);
      var sliderDiv = branch.getSliderDivHTML();
      var duration = branch.videoLength;
      var levelTop = 1;
      var levelBottom = 1;
      var spaceBetweenBranches = 20;
      for (var i = listOfNodes.length-1;  i >= 0 ; i--){
          //appends the slider to the div
          var nextSlug = listOfNodes[i].branchSlug;
          var nextBranch = getBranch(nextSlug);
          var startTime = listOfNodes[i].startTime;
          var xpos = (startTime/duration) * 100;
          var nextSliderDiv = nextBranch.getSliderDivHTML();
          nextSliderDiv.style.left = xpos + '%';
          if (nextBranch.getType() == 'top'){
            nextSliderDiv.style.top = -spaceBetweenBranches*levelTop + 'px';
            levelTop++;
          } else {
            nextSliderDiv.style.top = spaceBetweenBranches*levelBottom + 'px';
            levelBottom++;
          }
          nextSliderDiv.style.width = w + '%';
          sliderDiv.appendChild(nextSliderDiv);

          // creates and appends slanted bars
          var slantedBarDiv = document.createElement('div');
          slantedBarDiv.className = 'tapestry-slanted-bar';
          slantedBarDiv.id = 'tapestry-slanted-bar-' + nextSlug;
          var slantedBar = document.createElement('input');
          slantedBar.type = 'range';
          slantedBar.min = 0;
          slantedBar.max = 1;
          slantedBar.style.position = 'absolute';
          if (nextBranch.getType() == 'top'){
            var tempLevel = levelTop;
            var tempW = (tempLevel-1)*spaceBetweenBranches;
            slantedBar.style.top = tempW/2 + 'px';
            slantedBar.style.transform = 'rotate(-45deg)';
          } else {
            var tempLevel = levelBottom;
            var tempW = (tempLevel-1)*spaceBetweenBranches;
            slantedBar.style.top = -tempW/2 + 'px';
            slantedBar.style.transform = 'rotate(45deg)';
          }
          slantedBar.style.width = tempW + 6*tempLevel + 'px';
          var slantedDiff = Math.abs(Math.sqrt(((Math.pow((tempW/2),2))/2)));
          slantedBar.style.left = -tempW/2 + slantedDiff - (0.5*(tempLevel)) + 'px';
          var nextSlider = nextBranch.getSliderHTML();
          nextSlider.style.left = slantedDiff * 2 + 3.5*tempLevel+'px';
          nextSliderDiv.style.left = 'calc('+nextSliderDiv.style.left + ' + ' + (acc + slantedDiff) + 'px' + ')';
          slantedBarDiv.appendChild(slantedBar);
          nextSliderDiv.appendChild(slantedBarDiv);

          // arrange branch text and time text
          var branchText = nextBranch.getBranchTextHTML();
          if (nextBranch.getType() == 'top'){
            branchText.style.top = 1 + spaceBetweenBranches/4  + 'px';
          } else {
            branchText.style.top = 1 - 10 - spaceBetweenBranches/4 + 'px'; //10 here is for the fontsize, need to change if different fonts
          }
          branchText.style.left = slantedDiff * 2 + 5*(tempLevel) + 'px';
          var timeText = nextBranch.getTimeTextHTML();
          timeText.style.left = 'calc( 103%  + ' + (slantedDiff*2 + 6*(tempLevel-1)) + 6 + 'px )';
          timeText.style.top = -4 + 'px';

          // recurse
          attachSliders(nextSlug, nextBranch.nodes, 100, acc + slantedDiff*2);
      }
    }

    // attaches listeners for the videos and sliders
    function attachListeners(slug) {
      var branch = getBranch(slug);
      var video = branch.getVideoHTML();
      var slider = branch.getSliderHTML();
      var listOfNodes = branch.getNodes();
      var duration = branch.videoLength;
      var listOfCitations = branch.getCitationLinks();

      //video ontimeupdate listener
      video.ontimeupdate = function(){
        // updates slider value when video time changes
        var time = video.currentTime;
        var val = (time/duration) * 100; // 100 is max value for sliders
        slider.value = val;
        // slight error in thumb movement due to size of thumb
        if (time < (branch.videoLength / 4)){
          slider.value = val - 2;
        } else  if (time > (3 * branch.videoLength / 4)){
          slider.value = val + 1;
        }

        // handles buttons appearing and disappearing when video time changes
        for (var i = 0; i < listOfNodes.length ; i++){
          var node = listOfNodes[i];
          var start = node.startTime;
          var end = node.endTime;
          if (time >= start && time <= end){
            node.showLink();
          } else {
            node.hideLink();
          }
        }

        // handles citation listeners
        for (var i = 0; i < listOfCitations.length ; i++){
          var citation = listOfCitations[i];
          var start = citation.startTime;
          var end = citation.endTime;
          if (time >= start && time <= end){
            citation.showLink();
          } else {
            citation.hideLink();
          }
        }

        // updates arrayOfPlayedTime
        branch.updatePlayedTime(time);

        var myArray = branch.getPlayedTime();
        var part1 = '';
        var part2 = '';
        var videoLength = branch.videoLength;

        /* TODO: make cross-browser compatible */
        for (var i = 0; i < myArray.length; i++) {
          if( i == 0 ){
            part1 = "color-stop("+ myArray[0][0] / videoLength +", #000000),"
            +"color-stop("+ myArray[0][0] / videoLength +", #1BB1FF),"
            +"color-stop("+ myArray[0][1] / videoLength +", #1BB1FF),"
            +"color-stop("+ myArray[0][1] / videoLength +", #000000)";
          }else{
            part2 += ",color-stop("+ myArray[i][0] / videoLength +", #000000),"
            +"color-stop("+ myArray[i][0] / videoLength +", #1BB1FF),"
            +"color-stop("+ myArray[i][1] / videoLength +", #1BB1FF),"
            +"color-stop("+ myArray[i][1] / videoLength +", #000000)";
          }
        }
        $('#tapestry-slider-' + slug).css('background-image',
        '-webkit-gradient(linear, left top, right top, '+ part1 + part2);

        // handles time text update
        var lengthTime = branch.videoLength;
        var minsEnd = Math.floor(lengthTime / 60);
        var secondsEnd = Math.floor(lengthTime % 60);
        if (secondsEnd < 10){
          secondsEnd = "0"+ secondsEnd;
        }
        var textEnd = minsEnd + ':' + secondsEnd;
        var currentTime = video.currentTime;
        var minsStart = Math.floor(currentTime /60);
        var secondsStart = Math.floor(currentTime %60);
        if (secondsStart < 10){
          secondsStart = "0"+ secondsStart;
        }
        var textStart = minsStart + ':' + secondsStart;
        var time = branch.getTimeTextHTML();
        time.innerHTML = textStart + ' / ' + textEnd;

        // removes return text
        var returnLink = document.getElementById('tapestry-link-return-' + slug);
        if (returnLink != null){
          returnLink.style.display = 'none';
        }
      };

      // video on click listener
      video.onclick = function(){
        if (!video.paused){
          var playButton = document.getElementsByClassName('tapestry-play-button')[0];
          playButton.style.display = 'block';
          var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
          pauseButton.style.display = 'none';
          video.pause();
        } else {
          var playButton = document.getElementsByClassName('tapestry-play-button')[0];
          playButton.style.display = 'none';
          var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
          pauseButton.style.display = 'block';
          video.play();
        }
      }

      // slider listener
      // for non mobile slider listener
      if (self.isMobile == false){
        var valueHover = 0;
        slider.addEventListener('mousemove', function(e){
          valueHover = (e.offsetX / e.target.clientWidth);
        })

        slider.addEventListener('input', function(){
          // updates video current time when slider changes
          var valueTime = valueHover * duration;
          slider.value = valueHover * 100;
          video.currentTime = valueTime;
          // handles select other video sliders
          if (slug != self.currentPlayingSlug){
            jump(slug);
            // handle xAPI
            createXAPIStatement('Seeked', 'seekerBarDifferentVideo');
            return;
          }
          slider.blur();
          // handle xAPI
          createXAPIStatement('Seeked', 'seekerBarSameVideo');
        });
      }

      // for mobile slider listeners
      if (self.isMobile){
        slider.oninput =  function(){
          video.currentTime = slider.value * duration / 100;
          createXAPIStatement('Seeked', 'seekerBarSameVideoMobile');
        }
        slider.onclick = function(){
          if (self.currentPlayingSlug != slug){
            video.currentTime = 0;
            slider.value = 0;
            jump(slug);
          }
        }
      }

      // slanted slider listener, onclick itll jump to that branch
      var slantedBar = document.getElementById('tapestry-slanted-bar-' + slug);
      if (slantedBar){
        slantedBar.childNodes[0].onclick = function(){
          if (self.currentPlayingSlug != slug){
            slantedBar.childNodes[0].style.zIndex = 0;
            slantedBar.classList.remove('tapestry-slanted-bar');
            slantedBar.classList.add('tapestry-played-slanted-bar');
            video.currentTime = 0;
            slider.value = 0;
            jump(slug);
          }
        }
      }

      // creates the return link for all branches
      for (var i = 0; i< listOfNodes.length ; i++){
        var tempSlug = listOfNodes[i].branchSlug;
        createReturnLink(slug, tempSlug)
      }
    }

    // creates a return Link - helper function fora attach Listeners
    function createReturnLink(parentSlug, childSlug) {
      // create return link
      var currentLink = document.createElement('button');
      currentLink.id = 'tapestry-link-return-' + childSlug;
      currentLink.className = 'tapestry-branch-button';
      currentLink.type = 'button';
      currentLink.innerHTML = 'Click to return to ' + parentSlug;
      currentLink.style.position = 'absolute';
      currentLink.style.left = '35%';
      currentLink.style.top = '35%';
      currentLink.style.zIndex = 2147483647;
      currentLink.style.display = 'none';
      currentLink.onclick = function(){
        jump(parentSlug);
        // handle xAPI
        createXAPIStatement('Seeked', 'returnLink');
      }
      var branch = getBranch(childSlug);
      var videoDiv = branch.getVideoDivHTML();
      videoDiv.appendChild(currentLink);

      // appears video on ended
      var video = branch.getVideoHTML();
      video.onended = function(){
        // show return link
        currentLink.style.display = 'block';
        // handle pause and play button
        var playButton = document.getElementsByClassName('tapestry-play-button')[0];
        playButton.style.display = 'block';
        var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
        pauseButton.style.display = 'none';
        // handle xAPI
        createXAPIStatement('Completed');
      }
    }

    // attaches listeners for the links/buttons that jumps to another video
    function attachNodeListeners(node) {
      var link = node.getNodeHTML();
      var goToSlug = node.branchSlug;
      var branch = getBranch(goToSlug);
      link.onclick = function(){
        var slantedBar = document.getElementById('tapestry-slanted-bar-' + goToSlug);
        slantedBar.classList.remove('tapestry-slanted-bar');
        slantedBar.classList.add('tapestry-played-slanted-bar');
        branch.getVideoHTML().currentTime = 0;
        branch.getSliderHTML().value = 0;
        jump(goToSlug);
        // handle xAPI
        createXAPIStatement('Seeked', 'link');
      }
    }

    // attaches listeners for citation links
    function attachCitationListeners(node) {
      var link = node.getNodeHTML();
      var url = node.branchSlug;
      link.onclick = function(){
        getBranch(self.currentPlayingSlug).getVideoHTML().pause();
        var playButton = document.getElementsByClassName('tapestry-play-button')[0];
        playButton.style.display = 'block';
        var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
        pauseButton.style.display = 'none';
        window.open(url, "_blank");
      }
    }

    // given list of H5P branched videos, creates all branches
    function createAllBranches(par) {
      // CREATE ALL BRANCHES
      for (var i = 0 ; i < par.length ; i++){
        var temp_slug = par[i].slug;
        self.BranchedVideos[temp_slug] = new Branch(par[i]);
        var currentBranch = self.BranchedVideos[temp_slug];
        $container.append(currentBranch.getVideoDivHTML());
        if (temp_slug != self.options.mainBranchSlug){
          currentBranch.stopVideo();
        } else {
          var mainSlider = currentBranch.getSliderDivHTML();
          mainSlider.classList.add('tapestry-selected-slider');
          mainSlider.childNodes[0].value = 0;
          // removes play button for main video on ended
          currentBranch.getVideoHTML().onended = function(){
            var playButton = document.getElementsByClassName('tapestry-play-button')[0];
            playButton.style.display = 'block';
            var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
            pauseButton.style.display = 'none';
          }
        }
      }

      // GIVES TYPE TO ALL BRANCHES
      var mainBranch = self.BranchedVideos[self.options.mainBranchSlug];
      mainBranch.setType('main');
      var mainBranchLON = mainBranch.getNodes();
      for (var i = 0; i<mainBranchLON.length; i++){
        var slug = mainBranchLON[i].branchSlug;
        if(i%2 == 0 ){
          setTypeBranches(slug, 'top');
        } else {
          setTypeBranches(slug, 'bottom');
        }
      }

      // CREATE NAVIGATION BAR FROM BRANCHES
      // creates tapestry-nav-bar div
      var navBar = document.createElement('div');
      navBar.id = 'tapestry-nav-bar';
      navBar.className = 'tapestry-seeker-container';
      navBar.style.position = 'relative';
      navBar.style.height = '150px'; // TODO:dynamic?
      navBar.style.width = '100%';
      navBar.style.zIndex = 100;
      $container.append(navBar);

      // attaches main slider
      var mainSliderDiv = mainBranch.getSliderDivHTML();
      mainSliderDiv.style.position = 'relative';
      mainSliderDiv.style.top = 150/2 + 'px'; // half of nav-bar
      mainSliderDiv.style.left = '8%';
      mainSliderDiv.style.width = '70%';
      mainSliderDiv.zIndex = 10;
      navBar.appendChild(mainSliderDiv);

      // arrange branch and time text of main slider
      var mainBranchText = mainBranch.getBranchTextHTML();
      mainBranchText.style.display = 'none';
      var mainTimeText = mainBranch.getTimeTextHTML();
      mainTimeText.style.left = '101%';
      mainTimeText.style.top = '-4px';

      // attaches all the sliders starting from the end to the main slider
      attachSliders(self.options.mainBranchSlug, mainBranch.nodes, 25, 0);
      // create ALL EVENT LISTENERS
      for (var key in self.BranchedVideos){
          attachListeners(key);
          var lon = self.BranchedVideos[key].getNodes();
          for (var i = 0; i < lon.length; i++){
            var node = lon[i];
            attachNodeListeners(node);
          }
          var loc = self.BranchedVideos[key].getCitationLinks();
          for (var j = 0; j < loc.length; j++){
            var citation = loc[j];
            attachCitationListeners(citation);
          }
      }

      // creates left Controls: play button
      var leftControls = document.createElement('div');
      leftControls.className = 'tapestry-left-controls';
      var playButton = document.createElement('button');
      playButton.type = 'button';
      playButton.className = 'tapestry-play-button';
      var pauseButton = document.createElement('button');
      pauseButton.type = 'button';
      pauseButton.className = 'tapestry-pause-button';
      pauseButton.style.display = 'none';
      playButton.onclick = function(){
        var currentVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        currentVid.play();
        playButton.style.display = 'none';
        pauseButton.style.display = 'block';
        // handle xAPI
        createXAPIStatement('Played');
      }
      pauseButton.onclick = function(){
        var currentVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        currentVid.pause();
        pauseButton.style.display = 'none';
        playButton.style.display = 'block';
        // handle xAPI
        createXAPIStatement('Paused');
      }
      leftControls.appendChild(playButton);
      leftControls.appendChild(pauseButton);
      navBar.appendChild(leftControls);

      // creates right controls: volume, settings, fullscreen
      var rightControls = document.createElement('div');
      rightControls.className = 'tapestry-right-controls';

      // VOLUME
      var volumeDiv = document.createElement('div');
      volumeDiv.className= 'tapestry-volume-div';
      var volumeButton = document.createElement('button');
      volumeButton.type = 'button';
      volumeButton.className = 'tapestry-volume-button';
      var volumeSlider = document.createElement('input');
      volumeSlider.className = 'tapestry-volume-slider';
      volumeSlider.type = 'range';
      volumeSlider.min = 0;
      volumeSlider.max = 100;
      volumeSlider.value = 100;
      volumeSlider.style.display = 'none';
      var lastSliderValue = 100;
      volumeButton.onmouseenter = function(){
        volumeSlider.style.display = 'block';
        var currentVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        var volume = currentVid.volume * 100;
        volumeSlider.value = volume;
      };
      volumeDiv.onmouseleave = function(){volumeSlider.style.display = 'none';};
      volumeButton.onmousedown = function() {
        if (volumeSlider.value == 0) {
          //UNMUTE
          volumeSlider.value = lastSliderValue;
        } else {
          //MUTE
          volumeSlider.value = 0;
        }

        volumeSlider.onmousedown();
        volumeSlider.oninput();
      };
      volumeSlider.oninput = function(){
        var currentVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        var volume = volumeSlider.value / 100;

        currentVid.volume = volume;
        if (volume == 0) {
          volumeButton.className = 'tapestry-mute-button';
        } else {
          volumeButton.className = 'tapestry-volume-button';
        }
        var tempVal = volumeSlider.value / volumeSlider.max;
        /* TODO: make cross-browser compatible */
        $('.tapestry-volume-slider').css({'background-image':
            '-webkit-gradient(linear, left top, right top, '
            + 'color-stop(' + tempVal + ', #FFFFFF), '
            + 'color-stop(' + tempVal + ', #606060))'
          });
        volumeSlider.blur();
        // handlexAPI
        createXAPIStatement('Interacted', 'volume');
      }
      volumeSlider.onmousedown = function() {
        var currentVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        lastSliderValue = currentVid.volume * 100;
      }

      volumeDiv.appendChild(volumeSlider);
      volumeDiv.appendChild(volumeButton);

      // SETTINGS
      var settingsButton = document.createElement('button');
      settingsButton.type = 'button';
      settingsButton.className = 'tapestry-settings-button';
      var settingsDiv = document.createElement('div');
      settingsDiv.className = 'tapestry-settings-dropdown-content';
      settingsDiv.style.display = 'none';
      rightControls.appendChild(settingsDiv);

      // playback speed
      var speedButton = document.createElement('button');
      speedButton.type = 'button';
      speedButton.id = 'tapestry-speed-button';
      var speedButtonText = document.createTextNode('Speed');
      speedButton.appendChild(speedButtonText);
      settingsDiv.appendChild(speedButton);

      var speedDiv = document.createElement('div');
      speedDiv.className = 'tapestry-speed-dropdown-content';
      speedDiv.style.display = 'none';
      rightControls.appendChild(speedDiv);

      var speed1 = document.createElement('button');
      var speed1Text = document.createTextNode('0.5');
      speed1.appendChild(speed1Text);
      speedDiv.appendChild(speed1);

      var speed2 = document.createElement('button');
      var speed2Text = document.createTextNode('Normal');
      speed2Text.innerHTML = 'Normal &#10003;';
      speed2.appendChild(speed2Text);
      speedDiv.appendChild(speed2);

      var speed3 = document.createElement('button');
      var speed3Text = document.createTextNode('1.5');
      speed3.appendChild(speed3Text);
      speedDiv.appendChild(speed3);

      var speed4 = document.createElement('button');
      var speed4Text = document.createTextNode('2.0');
      speed4.appendChild(speed4Text);
      speedDiv.appendChild(speed4);

      // multiplier(double):  0.5, 1, 1.5, 2
      function switchSpeed(multiplier){
        speed1.innerHTML = '0.5';
        speed2.innerHTML = 'Normal';
        speed3.innerHTML = '1.5';
        speed4.innerHTML = '2.0';
        switch(multiplier){
          case 0.5:
            getBranch(self.currentPlayingSlug).getVideoHTML().playbackRate = 0.5;
            speedButton.innerHTML = 'Speed : 0.5';
            speed1.innerHTML = '0.5 &#10003;';
            break;
          case 1:
            getBranch(self.currentPlayingSlug).getVideoHTML().playbackRate = 1;
            speedButton.innerHTML = 'Speed : Normal';
            speed2.innerHTML = 'Normal &#10003;';
            break;
          case 1.5:
            getBranch(self.currentPlayingSlug).getVideoHTML().playbackRate = 1.5;
            speedButton.innerHTML = 'Speed : 1.5';
            speed3.innerHTML = '1.5 &#10003;';
            break;
          case 2:
            getBranch(self.currentPlayingSlug).getVideoHTML().playbackRate = 2.0;
            speedButton.innerHTML = 'Speed : 2.0';
            speed4.innerHTML = '2.0 &#10003;';
            break;
          default: console.log('unable to find playback speed of ' + multiplier);
        }
      }

      speed1.onclick = function(){switchSpeed(0.5);}
      speed2.onclick = function(){switchSpeed(1);}
      speed3.onclick = function(){switchSpeed(1.5);}
      speed4.onclick = function(){switchSpeed(2);}

      speedButton.onclick = function(){
        speedDiv.style.display = 'block';
      }

      // help mode
      var helpButton = document.createElement('button');
      helpButton.type = 'button';
      var helpButtonText = document.createTextNode('Help Mode');
      helpButton.appendChild(helpButtonText);
      settingsDiv.appendChild(helpButton);

      helpButton.onclick = function(){
        if (self.helpMode == false){
          helpButton.innerHTML = 'Help Mode &#10003';
          self.helpMode = true;
          // handle xAPI
          createXAPIStatement('Interacted', 'helpModeOn');
        } else {
          helpButton.innerHTML = 'Help Mode';
          self.helpMode = false;
          // handle xAPI
          createXAPIStatement('Interacted', 'helpModeOff');
        }
      }

      // closed caption
      var ccButton = document.createElement('button');
      ccButton.type = 'button';
      var ccButtonText = document.createTextNode('Closed Caption');
      ccButton.appendChild(ccButtonText);
      settingsDiv.appendChild(ccButton);

      ccButton.onclick = function(){
        var currVidHTML = getBranch(self.currentPlayingSlug).getVideoHTML();
        var tracks = currVidHTML.textTracks[0];
        if (tracks == undefined){
          console.log('no closed caption for this video');
          // handle xAPI
          createXAPIStatement('Interacted', 'closedCaptionNotAvailable');
          return ;
        }
        if (self.closedCaption == false){
          tracks.mode = 'showing';
          ccButton.innerHTML = 'Closed Caption &#10003';
          self.closedCaption = true;
          if (H5P.isFullscreen){
            getBranch(self.currentPlayingSlug).moveClosedCaption('up');
          }
          // handle xAPI
          createXAPIStatement('Interacted', 'closedCaptionOn');
        } else {
          tracks.mode = 'hidden';
          ccButton.innerHTML = 'Closed Caption';
          self.closedCaption = false;
          // handle xAPI
          createXAPIStatement('Interacted', 'closedCaptionOff');
        }
      }

      // shows div when we click settings
      settingsButton.onclick = function(){
        if (settingsDiv.style.display == 'none'){
          settingsDiv.style.display = 'block';
        } else {
          settingsDiv.style.display = 'none';
        }
      }

      // removes settings options when we click anything else
      window.onclick = function(event) {
        if (!event.target.matches('.tapestry-settings-button')) {
          settingsDiv.style.display = 'none';
        }
        if (!event.target.matches('#tapestry-speed-button')){
          speedDiv.style.display = 'none';
        }
      }

      // FULL SCREEN
      var fullScreenButton = document.createElement('button');
      fullScreenButton.type = 'button';
      fullScreenButton.className = 'tapestry-big-screen-button';
      var seeker = document.getElementById('tapestry-nav-bar');
      function showBar(){seeker.style.opacity = 1;};
      function hideBar(){seeker.style.opacity = 0;}
      var toggleFullScreen = function () {
        if (H5P.isFullscreen) {
          H5P.exitFullScreen();
          fullScreenButton.className = 'tapestry-big-screen-button';
          // handle xAPI
          createXAPIStatement('Interacted', 'fullScreenOff');
        } else {
          H5P.fullScreen($container, self);
          fullScreenButton.className = 'tapestry-small-screen-button';
          // handle xAPI
          createXAPIStatement('Interacted', 'fullScreenOn');
        }
      };

      // Respond to enter full screen event
      self.on('enterFullScreen', function () {
        var screenHeight = screen.height;
        var vidHeight = getBranch(self.currentPlayingSlug).getVideoHTML().videoHeight * (screen.width / getBranch(self.currentPlayingSlug).getVideoHTML().videoWidth ) ;
        var difference = vidHeight - screenHeight;
        if (difference < 0){
          $container.css({'top': -difference/2 + 'px'});
          seeker.style.top = difference + difference/2 + 5 + 'px';
        } else {
          getBranch(self.currentPlayingSlug).getVideoHTML().style.maxHeight =screen.height + 'px';
          getBranch(self.currentPlayingSlug).getVideoDivHTML().style.maxHeight = screen.height + 'px';
          $container.css({'top': 0 + 'px'});
          seeker.style.top = '-' + seeker.style.height;
        }

        hideBar();
        seeker.addEventListener('mouseover', showBar, true);
        seeker.addEventListener('mouseout', hideBar, true);
        // handle closed caption moving up after entering full screen
        getBranch(self.currentPlayingSlug).moveClosedCaption('up');
      });


      // Respond to exit full screen event
      self.on('exitFullScreen', function () {
        $container.css({'top': 0 + 'px'});
        seeker.style.top = '0px';
        seeker.removeEventListener('mouseover', showBar, true);
        seeker.removeEventListener('mouseout', hideBar, true);
        showBar();
        // handle closed caption moving down after exit full screen
        getBranch(self.currentPlayingSlug).moveClosedCaption('down');
      });
      fullScreenButton.onclick = function(){
        toggleFullScreen()
        fullScreenButton.blur();
      };
      rightControls.appendChild(volumeDiv);
      rightControls.appendChild(settingsButton);
      rightControls.appendChild(fullScreenButton);
      navBar.appendChild(rightControls);

      // ADDING KEYBOARD FUNCTIONALITY
      // stops it from moving the tab down when spacebar
      document.onkeypress = function(e){
        if (e.which == 32){
          e.preventDefault();
        }
      }
      document.onkeyup = function(e){
        var currVid = getBranch(self.currentPlayingSlug).getVideoHTML();
        switch(e.which){
          case 32:
            var playButton = document.getElementsByClassName('tapestry-play-button')[0];
            var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
            if (playButton.style.display == 'none'){
              // means playing, thus we want to pause
              pauseButton.style.display = 'none';
              playButton.style.display = 'block';
              currVid.pause();
            } else {
              // means paused, thus we want to play
              pauseButton.style.display = 'block';
              playButton.style.display = 'none';
              currVid.play();
            }
            createXAPIStatement('Pressed', 'spacebar');
            break;
          case 39:
            currVid.currentTime += 5;
            createXAPIStatement('Pressed', 'rightArrowKey');
            break;
          case 37:
            currVid.currentTime -= 5;
            createXAPIStatement('Pressed', 'leftArrowKey');
            break;
          default:
            createXAPIStatement('Pressed', 'unknownKey:'+e.which);
        }
      }


      // HELP FEATURE
      // function for handling onhover help button
      function getHelpText(id, str){
        var helpTextTemp = document.getElementById(id);
        if (helpTextTemp != null){
          helpTextTemp.innerHTML = str;
          return helpTextTemp;
        }
        var helpNode = document.createElement('h');
        helpNode.id = id;
        helpNode.style.zIndex = 100;
        var helpNodeText = document.createTextNode(str);
        helpNode.className = 'tapestry-help-text';
        helpNode.style.display = 'none';
        helpNode.appendChild(helpNodeText);
        navBar.appendChild(helpNode);
        return helpNode;
      }

      // HELP EVENTS: on mouseover
      // HELP play button
      playButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-play-button', 'Click to play video' );
        temp.style.left = '10px';
        temp.style.top = '60%';
        if (self.helpMode){
          temp.style.display = 'block';
        }
      }
      playButton.onmouseout = function(){
        getHelpText('tapestry-help-play-button', '').style.display = 'none';
      }

      // HELP pause button
      pauseButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-pause-button', 'Click to pause video' );
        temp.style.left = '10px';
        temp.style.top = '60%';
        if (self.helpMode){
          temp.style.display = 'block';
        }
      }
      pauseButton.onmouseout = function(){
        getHelpText('tapestry-help-pause-button', '').style.display = 'none';
      }

      // HELP volume button
      volumeButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-volume-button', 'Drag to change volume' );
        temp.style.right = '80px';
        temp.style.top = '60%';
        if (self.helpMode){
          temp.style.display = 'block';
        }
      }
      volumeButton.onmouseout = function(){
        getHelpText('tapestry-help-volume-button', '').style.display = 'none';
      }

      // HELP fullscreen
      fullScreenButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-fullScreen-button', 'Toggle fullscreen' );
        temp.style.right = '10px';
        temp.style.top = '60%';
        if (self.helpMode){
          temp.style.display = 'block';
        }
      }
      fullScreenButton.onmouseout = function(){
        getHelpText('tapestry-help-fullScreen-button', '').style.display = 'none';
      }

      // HELP all branches' sliders
      function attachOnHoverSlider(slug){
        var currBranch = getBranch(slug);
        var currSlider = currBranch.getSliderHTML();
        // attach all video previews to container
        navBar.appendChild(getBranch(slug).createVideoPreview());
        var videoPreview = getBranch(slug).getVideoPreview();
        var videoPreviewWidth = 200;

        // handles enter mouse: sets position
        currSlider.onmouseover = function(){
          if (self.isMobile){
            return;
          }
          var temp = getHelpText('tapestry-help-'+ slug + '-slider', 'Click to jump to ' + slug );
          var dom = $container.get(0);
          var rect = dom.getBoundingClientRect();
          var currBranch = getBranch(self.currentPlayingSlug);
          var diffTop = currBranch.getVideoDivHTML().clientHeight;
          temp.style.left = event.clientX - rect.left - (videoPreviewWidth/2)  + 'px';
          temp.style.top = event.clientY - (diffTop + rect.top) - 25 + 'px';
          if (H5P.isFullscreen) {
              temp.style.top = event.clientY - diffTop + 45 +  'px';
          }
          temp.style.display = 'block';
          // handles video preview
          videoPreview.className = 'tapestry-video-preview-normal';
          var videoPreviewHeight = videoPreview.videoHeight / videoPreview.videoWidth * videoPreviewWidth;
          if (H5P.isFullscreen){
            videoPreview.style.top = event.clientY - diffTop + 56 - videoPreviewHeight + 'px';
          } else {
            videoPreview.style.top = event.clientY - (diffTop + rect.top) - videoPreviewHeight - 14 + 'px';
          }
          videoPreview.style.left = event.clientX - rect.left - (videoPreviewWidth/2)  + 'px';
          videoPreview.style.display = 'block';
        }

        // handles leaving mouse: display = none
        currSlider.onmouseout = function(){
          getHelpText('tapestry-help-' + slug + '-slider', '').style.display = 'none';
          getBranch(slug).getVideoPreview().style.display = 'none';
        }

        // handles mouse move: change x position AND update time to jump to
        currSlider.addEventListener('mousemove', function(e) {
          var valueHover = (e.offsetX / e.target.clientWidth);
          var valueTime = valueHover * getBranch(slug).videoLength;
          if (valueTime >= getBranch(slug).videoLength){
            valueTime = getBranch(slug).videoLength;
          }
          var min = Math.floor(valueTime / 60);
          var sec = Math.floor(valueTime % 60);
          if (sec < 10 ){  sec = '0' + sec;  }
          var time = min + ':' + sec ;
          if (sec<0 || min < 0){
            time = '0:00';
          }
          if (self.helpMode){
            var temp = getHelpText('tapestry-help-'+ slug + '-slider', 'Click to jump to ' + slug + ' at ' + time );
          } else {
            var temp = getHelpText('tapestry-help-'+ slug + '-slider',  time );
          }
          var rect = $container.get(0).getBoundingClientRect();
          temp.style.left = event.clientX - rect.left - (videoPreviewWidth/2) + 'px';

          // handles video preview
          videoPreview.style.left = event.clientX - rect.left - (videoPreviewWidth/2) + 'px';
          videoPreview.currentTime = valueTime;
        });
      }

      for (var key in self.BranchedVideos){
        attachOnHoverSlider(key);
      }
    }

    /************************************
     * XAPI FUNCTIONALITY
     ************************************/

    // creates XAPI statements
    // verb: string of what verb
    // extra: anything that may be useful for xAPI statements
    // object: H5P instance?
    function createXAPIStatement(verb, extra){
      var xAPIEvent = new H5P.XAPIEvent();
      // set verb
      xAPIEvent.data.statement.verb = {
        'id':'https://w3id.org/xapi/video/verbs/' + verb.toLowerCase(),
        'display' : {
          'en-us' : verb
        }
      };
      // set actor
      xAPIEvent.setActor();
      // set object
      switch(verb){
        case 'Played':
          handleXAPIPlayPause(xAPIEvent, self.currentPlayingSlug, 'play button');
          break;
        case 'Paused':
          handleXAPIPlayPause(xAPIEvent, self.currentPlayingSlug, 'pause button');
          break;
        case 'Seeked':
          handleXAPISeek(xAPIEvent, self.currentPlayingSlug, extra);
          break;
        case 'Completed':
          handleXAPIPlaying(xAPIEvent, verb, self.currentPlayingSlug);
          break;
        case 'Interacted':
          handleXAPIRightControls(xAPIEvent, extra);
          break;
        case 'Pressed':
          handleXAPIKeyboard(xAPIEvent, extra);
          break;
        default:
          console.log("couldn't find verb: " + verb);
          return;
      }
      // set context
      var contentID = '';
      for (var key in window.H5PIntegration.contents){
        // theres only one but not sure how to just get the key other than for each
        contentID = key;
      }

      xAPIEvent.data.statement.context = {
        'extensions' : {
          'http://example.com/slug' : self.currentPlayingSlug,
          'http://example.com/videoTime' : parseInt(getBranch(self.currentPlayingSlug).getVideoHTML().currentTime / 60) +':'+ parseInt(getBranch(self.currentPlayingSlug).getVideoHTML().currentTime % 60),
          'http://example.com/contentID' : contentID
        }
      }
      self.trigger(xAPIEvent);
    }

    // handles play and pause button
    function handleXAPIPlayPause(xapiEvent, slug, component){
      xapiEvent.data.statement.object = {
        'objectType' : 'Activity',
        'id' : 'http://www.example.com/video/' + slug,
        'definition': {
          'type': 'http://adlnet.gov/expapi/activities/interaction',
          'name': {
            'en-us': 'interaction'
          },
          'description' : {
            'en-us' : slug + ' video interacted with ' + component
          }
        }
      }
    }

    // handles when we seek to different parts of videos,
    // whether it be by link, return link, seeker to the same video or seeker to another videos
    // type: 'link', 'returnLink' , 'seekerBarSameVideo', 'seekerBarDifferentVideo',
    function handleXAPISeek(xapiEvent, slug, type){
      xapiEvent.data.statement.object = {
        'objectType' : 'Activity',
        'id' : 'http://www.example.com/video/' + slug,
        'definition': {
          'type': 'http://adlnet.gov/expapi/activities/interaction',
          'name': {
            'en-us': 'interaction'
          },
          'description' : {
            'en-us' : 'seeked to ' + slug + ' video with  '+ type
          }
        }
      }
    }

    // handles video ontime update and video on ended
    // verb(string): ['Completed']
    function handleXAPIPlaying(xapiEvent, verb, slug){
      // handle verb
      xapiEvent.data.statement.verb = {
        'id':'http://adlnet.gov/expapi/verbs/' + verb.toLowerCase(),
        'display' : {
          'en-us' : verb
        }
      };
      // handle object
      xapiEvent.data.statement.object = {
        'objectType' : 'Activity',
        'id' : 'http://www.example.com/video/' + slug,
        'definition': {
          'type': 'http://adlnet.gov/expapi/activities/interaction',
          'name': {
            'en-us': 'interaction'
          },
          'description' : {
            'en-us' : slug + 'video was ' + verb
          }
        }
      }
    }

    //handles right controls like full volume, settings and full screen
    // type(String) : ['volume', 'fullScreenOff', 'fullScreenOn',  'closedCaptionOn',
    //                 'closedCaptionOff','closedCaptionNotAvailable', 'helpModeOn', 'helpModeOff']
    function handleXAPIRightControls(xapiEvent, type){
      // handle verb
      xapiEvent.data.statement.verb = {
         'id':'http://adlnet.gov/expapi/verbs/interacted',
         'display' : {
           'en-us' : 'Interacted'
         }
        };
     // handle object
     xapiEvent.data.statement.object = {
         'objectType' : 'Activity',
         'id' : 'http://www.example.com/button/' + type,
         'definition': {
           'type': 'http://adlnet.gov/expapi/activities/interaction',
           'name': {
             'en-us': 'interaction'
           },
           'description' : {
             'en-us' : 'user clicked ' + type + 'button'
           }
         }
       }
     }

    // handles when user presses 'spacebar', '> arrow key', '< arrow key'
    // key(string) : 'spacebar' , 'leftArrowKey', 'rightArrowKey', 'unknownKey:__'
    // unknown key is to see if users try to do some sort of keyboard interaction that we haven't implemented
    function handleXAPIKeyboard(xapiEvent, key){
      // handle verb
      xapiEvent.data.statement.verb = {
        'id':'http://future-learning.info/xAPI/verb/pressed',
        'display' : {
          'en-us' : 'pressed'
        }
      };
      // handle object
      xapiEvent.data.statement.object = {
        'objectType' : 'Activity',
        'id' : 'http://www.example.com/keyboard/' + key,
        'definition': {
          'type': 'http://adlnet.gov/expapi/activities/interaction',
          'name': {
            'en-us': 'interaction'
          },
          'description' : {
            'en-us' : 'user clicked ' + key + ' button'
          }
        }
      }
    }

  /************************************
   * HELPERS
   ************************************/

    //Helper used to escape all special HTML characters
    function decodeHTMLEntities (str) {
        if(str && typeof str === 'string') {
            // strip script/html tags
            str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
            str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
            var element = document.createElement('div');
            element.innerHTML = str;
            str = element.textContent;
            element.textContent = '';
        }

        return str;
    }

  };
  return C;
})(H5P.jQuery);
