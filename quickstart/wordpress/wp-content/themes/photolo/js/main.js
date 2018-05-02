(function( $ ) {
 
    "use strict";
   

    //init Masonry
	var $masonry_grid = $('.masonry-grid .gallery').masonry({
	  itemSelector: '.gallery-item',
	  percentPosition: true,
	  columnWidth: '.gallery-item',
	});
	// layout Masonry after each image loads
	$masonry_grid.imagesLoaded().progress( function() {
	  $masonry_grid.masonry();
	});  

	var $striped_grid = $('.striped-grid .gallery').masonry({
	  itemSelector: '.gallery-item',
	  percentPosition: true,
	  columnWidth: '.gallery-item',
	});
	// layout Masonry after each image loads
	$striped_grid.imagesLoaded().progress( function() {
	  $striped_grid.masonry();
	});  


	var $gallery_grid = $('.gallery-grid .gallery').masonry({
	  itemSelector: '.gallery-item',
	  percentPosition: true,
	  columnWidth: '.gallery-item',
	});
	// layout Masonry after each image loads
	$gallery_grid.imagesLoaded().progress( function() {
	  $gallery_grid.masonry();
	});  

	var $grid = $('.grid').masonry({
	  itemSelector: '.gallery-grid-item',
	  percentPosition: true,
	  columnWidth: '.gallery-grid-item',
	});
	// layout Masonry after each image loads
	$grid.imagesLoaded().progress( function() {
	  $grid.masonry();
	});

	$('.navbar-toggler').click(function(){
      $(this).toggleClass('open');
    }); 

	// init Packery
	var $packery_grid = $('.packery-grid .gallery').packery({
	  // options
	  itemSelector: '.gallery-item',
	  percentPosition: true,
	});

	// layout Packery after each image loads
	$packery_grid.imagesLoaded().progress( function() {
	  $packery_grid.packery();
	});

	// init Packery
	var $packery_grid1 = $('.packery').packery({
	  // options
	  itemSelector: '.gallery-grid-item',
	  percentPosition: true,
	});

	// layout Packery after each image loads
	$packery_grid1.imagesLoaded().progress( function() {
	  $packery_grid1.packery();
	});

	$('.gallery-icon a').fancybox({
	    afterLoad : function(instance, current) {
	        var pixelRatio = window.devicePixelRatio || 1;

	        if ( pixelRatio > 1.5 ) {
	            current.width  = current.width  / pixelRatio;
	            current.height = current.height / pixelRatio;
	        }
	    }
	});

	$('.full-grid-slider .gallery').bxSlider({
	    mode: 'fade',
		auto: true,
		autoControls: false,
		stopAutoOnClick: true,
		pager: false,
	  });

	
 
})(jQuery);