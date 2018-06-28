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
    function Branch(par , type){
      this.slug = par.slug;
      this.title = par.title;
      this.description = par.description;
      this.type = type;
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
        var slider = document.createElement('input');
        slider.id = 'tapestry-slider-' + this.slug;
        slider.min = 0;
        slider.max = 0;
        slider.style.zIndex = 5;
        sliderDiv.appendChild(slider);
        return sliderDiv;
      }
      this.createSliderDivHTML();

      this.getSliderDivHTML = function(){
        return document.getElementById('tapestry-wrapper-slider-' + this.slug);
      }
      this.getSliderHTML = function(){
        return document.getElementById('tapestry-slider-' + this.slug);
      }

    // handles the nodes creation
      this.createAllNodes = function(){
        var arr = [];
        for(var i = 0; i < par.subBranches.length; i ++){
          var node = new Node(par.subBranches[i] , this.slug);
          arr.push(node);
          var currVideoDiv = this.getVideoDivHTML();
          var currNodeHTML = node.getNodeHTML();
          if (currNodeHTML != null){
            currVideoDiv.appendChild(currNodeHTML);
          }
        }
        return arr;
      }
      this.nodes = this.createAllNodes(); // gotta call it


      // FUNCTIONS FOR THE ACTUAL BRANCH

      // hide video div
      this.hide = function(){
        var videoDiv = this.getVideoDivHTML();
        videoDiv.style.display = 'none';
      }
      // show video div
      this.show = function(){
        var videoDiv = this.getVideoDivHTML();
        videoDiv.style.display = 'inline';
      }

    } // end of branch



    // NODE
    function Node(subBranch, parentSlug){
      this.startTime = subBranch.branchTimeFrom;
      this.endTime = subBranch.branchTimeTo;
      this.branchSlug = subBranch.branchSlug;
      this.link =  new Link(subBranch.bubble, this.branchSlug);
      this.getNodeHTML = function(){
        //console.log('link: ' + this.link);
        return this.link.getLinkHTML();
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
    // create associative array temporarily
    var branched_videos = {};
    // given slug, returns branch
    function getBranch(slug){
      return branched_videos[slug];
    }

    // given list of H5P branched videos, creates all branches
    function createAllBranches(par){
      // creates all branches
      for (var i = 0 ; i < par.length ; i++){
        var temp_slug = par[i].slug;
        branched_videos[temp_slug] = new Branch(par[i]);
        var currentBranch = branched_videos[temp_slug];
        $container.append(currentBranch.getVideoDivHTML());
        if (temp_slug != mainSlug){ currentBranch.hide();}
      }
    }
    createAllBranches(this.options.branchedVideos);
    console.log(branched_videos);

  };
  return C;
})(H5P.jQuery);
