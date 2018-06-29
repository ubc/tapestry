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
        videoDiv.className = '';
        var video = document.createElement('video');
        video.id = 'tapestry-video-' + this.slug;
        video.src = this.source;
        video.frameborder = 0;
        video.controls = true;
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
        sliderDiv.className = '';
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
        return sliderDiv;
      }
      this.sliderDivHTML = this.createSliderDivHTML();

      this.getSliderDivHTML = function(){
        return this.sliderDivHTML;
      }
      this.getSliderHTML = function(){
        return document.getElementById('tapestry-slider-' + this.slug);
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
        videoDiv.style.display = 'inline';
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
        linkHTML.style.display='inline';
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
    var mainSlug = this.options.mainBranchSlug;
    var currentVideoPlaying = mainSlug;
    // create associative array temporarily
    var branched_videos = {};
    // given slug, returns branch
    function getBranch(slug){
      return branched_videos[slug];
    }
    // handles jump and jump helpers
    function jump(goToSlug){
      var currentBranch = getBranch(currentVideoPlaying);
      var nextBranch = getBranch(goToSlug);
      currentBranch.stopVideo();
      nextBranch.playVideo();
      currentVideoPlaying = goToSlug;
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
    function attachSliders(parentSlug, listOfNodes, w){
      var branch = getBranch(parentSlug);
      var sliderDiv = branch.getSliderDivHTML();
      var duration = branch.videoLength;
      var levelTop = 1;
      var levelBottom = 1;
      for (var i = listOfNodes.length-1;  i >= 0 ; i--){
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
          attachSliders(nextSlug, nextBranch.nodes, 100);
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
      };
      // slider listener
      slider.addEventListener('input', function(){
        // updates video current time when slider changes
        var val = slider.value;
        var time = (val / 100) * duration;
        video.currentTime = time;
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
        currentLink.style.display = 'inline';
      }
    }
    // attaches listeners for the links/buttons
    function attachNodeListeners(node){
      var link = node.getNodeHTML();
      var goToSlug = node.branchSlug;
      link.onclick = function(){
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
        if (temp_slug != mainSlug){ currentBranch.stopVideo();}
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
      // creates tapestry-nav-bar-div
      var navBar = document.createElement('div');
      navBar.id = 'tapestry-nav-bar';
      navBar.style.position = 'relative';
      navBar.style.height = '150px'; // it should be dynamic??
      navBar.style.width = '100%';
      $container.append(navBar);
      // attaches main slider
      //var mainBranch = branched_videos[mainSlug];
      var mainSliderDiv = mainBranch.getSliderDivHTML();
      mainSliderDiv.style.position = 'relative';
      mainSliderDiv.style.top = 150/2 + 'px'; // half of nav-bar
      mainSliderDiv.style.left = '10%';
      mainSliderDiv.style.width = '70%';
      mainSliderDiv.zIndex = 10;
      navBar.appendChild(mainSliderDiv);
      // attaches all the sliders starting from the end to the main slider
      attachSliders(mainSlug, mainBranch.nodes, 25);
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
    }

    createAllBranches(this.options.branchedVideos);

  };
  return C;
})(H5P.jQuery);
