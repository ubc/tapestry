// branch object constructor
// par:  an H5P BranchedVideo
// type: string of 3 possible values = ['main', 'upper ', 'lower']
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
    videoDiv.appendChild(video);
    return videoDiv;
  }

  this.videoDivHTML = this.createVideoDivHTML();
  this.getVideoDivHTML = function(){
    return this.videoDivHTML;
  }
  this.getVideoHTML = function(){
    return document.querySelector("[class='tapestry-video'][data-tapestry='" + this.slug + "']");
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

    // video on time update change slider found in createVideoHTML()

    // changes video current time when we change value of slider

    sliderDiv.appendChild(slider);
    return sliderDiv;
  }

  this.sliderDivHTML =  this.createSliderDivHTML();
  this.getSliderDivHTML = function(){
    return this.sliderDivHTML;
  }
  this.getSliderHTML = function(){
    return document.getElementById('tapestry-slider-' + this.slug)
  }

// handles the nodes creation
  this.createAllNodes = function(){
    for(var i = 0; i < par.subBranches.length; i ++){
      var node = new Node(par.subBranches[i] , this.slug);
      this.nodes.push(node);
    }
  }
  createAllNodes(); // gotta call it

}


// create associative array temporarily
var branched_videos = {};
// given slug, returns branch
function getBranch(slug){
  return branched_videos[slug];
}
// handles jumpong
function jump(currSlug, nextSlug){
  pauseVideo(currSlug);
  playVideo(nextSlug);
}
function pauseVideo(slug){
  var branch = getBranch(slug);
  var videoDiv = branch.getVideoDivHTML();
  var video = branch.getVideoHTML();
  video.pause();
  videoDiv.style.display = 'none';
}
function playVideo(slug){
  var branch = getBranch(slug);
  var videoDiv = branch.getVideoDivHTML();
  var video = branch.getVideoHTML();
  video.play();
  videoDiv.style.display = 'inline';
}


// given list of H5P branched videos, creates all branches
function createAllBranches(par){
  // creates all branches
  for (var i = 0 ; i < par.length ; i++){
    var temp_slug = par[i].slug;
    branchedVideos[temp_slug] = new Branch(par[i]);
  }
  // at this point all branches would have been created
  // adds all the subBranches
  for(var i = 0; i < par.length; i++){
    var temp_slug = par[i].slug;
    for(var j=0; j< par[i].subBranches.length ; j++){
      var sub_branch_slug = par[i].subBranches[j].slug;
      branched_videos[temp_slug].subBranches.push(branched_videos[sub_branch_slug]);
    }
  }
  // at this point all branches would have subranches filled
  // creates all the bubbles
}
