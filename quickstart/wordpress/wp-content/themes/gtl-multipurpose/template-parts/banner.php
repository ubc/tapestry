<?php 
 $front_banner = gtl_multipurpose_front_banner_type();
 $site_banner = gtl_multipurpose_site_banner_type(); 

 if( is_front_page() || is_home()){ 
    if( $front_banner == 'slider-banner' ){
      gtl_multipurpose_banner_slider();
    }else if( $front_banner == 'video-banner' ){
      gtl_multipurpose_banner_video();
    }else if(  $front_banner == 'image-banner' ){
      gtl_multipurpose_banner_image();
    }
  
 }else{
    if( $site_banner == 'slider-banner' ){ 
      gtl_multipurpose_banner_slider();
    }
    else if( $site_banner == 'video-banner' ){
      gtl_multipurpose_banner_video();
    }
    else if(  $site_banner == 'image-banner' ){
      gtl_multipurpose_banner_image();
    }
    
 
 }