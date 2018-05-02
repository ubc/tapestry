<?php
/**
 * GTL Multipurpose functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GTL_Multipurpose
 */

if ( ! function_exists( 'gtl_multipurpose_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gtl_multipurpose_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on GTL Multipurpose, use a find and replace
		 * to change 'gtl-multipurpose' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gtl-multipurpose', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'gtl-multipurpose-img-525-350' , 525 , 350 , array( 'center', 'top' ) );
		add_image_size( 'gtl-multipurpose-img-585-500' , 585 , 500 , array( 'center', 'top' ) );
		add_image_size( 'gtl-multipurpose-img-330-200' , 330 , 200 , array( 'center', 'top' ) );
		add_image_size( 'gtl-multipurpose-img-250-380' , 250 , 380 , array( 'center', 'top' ) );
		add_image_size( 'gtl-multipurpose-img-105-70' , 105 , 70 , array( 'center', 'top' ) );
		add_image_size( 'gtl-multipurpose-img-46-54' , 46 , 54 , array( 'center', 'top' ) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primary', 'gtl-multipurpose' ),
			'secondary-menu' => esc_html__( 'Secondary', 'gtl-multipurpose' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'gtl_multipurpose_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'width'      => 170,
			'height'       => 40,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for woocommerce.
		 *
		 */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		
	}
endif;
add_action( 'after_setup_theme', 'gtl_multipurpose_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gtl_multipurpose_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gtl_multipurpose_content_width', 640 );
}
add_action( 'after_setup_theme', 'gtl_multipurpose_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function gtl_multipurpose_scripts() {
	
	wp_enqueue_style( 'gtl-multipurpose-font' , gtl_multipurpose_get_font() , array(), '20151215' );

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '20151215' );

	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.min.css', array(), '20151215' );

	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '20151215' );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '20151215' );

    wp_enqueue_style('gtl-multipurpose-style' , get_stylesheet_uri() , array() , '1.8' );

    wp_enqueue_style( 'gtl-multipurpose-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '1.0' );
    
    
	

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/flexslider.min.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'gtl-multipurpose-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'gtl-multipurpose-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.4', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gtl_multipurpose_scripts' );

/**
 * loads javscript and css files in admin section.
 */
function gtl_multipurpose_admin_enqueue($hook){
	if($hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit.php'){
		wp_enqueue_style( 'wp-color-picker');

		wp_enqueue_script( 'wp-color-picker');	

		wp_enqueue_style( 'greenturtle-mag-admin-style', get_template_directory_uri() . '/assets/admin/css/admin-style.css', array(), '1.0.4' );

	    wp_enqueue_script( 'gtl-multipurpose-admin-script', get_template_directory_uri().'/assets/admin/js/scripts.js','', '1.0.4' , 'all' ); 
	}
	     
}
add_action( 'admin_enqueue_scripts' , 'gtl_multipurpose_admin_enqueue' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Recommended plugins
 */
require get_template_directory() . '/inc/recommended-plugins.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Theme functions
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Theme functions
 */
require get_template_directory() . '/inc/sidebars.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Demo Import
 */
require get_template_directory() . '/inc/one-click-demo-import.php';

if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {

	/* load widgets */
	require get_template_directory() . '/inc/widgets/title_subtitle.php';
	require get_template_directory() . '/inc/widgets/raw_html.php';
	require get_template_directory() . '/inc/widgets/text_image_video.php';
	require get_template_directory() . '/inc/widgets/cta.php';
	require get_template_directory() . '/inc/widgets/list.php';
	require get_template_directory() . '/inc/widgets/divider.php';
	require get_template_directory() . '/inc/widgets/services.php';
	require get_template_directory() . '/inc/widgets/testimonials.php';
	require get_template_directory() . '/inc/widgets/team.php';
	require get_template_directory() . '/inc/widgets/blog.php';
	require get_template_directory() . '/inc/widgets/counter.php';
	require get_template_directory() . '/inc/widgets/skillbar.php';
	require get_template_directory() . '/inc/widgets/video.php';
	require get_template_directory() . '/inc/widgets/contact.php';
	if( class_exists( 'WooCommerce' ) ):
	 require get_template_directory() . '/inc/widgets/shop_products.php';
    endif;

	/* pagebuilder setting extension */
	require get_template_directory() . '/inc/page-builder.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



