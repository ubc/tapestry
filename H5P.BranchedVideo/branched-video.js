var H5P = H5P || {};

H5P.BranchedVideo = (function ($) {
  /**
   * Constructor function.
   */
  function C(options, id) {
    this.$ = $(this);
    // Extend defaults with provided options
    this.options = $.extend(true, {}, {
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
    var self = this;
    //$container.css({'padding-top': (screen.width / screen.heigh)*100 + '%'});
    // BRANCHES
    function Branch(par){
      this.slug = par.slug;
      this.title = par.title;
      this.description = par.description;
      this.type = '';
      this.videoLength = par.length;
      this.currentTime = 0.00;
      this.watchedTime = 0.00;
      this.nodes = [];  // array of node objects
      //this.sources = []; //array of source objects
      this.source = par.sourceFiles[0].src; //assume this is source for now
      //  video part
      this.createVideoDivHTML = function(){
        var videoDiv = document.createElement('div');
        videoDiv.id = 'tapestry-wrapper-video-' + this.slug;
        videoDiv.className = 'tapestry-video-container';
        videoDiv.style.position = 'relative';
        var video = document.createElement('video');
        video.id = 'tapestry-video-' + this.slug;
        video.src = this.source;
        video.frameborder = 0;
        video.controls = false;
        videoDiv.appendChild(video);
        return videoDiv;
      }
      // if we dont append it, can't call get documentByID
      $container.append(this.createVideoDivHTML());

      this.getVideoDivHTML = function(){
        return document.getElementById('tapestry-wrapper-video-' + this.slug);
      }
      this.getVideoHTML = function(){
        return document.getElementById('tapestry-video-' + this.slug);
      }

      //  slider part
      this.createSliderDivHTML = function(){
        var sliderDiv = document.createElement('div');
        sliderDiv.id = 'tapestry-wrapper-slider-' + this.slug;
        sliderDiv.className = 'tapestry-start-unselected-slider';
        sliderDiv.style.position = 'absolute';
        var slider = document.createElement('input');
        slider.id = 'tapestry-slider-' + this.slug;
        slider.type = 'range';
        slider.value = 0;
        slider.min = 0;
        slider.max = 100;
        slider.style.zIndex = 5;
        slider.style.position = 'absolute';
        slider.style.width = '100%';
        sliderDiv.appendChild(slider);
        // create branch text
        var branchText = document.createElement('p');
        branchText.appendChild(document.createTextNode(this.slug));
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
        var para = document.createElement('p');
        var text = document.createTextNode("0:00/" + mins + ':' + seconds);
        para.id = 'tapestry-time-text-' + this.slug;
        para.classList.add('tapestry-time-text');
        para.style.position = 'absolute';
        para.appendChild(text);
        sliderDiv.appendChild(para);

        // return it
        return sliderDiv;
      }
      this.sliderDivHTML = this.createSliderDivHTML();

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

    // handles the nodes creation
      this.createAllNodes = function(){
        // sort it here
        // give type here
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
      this.nodes = this.createAllNodes(); // gotta call it
      this.getNodes = function(){
        return this.nodes;
      }


      // FUNCTIONS FOR THE ACTUAL BRANCH

      // hide video div
      this.stopVideo = function(){
        var videoDiv = this.getVideoDivHTML();
        videoDiv.style.display = 'none';
        var video = this.getVideoHTML();
        video.pause();
      }
      // show video div
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

    } // end of branch



    // NODE
    function Node(subBranch, parentSlug){
      if (subBranch.branchSlug == undefined){return null;}
      this.startTime = subBranch.branchTimeFrom;
      this.endTime = subBranch.branchTimeTo;
      this.branchSlug = subBranch.branchSlug;
      this.link =  new Link(subBranch.bubble, this.branchSlug);
      this.getNodeHTML = function(){
        return this.link.getLinkHTML();
      }
      // functions to show and hide
      this.showLink = function(){
        var linkHTML = this.getNodeHTML();
        linkHTML.style.display='block';
      }
      this.hideLink = function(){
        var linkHTML = this.getNodeHTML();
        linkHTML.style.display='none';
      }
      // BUBBLE
      function Link(bubble, slug){
        this.text = bubble.text;
        this.style = bubble.style;
        this.color = bubble.color;
        this.positionX = bubble.positionX;
        this.positionY = bubble.positionY;
      // returns the HTML component
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
        this.linkHTML = this.createLinkHTML();
        this.getLinkHTML = function(){
          return this.linkHTML;
        }
      }// end of bubble
    }// end of node




//  INITIALIZE
    var helpMode = false;
    var mainSlug = this.options.mainBranchSlug;
    var currentVideoPlaying = mainSlug;
    // sets background to black
    $container.css({'background-color':'#000001'});
    // create associative array temporarily
    var branched_videos = {};
    // given slug, returns branch
    function getBranch(slug){
      return branched_videos[slug];
    }
    // given slug, creates time text
    function createTimeText(slug){
      var branch = getBranch(slug);
      var lengthTime = branch.videoLength;
      var mins = Math.floor(lengthTime / 60);
      var seconds = Math.floor(lengthTime % 60);
      if (seconds < 10){
        seconds = "0"+ seconds;
      }
      var para = document.createElement('p');
      var text = document.createTextNode("0:00/" + mins + ':' + seconds);
      para.id = 'tapestry-time-text-' + branch.slug;
      para.classList.add('tapestry-time-text');
      para.style.position = 'absolute';
      if (branch.getType() == 'main') {
        para.style.left = 102 + '%';
      } else {
        para.style.left = 115 + '%';
      }
      para.style.top = -3 + 'px';
      para.appendChild(text);
      branch.getSliderDivHTML().appendChild(para);
    }
    // handles jump and jump helpers
    function jump(goToSlug){
      var currentBranch = getBranch(currentVideoPlaying);
      var nextBranch = getBranch(goToSlug);
      var currentSliderDiv = currentBranch.getSliderDivHTML();
      var nextSliderDiv = nextBranch.getSliderDivHTML();
      // hides return link everytime we jump, regardless if we click or not
      var retLink = document.getElementById('tapestry-link-return-' + currentVideoPlaying);
      if(retLink != null){
        retLink.style.display = 'none';
      }
      // handle audio
      var currVid = currentBranch.getVideoHTML();
      var nextVid = nextBranch.getVideoHTML();
      nextVid.volume = currVid.volume;
      //handle bars
      currentSliderDiv.classList.remove('tapestry-start-unselected-slider');
      currentSliderDiv.classList.remove('tapestry-selected-slider');
      currentSliderDiv.classList.add('tapestry-unselected-slider');
      nextSliderDiv.classList.remove('tapestry-start-unselected-slider');
      nextSliderDiv.classList.remove('tapestry-unselected-slider');
      nextSliderDiv.classList.add('tapestry-selected-slider');
      // handle showing/hiding of videos
      currentBranch.stopVideo();
      nextBranch.playVideo();
      currentVideoPlaying = goToSlug;
      // gotta show the play button and hide the pause button
      var playButton = document.getElementsByClassName('tapestry-play-button')[0];
      playButton.style.display = 'none';
      var pauseButton = document.getElementsByClassName('tapestry-pause-button')[0];
      pauseButton.style.display = 'block';
    }
    // gives type to the branch and sets type to itself and all its subranches
    function setTypeBranches(slug, type){
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
    function attachSliders(parentSlug, listOfNodes, w , acc){
      var branch = getBranch(parentSlug);
      var sliderDiv = branch.getSliderDivHTML();
      var duration = branch.videoLength;
      var levelTop = 1;
      var levelBottom = 1;
      for (var i = listOfNodes.length-1;  i >= 0 ; i--){
          //appends the slider to the div
          var nextSlug = listOfNodes[i].branchSlug;
          var nextBranch = getBranch(nextSlug);
          var startTime = listOfNodes[i].startTime;
          var xpos = (startTime/duration) * 100;
          var nextSliderDiv = nextBranch.getSliderDivHTML();
          nextSliderDiv.style.left = xpos + '%';
          if (nextBranch.getType() == 'top'){
            nextSliderDiv.style.top = -15*levelTop + 'px';
            levelTop++;
          } else {
            nextSliderDiv.style.top = 15*levelBottom + 'px';
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
            var tempW = (tempLevel-1)*15;
            slantedBar.style.top = tempW/2 + 'px';
            slantedBar.style.transform = 'rotate(-45deg)';
          } else {
            var tempLevel = levelBottom;
            var tempW = (tempLevel-1)*15;
            slantedBar.style.top = -tempW/2 + 'px';
            slantedBar.style.transform = 'rotate(45deg)';
          }
          slantedBar.style.width = tempW + 3.5*tempLevel + 'px';
          var slantedDiff = Math.abs(Math.sqrt(((Math.pow((tempW/2),2))/2)));
          slantedBar.style.left = -tempW/2 + 3.5 + slantedDiff + 'px';
          var nextSlider = nextBranch.getSliderHTML();
          nextSlider.style.left = slantedDiff * 2 + 3.5*tempLevel+'px';
          nextSliderDiv.style.left = 'calc('+nextSliderDiv.style.left + ' + ' + (acc + slantedDiff) + 'px' + ')';
          // attach slanted bar to div
          slantedBarDiv.appendChild(slantedBar);
          nextSliderDiv.appendChild(slantedBarDiv);
          // arrange branch text and time text
          var branchText = nextBranch.getBranchTextHTML();
          if (nextBranch.getType() == 'top'){
            branchText.style.top = - 12  + 'px';
          } else {
            branchText.style.top = 8 + 'px';
          }
          branchText.style.left = slantedDiff * 2 + 13 + 'px';
          var para = nextBranch.getTimeTextHTML();
          para.style.left = 'calc( 103%  + ' + (slantedDiff*2 + 5*(tempLevel-1)) + 'px )';
          para.style.top = -3 + 'px';
          // recurse
          attachSliders(nextSlug, nextBranch.nodes, 100, acc + slantedDiff*2);
      }
    }
    // attaches listeners for the videos and sliders
    function attachListeners(slug){
      var branch = getBranch(slug);
      var video = branch.getVideoHTML();
      var slider = branch.getSliderHTML();
      var listOfNodes = branch.getNodes();
      var duration = branch.videoLength;
      //video listener
      video.ontimeupdate = function(){
        // updates slider value when video time changes
        var time = video.currentTime;
        var val = (time/duration) * 100; // 100 is max value for sliders
        slider.value = val;
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
        // handles slider color change
        if (branch.getSliderDivHTML().classList.contains('tapestry-start-selected-slider')){
          branch.getSliderDivHTML().classList.remove('tapestry-start-selected-slider');
          branch.getSliderDivHTML().classList.add('tapestry-selected-slider');
        }
        var val = ($('#tapestry-slider-' + slug).val() - $('#tapestry-slider-' + slug).attr('min')) / ($('#tapestry-slider-' + slug).attr('max') - $('#tapestry-slider-' + slug).attr('min'));
        $('#tapestry-slider-' + slug).css({'background-image':
            '-webkit-gradient(linear, left top, right top, '
            + 'color-stop(' + val + ', #1BB1FF), '
            + 'color-stop(' + val + ', #000000))'
          });

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
        time.innerHTML = textStart + '/' + textEnd;

        // removes return text
        var returnLink = document.getElementById('tapestry-link-return-' + slug);
        if (returnLink != null){
          returnLink.style.display = 'none';
        }
      };
      // slider listener
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
        if (slug != currentVideoPlaying){
          jump(slug);
        }
      });
      // for return bubble
      for (var i = 0; i< listOfNodes.length ; i++){
        var tempSlug = listOfNodes[i].branchSlug;
        createReturnLink(slug, tempSlug)
      }
    }
    // creates a return Link - helper function fora attach Listeners
    function createReturnLink(parentSlug, childSlug){
      // create return link
      var currentLink = document.createElement('button');
      currentLink.id = 'tapestry-link-return-' + childSlug;
      currentLink.className = 'tapestry-branch-button';
      currentLink.type = 'button';
      currentLink.innerHTML = 'would you like to return to ' + parentSlug;
      currentLink.style.position = 'absolute';
      currentLink.style.left = '35%';
      currentLink.style.top = '35%';
      currentLink.style.zIndex = 2147483647;
      currentLink.style.display = 'none';
      // adds onclick
      currentLink.onclick = function(){
        jump(parentSlug);
      }
      // attaches it to video div
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
      }
    }
    // attaches listeners for the links/buttons
    function attachNodeListeners(node){
      var link = node.getNodeHTML();
      var goToSlug = node.branchSlug;
      link.onclick = function(){
        var slantedBar = document.getElementById('tapestry-slanted-bar-' + goToSlug);
        slantedBar.classList.remove('tapestry-slanted-bar');
        slantedBar.classList.add('tapestry-played-slanted-bar');
        jump(goToSlug);
      }
    }

    // given list of H5P branched videos, creates all branches
    function createAllBranches(par){
      // CREATE ALL BRANCHES
      for (var i = 0 ; i < par.length ; i++){
        var temp_slug = par[i].slug;
        branched_videos[temp_slug] = new Branch(par[i]);
        var currentBranch = branched_videos[temp_slug];
        $container.append(currentBranch.getVideoDivHTML());
        if (temp_slug != mainSlug){
          currentBranch.stopVideo(); // hide and pause video
        } else { //renders starting navBar
          var mainSlider = currentBranch.getSliderDivHTML();
          mainSlider.classList.remove('tapestry-start-unselected-slider');
          mainSlider.classList.add('tapestry-start-selected-slider');
        }
      }
      // GIVES TYPE TO ALL BRANCHES
      var mainBranch = branched_videos[mainSlug];
      mainBranch.setType('main');
      var mainBranchLON = mainBranch.getNodes();
      for (var i = 0; i<mainBranchLON.length; i++){
        var slug = mainBranchLON[i].branchSlug;
        if(i%2 == 0 ){ //even
          setTypeBranches(slug, 'top');
        } else { // odd
          setTypeBranches(slug, 'bottom');
        }
      }
      // CREATE NAVIGATION BAR FROM BRANCHES
      // creates tapestry-nav-bar div
      var navBar = document.createElement('div');
      navBar.id = 'tapestry-nav-bar';
      navBar.className = 'tapestry-seeker-container';
      navBar.style.position = 'relative';
      navBar.style.height = '150px'; // it should be dynamic??
      navBar.style.width = '100%';
      navBar.style.zIndex = 100;
      $container.append(navBar);
      // attaches main slider
      //var mainBranch = branched_videos[mainSlug];
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
      mainTimeText.style.top = '-3px';
      // attaches all the sliders starting from the end to the main slider
      attachSliders(mainSlug, mainBranch.nodes, 25, 0);
      // DO ALL EVENT LISTENERS
      // video ontimeupdate change slider
      // slider on input change video
      // video ontimeupdate appear/disappear link
      // link on click jump
      for (var key in branched_videos){
          attachListeners(key);
          var lon = branched_videos[key].getNodes();
          for (var i = 0; i < lon.length; i++){
            var node = lon[i];
            attachNodeListeners(node);
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
      pauseButton.style.display = 'none'; // initially hidden
      playButton.onclick = function(){
        var currentVid = getBranch(currentVideoPlaying).getVideoHTML();
        currentVid.play();
        playButton.style.display = 'none';
        pauseButton.style.display = 'block';
      }
      pauseButton.onclick = function(){
        var currentVid = getBranch(currentVideoPlaying).getVideoHTML();
        currentVid.pause();
        pauseButton.style.display = 'none';
        playButton.style.display = 'block';
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
      volumeSlider.style.left = '-42px';
      volumeSlider.style.top = '10px';
      volumeSlider.style.display = 'none';
      volumeButton.onmouseenter = function(){
        volumeSlider.style.display = 'block';
        var currentVid = getBranch(currentVideoPlaying).getVideoHTML();
        var volume = currentVid.volume * 100;
        volumeSlider.value = volume;
      };
      volumeDiv.onmouseleave = function(){volumeSlider.style.display = 'none';};
      volumeSlider.oninput = function(){
        var currentVid = getBranch(currentVideoPlaying).getVideoHTML();
        var volume = volumeSlider.value / 100;
        currentVid.volume = volume;
      }
      volumeDiv.appendChild(volumeSlider);
      volumeDiv.appendChild(volumeButton);
      // SETTINGS
      var settingsButton = document.createElement('button');
      settingsButton.type = 'button';
      settingsButton.className = 'tapestry-settings-button';
      var helpNode = document.createElement('h');
      var helpNodeText = document.createTextNode('help mode enabled');
      helpNode.className = 'tapestry-time-text';
      helpNode.style.display = 'none';
      helpNode.style.position = 'absolute';
      helpNode.style.top = '90%';
      helpNode.style.left = '30%';
      helpNode.appendChild(helpNodeText);
      rightControls.appendChild(helpNode);
      // functions for handling onhover help button
      function getHelpText(id, str){
        var helpTextTemp = document.getElementById(id);
        if (helpTextTemp != null){
          //console.log('get');
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
        //console.log('create');
        return helpNode;
      }
      settingsButton.onclick = function(){
        if (helpMode == false){//currently not help Mode and want to be helpMode
          helpNode.style.display = 'block';
          helpMode = true;
        } else {
          helpNode.style.display = 'none';
          helpMode = false;
        }
      }
      // FULL SCREEN
      var fullScreenButton = document.createElement('button');
      fullScreenButton.type = 'button';
      fullScreenButton.className = 'tapestry-screen-button';
      var seeker = document.getElementById('tapestry-nav-bar');
      function showBar(){seeker.style.opacity = 1;};
      function hideBar(){seeker.style.opacity = 0;}
      var toggleFullScreen = function () {
        if (H5P.isFullscreen) {

          H5P.exitFullScreen();
        } else {

          H5P.fullScreen($container, self);;
        }
      };
      // Respond to enter full screen event
      self.on('enterFullScreen', function () {
        var mainVideo = mainBranch.getVideoHTML();
        var vidHeight = mainVideo.videoHeight;
        var screenHeight = screen.height;
        var difference = vidHeight - screenHeight;
        $container.css({'top': -difference/2 + 'px'});
        seeker.style.top = difference + difference/2 + 5 + 'px';
        hideBar();
        seeker.addEventListener('mouseover', showBar, true);
        seeker.addEventListener('mouseout', hideBar, true);
      });
      // Respond to exit full screen event
      self.on('exitFullScreen', function () {
        $container.css({'top': 0 + 'px'});
        seeker.style.top = '0px';
        seeker.removeEventListener('mouseover', showBar, true);
        seeker.removeEventListener('mouseout', hideBar, true);
        showBar();
      });
      fullScreenButton.onclick = function(){toggleFullScreen()};
      rightControls.appendChild(volumeDiv);
      rightControls.appendChild(settingsButton);
      rightControls.appendChild(fullScreenButton);
      navBar.appendChild(rightControls);

      // HELP EVENTS; on mouseover
      // HELP play button
      playButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-play-button', 'click to play video' );
        temp.style.left = '2%';
        temp.style.top = '60%';
        if (helpMode){
          temp.style.display = 'block';
        }
      }
      playButton.onmouseout = function(){
        getHelpText('tapestry-help-play-button', 'click to play video').style.display = 'none';
      }
      // HELP pause button
      pauseButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-pause-button', 'click to pause video' );
        temp.style.left = '2%';
        temp.style.top = '60%';
        if (helpMode){
          temp.style.display = 'block';
        }
      }
      pauseButton.onmouseout = function(){
        getHelpText('tapestry-help-pause-button', 'click to pause video').style.display = 'none';
      }
      // HELP volume button
      volumeButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-volume-button', 'drag slider to update volume ' );
        temp.style.left = '87%';
        temp.style.top = '60%';
        if (helpMode){
          temp.style.display = 'block';
        }
      }
      volumeButton.onmouseout = function(){
        getHelpText('tapestry-help-volume-button', '').style.display = 'none';
      }
      // HELP settings button
      settingsButton.onmouseover = function(){
        if (helpMode){
          var temp = getHelpText('tapestry-help-settings-button', 'turn off help mode' );
          temp.style.display = 'block';
        } else {
          var temp = getHelpText('tapestry-help-settings-button', 'turn on help mode' );
          temp.style.display = 'block';
        }
        temp.style.left = '87%';
        temp.style.top = '60%';
      }
      settingsButton.onmouseout = function(){
        getHelpText('tapestry-help-settings-button', '').style.display = 'none';
      }
      // HELP fullscreen
      fullScreenButton.onmouseover = function(){
        var temp = getHelpText('tapestry-help-fullScreen-button', 'toggle fullscreen' );
        temp.style.left = '87%';
        temp.style.top = '60%';
        if (helpMode){
          temp.style.display = 'block';
        }
      }
      fullScreenButton.onmouseout = function(){
        getHelpText('tapestry-help-fullScreen-button', '').style.display = 'none';
      }
      // HELP all branches
      function attachOnHoverSlider(slug){
        var currBranch = getBranch(slug);
        var currSlider = currBranch.getSliderHTML();
        // handles enter mouse: sets position
        currSlider.onmouseover = function(){
          var temp = getHelpText('tapestry-help-'+ slug + '-slider', 'click to jump to ' + slug );
          var dom = $container.get(0);
          var rect = dom.getBoundingClientRect();
          var currBranch = getBranch(currentVideoPlaying);
          var diffTop = currBranch.getVideoDivHTML().clientHeight;
          temp.style.left = event.clientX - rect.left  + 'px';
          temp.style.top = event.clientY - (diffTop + rect.top) - 30 + 'px';
          if (H5P.isFullscreen) {
              temp.style.top = event.clientY - diffTop + 40 +  'px';
          }
          if (helpMode){
            temp.style.display = 'block';
          } else {
            temp.style.display = 'none';
          }
        }
        // handles leaving mouse: display = none
        currSlider.onmouseout = function(){
          getHelpText('tapestry-help-' + slug + '-slider', '').style.display = 'none';
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
          var temp = getHelpText('tapestry-help-'+ slug + '-slider', 'click to jump to ' + slug + ' at ' + time );
          var rect = $container.get(0).getBoundingClientRect();
          temp.style.left = event.clientX - rect.left + 'px';
        });
      }
      for (var key in branched_videos){
        attachOnHoverSlider(key);
      }

    }

    createAllBranches(this.options.branchedVideos);

    /* NOTE:
    class="tapestry-slider selected"
    class="tapestry-slider"

    .tapestry-slider.selected > input[type='range']::-webkit-slider-thumb
    .tapestry-slider:not(.selected)
    */

  };
  return C;
})(H5P.jQuery);
