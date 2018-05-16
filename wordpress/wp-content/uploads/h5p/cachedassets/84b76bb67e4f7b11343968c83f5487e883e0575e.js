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
    // Set class on container to identify it as a greeting card
    // container.  Allows for styling later.
    $container.addClass("h5p-greetingcard");
    // to see the object
    console.log(this);

    // to access sourceFile, try putting a youtube link there
    //console.log(this.options.mainBranchedVideo.branchedVideos["0"].sourceFiles["0"].src);

    // try to display all youtube videos
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var numOfBranches = this.options.mainBranchedVideo.branchedVideos.length;
    console.log("number of branches: " + numOfBranches);
    var i;
    /* for iframe/youtube videos
    for(i = 0; i < numOfBranches; i++){
      var fullLink = this.options.mainBranchedVideo.branchedVideos[i.toString()].sourceFiles["0"].src;
      console.log("make sure fullLink: " + fullLink);
      var match = fullLink.match(regExp);
      if (match && match[2].length == 11){
        console.log("no error so far");
      }
      var vidID = match[2];
      console.log("here is the video ID : " + vidID);
      $container.append('<iframe class="greeting-image" src="https://www.youtube.com/embed/' + vidID + '" frameborder="0" allowfullscreen> </iframe>');
    }
    */

    // for html Videos
    for(i = 0; i < numOfBranches; i++){
      var videoURL = this.options.mainBranchedVideo.branchedVideos[i.toString()].sourceFiles["0"].src;
      console.log(videoURL);
      $container.append('<video id="branch' + i + '" class="greeting-image" src="'
      + videoURL + '" frameborder="0" allowfullscreen controls> </video>');
      var currentVideoId = document.getElementById("branch" + i);
      console.log(currentVideoId);
      $(currentVideoId).hide();
    }

    $container.append('<div class="greeting-text">' + this.options.mainBranchedVideo.mainBranchSlug + '</div>');

  };

  return C;
})(H5P.jQuery);
;
