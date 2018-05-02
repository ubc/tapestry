<?php
/**
 * photolo Theme Customizer
 *
 * @package photolo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function photolo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.navbar-brand a',
			'render_callback' => 'photolo_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'photolo_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'photolo_customize_register' );

if ( ! function_exists( 'photolo_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function photolo_theme_customize_register( $wp_customize ) {

		// Start Basic Settings Themes Options
	    $wp_customize->add_panel('photolo_basic_settings', array(
	        'title'         => __('Basic Settings','photolo'),
	        'description'   => '',
	        'capability'    => 'edit_theme_options',
	        'priority'      => 10,
	        'theme_supports'=>'',
	    ));

	    $wp_customize->get_section('title_tagline' )->panel = 'photolo_basic_settings';

	     //Color Settings
		$wp_customize->get_section('colors')->title = __( 'Themes Colors', 'photolo' );
		$wp_customize->get_section('colors')->priority = 50;
		$wp_customize->get_section('colors')->panel = 'photolo_basic_settings';

		$wp_customize->add_setting(
		    'main_theme_color',
		    array(
		        'default'     => '#ff0000',
		        'sanitize_callback' => 'sanitize_hex_color',
		    )
		);


		$wp_customize->add_control(
			new WP_Customize_Color_Control(
			    $wp_customize,
			    'link_color',
			    array(
			        'label'      => __( 'Brand Color', 'photolo' ),
			        'section'    => 'colors',
			        'sanitize_callback' => 'sanitize_hex_color',
			        'settings'   => 'main_theme_color'
			    )
			)
		);

		// Theme layout settings.
		$wp_customize->add_section( 'photolo_theme_layout_options', array(
			'title'       => __( 'Theme Layout Settings', 'photolo' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Container width and sidebar defaults', 'photolo' ),
			'priority'    => 10,
		) );


		$wp_customize->add_setting( 'photolo_container_type', array(
			'default'           => 'container',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'photolo_theme_slug_sanitize_select',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'photolo_container_type', array(
					'label'       => __( 'Container Width', 'photolo' ),
					'description' => __( "Choose the layout that you want", 'photolo' ),
					'section'     => 'photolo_theme_layout_options',
					'settings'    => 'photolo_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width', 'photolo' ),
						'container-fluid' => __( 'Full width ', 'photolo' ),
					),
					'priority'    => '10',
				)
			) );

		$wp_customize->add_setting( 'photolo_header_style', array(
			'default'           => 'bg-light',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'photolo_theme_slug_sanitize_select',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'photolo_header_style', array(
					'label'       => __( 'Header Style', 'photolo' ),
					'description' => __( "Choose Header Background Style", 'photolo' ),
					'section'     => 'photolo_theme_layout_options',
					'settings'    => 'photolo_header_style',
					'type'        => 'select',
					'choices'     => array(
						'bg-light'       => __( 'Light', 'photolo' ),
						'bg-dark' => __( 'Dark', 'photolo' ),
					),
					'priority'    => '10',
				)
			) );

		$wp_customize->add_setting( 'photolo_sidebar_position', array(
			'default'           => 'none',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'photolo_theme_slug_sanitize_select',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'photolo_sidebar_position', array(
					'label'       => __( 'Sidebar', 'photolo' ),
					'description' => __( "Set sidebar's default position. Can either be: right or none. Note: this can be overridden on individual pages.",
					'photolo' ),
					'section'     => 'photolo_theme_layout_options',
					'settings'    => 'photolo_sidebar_position',
					'type'        => 'select',
					'choices'     => array(
						'right' => __( 'Right sidebar', 'photolo' ),
						'left'  => __( 'Left sidebar', 'photolo' ),
						'both'  => __( 'Left & Right sidebars', 'photolo' ),
						'none'  => __( 'No sidebar', 'photolo' ),
					),
					'priority'    => '20',
				)
			) );


		// Blogs Settings section
	    $wp_customize->add_section('photolo_blog_archive_section', array(
		        'priority' => 20,
		        'title' => __('Blogs Page Layout Settings', 'photolo'),
		));

	    $wp_customize->add_setting( 'photolo_blog_page_layout', array(
	        'default' => 'default',
	        'capability' => 'edit_theme_options',
	        'sanitize_callback' => 'photolo_radio_sanitize_archive_web_page_layout',
	    ) );
	 
	    $wp_customize->add_control('photolo_blog_page_layout', array(
	      'type' => 'radio',
	      'label' => __('Choose the Blogs Page Layout', 'photolo'),
	      'section' => 'photolo_blog_archive_section',
	      'setting' => 'photolo_blog_page_layout',
	      'choices' => array(            
	         'default' => __('Default View', 'photolo'),
	         'grid' => __('Masonry View', 'photolo'),
	         'packery' => __('Packery View', 'photolo'),
	         'fullscreen' => __('Fullscreen View', 'photolo')
	      )
	   	));

	   $wp_customize->add_setting('photolo_blog_description_archive_section', array(
	      'default' => '20',
	      'sanitize_callback' => 'photolo_sanitize_number',
	   ));

	   $wp_customize->add_control('photolo_blog_description_archive_section', array(
	      'type' => 'number',
	      'label' => __('Blog Description Word Limit', 'photolo'),
	      'section' => 'photolo_blog_archive_section',
	      'setting' => 'photolo_blog_description_archive_section',
	   ));



	    //select sanitization function
        function photolo_theme_slug_sanitize_select( $input, $setting ){
         
            //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
            $input = sanitize_key($input);
 
            //get the list of possible select options 
            $choices = $setting->manager->get_control( $setting->id )->choices;
                             
            //return input if valid or return default option
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
             
        }
        if ( ! function_exists( 'sanitize_hex_color' ) ) {
			function sanitize_hex_color( $color ) {
				if ( '' === $color ) {
					return '';
				}
				// 3 or 6 hex digits, or the empty string.
				if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
					return $color;
				}
			}
		}

        function photolo_radio_sanitize_yesno($input) {
	      $valid_keys = array(
	        'yes'=>__('Yes', 'photolo'),
	        'no'=>__('No', 'photolo')
	      );
	      if ( array_key_exists( $input, $valid_keys ) ) {
	         return $input;
	      } else {
	         return '';
	      }
	   }

	   function photolo_radio_sanitize_archive_web_page_layout($input) {
	      $valid_keys = array(
	        'default' => __('Default View', 'photolo'),
	        'grid' => __('Masonry View', 'photolo'),
	        'packery' => __('Packery View', 'photolo'),
	        'fullscreen' => __('Fullscreen View', 'photolo')
	      );
	      if ( array_key_exists( $input, $valid_keys ) ) {
	         return $input;
	      } else {
	         return '';
	      }
	   }

	   // Number
	    function photolo_sanitize_number( $input ) {
	    $output = intval($input);
	      return $output;
	  } 
	}
} // endif function_exists( 'photolo_theme_customize_register' ).
add_action( 'customize_register', 'photolo_theme_customize_register' );
/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function photolo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function photolo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function tcx_customizer_css() {
    ?>
    <style type="text/css">
        .navbar{ border-color:  <?php echo esc_attr(get_theme_mod( 'main_theme_color' , '#ff0000' )) ?> } 
        input[type="submit"]{ background-color: <?php echo esc_attr( get_theme_mod( 'main_theme_color' ,'#ff0000' ))?>; border-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000'))?>; }
        .widget {  border-color:  <?php echo esc_attr( get_theme_mod( 'main_theme_color' ,'#ff0000' ))?> }
        .morelink{border-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color', '#ff0000' ))?>;}
        .page-item.active .page-link{ background-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' , '#ff0000' )) ?>;border-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>; font-weight: 400;}
        blockquote,.post-navigation{border-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color'  ,'#ff0000')) ?>;}
        .error-404 .page-title, .no-results .page-title{color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' , '#ff0000'))?>}
        .btn-primary{background-color: <?php echo esc_attr( get_theme_mod( 'main_theme_color' , '#ff0000' )) ?>;border-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>;}
        a:hover{color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>;}
        .morelink{border-color:<?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' ))?>; }
        .navbar-expand-md .navbar-nav .dropdown-menu::after {border-bottom: 4px dashed <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>;}
        .navbar-expand-md .navbar-nav .dropdown-menu{border-top: 1px solid <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>;}
        .navbar-toggler .navbar-toggler-icon{background-color: <?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>!important;}
        .widget_calendar tbody a{ background-color:<?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' )) ?>;  }
        .widget-area .widget{border-color:<?php echo esc_attr(get_theme_mod( 'main_theme_color' ,'#ff0000' ))?>; }
    </style>
    <?php
}
add_action( 'wp_head', 'tcx_customizer_css' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function photolo_customize_preview_js() {
	wp_enqueue_script( 'photolo-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'photolo_customize_preview_js' );
