<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package GTL_Multipurpose
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gtl_multipurpose_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'gtl_multipurpose_body_classes' );

function gtl_multipurpose_sanitize_pagination($content) {
    // Remove h2 tag
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);
    return $content;
}
 
add_action('navigation_markup_template', 'gtl_multipurpose_sanitize_pagination');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function gtl_multipurpose_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'gtl_multipurpose_pingback_header' );



if( ! function_exists('gtl_multipurpose_oembed_result') ):

function gtl_multipurpose_oembed_result( $html, $url, $args = NULL ) {

   if( isset( $args['banner'] ) == 1 ){
         
      $html =  preg_replace('/width="\d+"/i', '' , $html );
      $html =  preg_replace('/height="\d+"/i', '' , $html );
      return str_replace("?feature=oembed", "?feature=oembed&autoplay=1&controls=0&loop=1&rel=0&showinfo=0&mute=1", $html);
  
   }else if( isset($args['width'] ) ){

      $html =  preg_replace('/width="\d+"/i', 'width="'.$args['width'].'"' , $html );
      $html =  preg_replace('/height="\d+"/i', 'height="'.$args['height'].'" style="width:'.$args['width'].'px;height:'.$args['height'].'px;" ' , $html );
      return $html;

   }else{
    
       return $html;

   }
}

endif;
add_filter('oembed_result','gtl_multipurpose_oembed_result', 10, 3);


if ( ! function_exists( 'gtl_multipurpose_excerpt' ) ) :

  if(!is_admin()):

    function gtl_multipurpose_excerpt( $text ) {

        $excerpt_words = esc_attr( get_theme_mod( 'exc_lenght' , 18 ) );

        $excerpt_length = apply_filters( 'excerpt_length', $excerpt_words );
        
        $excerpt_more = apply_filters( 'excerpt_more', ' ' . '...' );

        $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
       
        $text = apply_filters( 'get_the_excerpt', $text );
       
        return '<p>'.$text.'</p>';
    }
  endif;
endif;

add_action( 'the_excerpt', 'gtl_multipurpose_excerpt', 10 );


if( ! function_exists('gtl_multipurpose_slide_title') ):

  function gtl_multipurpose_slide_title( $title , $control ){

    $parts = explode( ' ', strip_tags( $title ) ); 
    if( count( $parts ) === 1 ){

      return '<p class="'.$control[0].'">'.$parts[0].'</p>';

    }else if( count( $parts ) === 2 ){

       return '<p class="'.$control[0].'">'.$parts[0].'</p><p class="'.$control[1].'">'.$parts[1].'</p>';

    }else if( count( $parts ) === 3 ){

      return '<p class="'.$control[0].'">'.$parts[0].'</p><p class="'.$control[1].'">'.$parts[1].'</p><p class="'.$control[2].'">'.$parts[2].'</p>';
    
    }else{

      $last_part = array_slice( $parts , 2 );
      return '<p class="'.$control[0].'">'.$parts[0].'</p><p class="'.$control[1].'">'.$parts[1].'</p><p class="'.$control[2].'">'.implode(' ', $last_part ).'</p>';
    }
  }

endif;
add_filter('gtl_multipurpose_slide_title' , 'gtl_multipurpose_slide_title', 10,  2);



if( ! function_exists('gtl_multipurpose_slide_subtitle') ):

  function gtl_multipurpose_slide_subtitle( $subtitle , $control ){

     $subtitle = strip_tags(  $subtitle );
     return '<p class="'.$control[3].'">'.$subtitle.'</p>';

  }

endif;
add_filter('gtl_multipurpose_slide_subtitle' , 'gtl_multipurpose_slide_subtitle', 10,  2);


if( ! function_exists('gtl_multipurpose_url_to_id' ) ):

  function gtl_multipurpose_url_to_id( $attachment_url ){
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url )); 
    if( isset( $attachment[0] ) ){

      return $attachment[0]; 
    }
    return false;
  }

endif;
add_filter( 'gtl_multipurpose_url_to_id' , 'gtl_multipurpose_url_to_id' , 10 , 1 );


if( ! function_exists( 'gtl_multipurpose_id_to_cropped_url' ) ):

  function gtl_multipurpose_id_to_cropped_url( $attachment_id, $size ){

    $thumb = wp_get_attachment_image_src( $attachment_id, $size );
    if( isset( $thumb[0] ) ){
      return  $thumb[0];
    }
   return false;

  }
endif;
add_filter( 'gtl_multipurpose_id_to_cropped_url' , 'gtl_multipurpose_id_to_cropped_url' , 10 , 2 );


if ( ! function_exists( 'pinwheel_custom_posts_navigation' ) ) :

  /**
   * Posts navigation.
   *
   * @since 1.0.0
   */
  function gtl_multipurpose_posts_navigation() {
    
    the_posts_pagination( array(
                            'mid_size' => 2,
                            'prev_text' => __( '<span aria-hidden="true"> << </span>', 'gtl-multipurpose' ),
                            'next_text' => __( '<span aria-hidden="true"> >> </span>', 'gtl-multipurpose' ),
                            'screen_reader_text' => '&nbsp;'
                        ) ); 
  }
endif;
add_action( 'gtl_multipurpose_posts_navigation' , 'gtl_multipurpose_posts_navigation' );




if( ! function_exists('gtl_multipurpose_footer_sidebars')):

  function gtl_multipurpose_footer_sidebars(){
    $columns = intval( esc_attr( get_theme_mod( 'footer_widget_areas' ) ) );
    if( ! $columns ){

      $columns = 4;
    }

    for( $i = 1; $i <= $columns; $i++):
      $args = array(
            'name'          => __( 'Footer Column ', 'gtl-multipurpose' ) . $i,
            'id'            => 'gtl-footer-'.$i,    
            'description'   => '',
            'class'         => 'col footerCol',
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>' 
            );
            register_sidebar( $args );
    endfor;
  }

endif;
add_action( 'init' , 'gtl_multipurpose_footer_sidebars');


if( ! function_exists( 'gtl_multipurpose_wp_title') ):
  function gtl_multipurpose_wp_title( $title, $sep ) {
    if ( is_feed() ) {
      return $title;
    }

    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo( 'name', 'display' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
      $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
      $title .= " $sep " . sprintf( __( 'Page %s', 'gtl-multipurpose' ), max( $paged, $page ) );
    }

    return $title;
  }

endif;
add_filter( 'wp_title', 'gtl_multipurpose_wp_title', 10, 2 );


if( !function_exists('gtl_multipurpose_add_widget_tabs')):

  function gtl_multipurpose_add_widget_tabs($tabs){

    $tabs[] = array(
        'title' => __('GTL Multipurpose', 'gtl-multipurpose'),
        'filter' => array(
            'groups' => array('themewidgets')
        )
    );

    return $tabs;
}

endif;
add_filter('siteorigin_panels_widget_dialog_tabs', 'gtl_multipurpose_add_widget_tabs', 20); 


if( ! function_exists( 'gtl-multipurpose_archive_title') ):

function multipurpose_archive_title( $title ){

      if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title =  get_the_author() ;

        } elseif( is_date() ){
           $title = single_month_title( ' ' , false );
           $title = implode( ', ', explode( ' ' , trim( $title ) ) );
        }

    return $title;

}

endif;
add_filter( 'get_the_archive_title', 'multipurpose_archive_title' ,  10 ,1 ); 


if ( ! function_exists( 'gtl_multipurpose_sidebars' ) ):

  /**
   * Returns array of registered sidebars
   */
  function gtl_multipurpose_sidebars() {
       global $wp_registered_sidebars;
       $arr = array();
       if( !empty( $wp_registered_sidebars ) && is_array($wp_registered_sidebars) ){
        foreach(  $wp_registered_sidebars as $sidebar ):
          $arr[$sidebar['id']] = $sidebar['name'];
        endforeach;
       }
    return $arr;      
  }
  
endif;
add_action('widgets_init','gtl_multipurpose_sidebars' , 99);


if ( ! function_exists( 'gtl_multipurpose_recommend_plugin' ) ):

function gtl_multipurpose_recommend_plugin() {

  
    /**
     * Array of plugin arrays. Required keys are name and slug.
     */
    $plugins = 
        array(
        
            array(
               
                'name'               => esc_html__('GTL Components','gtl-multipurpose'),
                'slug'               => 'gtl-components',
                'required'           =>  false,
            ),
            array(
               
                'name'               => esc_html__('Page Builder','gtl-multipurpose'),
                'slug'               => 'siteorigin-panels',
                'required'           =>  false,
            ),
             array(
               
                'name'               => esc_html__('One Click Demo Import','gtl-multipurpose'),
                'slug'               => 'one-click-demo-import',
                'required'           =>  false,
            ),
           array(
                'name'               => esc_html__( 'Contact Form 7', 'gtl-multipurpose' ),
                'slug'               => 'contact-form-7',
                'required'           => false,
              ),
              array(
                'name'               => esc_html__( 'WooCommerce', 'gtl-multipurpose' ),
                'slug'               => 'woocommerce',
                'required'           => false,
              ),
           
    );

    $config = array(
        'id'           => 'gtl-multipurpose',        // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );

}

endif;
add_action( 'tgmpa_register', 'gtl_multipurpose_recommend_plugin' );


/*
 * WooCommerce filters and actions
 */
if ( class_exists( 'WooCommerce' ) ) {

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
 
 
// Add them back UNDER the Cart Table
 
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' , 99 );
 

if ( ! function_exists( 'gtl_multipurpose_woocommerce_header_add_to_cart_fragment' ) ) :

function gtl_multipurpose_woocommerce_header_add_to_cart_fragment( $fragments ) {

  global $woocommerce;

  ob_start();

  ?>
  <span class="cart-count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
  <?php

  $fragments['span.cart-count'] = ob_get_clean();

  return $fragments;

}

endif;
add_filter('add_to_cart_fragments', 'gtl_multipurpose_woocommerce_header_add_to_cart_fragment');

if ( ! function_exists( 'gtl_multipurpose_pagination' ) ) :

function gtl_multipurpose_pagination( $args ) {

  $args['prev_text'] = '<<';
  $args['next_text'] = '>>';
  return $args;
}

endif;
add_filter( 'woocommerce_pagination_args',  'gtl_multipurpose_pagination' );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

if ( ! function_exists( 'gtl_multipurpose_wc_before_main_content' ) ) :

function gtl_multipurpose_wc_before_main_content(){

      $sidebar = gtl_multipurpose_shop_sidebar_pos();

      if( ! $sidebar ){

        $row =  'aGrid';

      }else if($sidebar=='left'){

        $row = 'col_2-30-70';

      }else{

        $row = 'col_2-70-30';

      }

      get_template_part( 'template-parts/banner' );

      echo '<section class="custom-section">
          <div class="'.gtl_multipurpose_site_container().' content-all">
              <div class="'.esc_attr($row).'">';
      if( $sidebar == 'left' ):  get_sidebar();  endif;
       echo '<div class="cols">';

}

endif;
add_action('woocommerce_before_main_content', 'gtl_multipurpose_wc_before_main_content' , 1);


if ( ! function_exists( 'gtl_multipurpose_wc_after_main_content' ) ) :

function gtl_multipurpose_wc_after_main_content(){

      $sidebar = gtl_multipurpose_shop_sidebar_pos();

      echo '</div>';
      if( $sidebar == 'right' ):  get_sidebar();  endif;
      echo '</div>
        </div>
      </section>';

}

endif;
add_action('woocommerce_after_main_content', 'gtl_multipurpose_wc_after_main_content' , 99);


}