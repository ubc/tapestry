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
    console.log(this.options.mainBranchedVideo.branchedVideos["0"].sourceFiles["0"].src);


    // EVERYTHING BELOW HERE IN THIS SCOPE IS FROM A DIFFERENT PROJECT FOR REFERENCE

    // must embed for youtube URL
    var fullLink = this.options.branch["0"].path;
    var fullLink2 = this.options.branch2["0"].path;
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = fullLink.match(regExp);
    var match2 = fullLink2.match(regExp);
    console.log("made it past match");
    if (match && match[2].length == 11){
      console.log("no error");
    }
    var vidID = match[2];
    var vidID2 = match2[2];
    console.log("here is the video ID : " + vidID);

    if (this.options.branch && this.options.branch["0"].path) {
      $container.append('<iframe class="greeting-image" src="https://www.youtube.com/embed/' + vidID + '" frameborder="0" allowfullscreen> </iframe>');
    }
    if (this.options.branch && this.options.branch2["0"].path) {
      $container.append('<iframe class="greeting-image" src="https://www.youtube.com/embed/' + vidID2 + '" frameborder="0" allowfullscreen> </iframe>');
    }
    console.log('<iframe class="greeting-image" src="https://www.youtube.com/embed/' + vidID + '" frameborder="0" allowfullscreen> </iframe>');
    // Add greeting text.
    $container.append('<div class="greeting-text">' + this.options.greeting + '</div>');

  };

  return C;
})(H5P.jQuery);
;
