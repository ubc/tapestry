// constructor for Node object
// subBranch: H5P subBranch object
function Node(subBranch, parentSlug){
  this.startTime = subBranch.startTime;
  this.endTime = subBranch.endTime;
  this.branchSlug = subBranch.branchSlug;
  this.link =  new Link(subBranch.bubble);

  this.handleTimeUpdate = function(){
    var branch = getBranch(parentSlug);
    var video = branch.getVideoHTML();
    video.onTimeUpdate = function(){
      if (video.currentTime > startTime && video.currentTime < endTime){
        var bubble = this.link.getLinkHTML();
        bubble.style.display = 'block';
      } else if (video.currentTime < startTime || video.currentTime > endTime){
        var bubble = this.link.getLinkHTML();
        bubble.style.display = 'none';
      }
    }
  }

  this.getLinkHTML = function(){
    return this.link.getLinkHTML();
  }

  this.handleTimeUpdate();
}


// constructor for Link object
// bubble: H5P bubble object
function Link(bubble){
  this.text = bubble.text;
  this.style = bubble.style;
  this.color = bubble.color;
  this.positionX = bubble.positionX;
  this.positionY = bubble.positionY;

// returns the HTML component
  this.createLinkHTML = function(){
    var currentLink = document.createElement('button');
    currentLink.id = 'tapestry-link-' + this.branchSlug;
    currentLink.type = 'button';
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
}
