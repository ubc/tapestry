<?php
/**
 * photolo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package photolo
 */

if ( ! function_exists( 'photolo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function photolo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on photolo, use a find and replace
		 * to change 'photolo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'photolo', get_template_directory() . '/languages' );

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
		//grid image cropt
		add_image_size( 'photolo-grid-small', 300, 300, true);
		add_image_size( 'photolo-grid-medium', 400, 400, true);
		add_image_size( 'photolo-grid-large', 600, 600, true);
		add_image_size( 'photolo-striped-large', 270, 480, true);
		// Our Services 
		//

		// Register the three useful image sizes for use in Add Media modal
		add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
		function wpshout_custom_sizes( $sizes ) {
		    return array_merge( $sizes, array(
		    	'photolo-grid-small' => __( 'Grid Small' , 'photolo'),
		        'photolo-grid-medium' => __( 'Grid Medium' , 'photolo'),
		        'photolo-grid-large' => __( 'Grid Large' , 'photolo'),
		        'photolo-striped-large' => __( 'Striped Large' , 'photolo'),
		    ) );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'photolo' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'gallery',
		) );
		
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'photolo_custom_background_args', array(
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
			'height'      => 100,
			'width'       => 100,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'photolo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function photolo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'photolo_content_width', 640 );
}
add_action( 'after_setup_theme', 'photolo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function photolo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'photolo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'photolo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'photolo' ),
		'id'            => 'right-sidebar',
		'description'   => 'Right sidebar widget area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'photolo' ),
		'id'            => 'left-sidebar',
		'description'   => 'Left sidebar widget area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Copyright Text', 'photolo' ),
		'id'            => 'copyright_text',
		'description'   => 'Copyright text sidebar widget area',
		'before_widget' => '<aside id="%1$s" class=" %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'photolo_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function photolo_scripts() {
	wp_enqueue_style( 'photolo-style', get_stylesheet_uri() );

	wp_enqueue_style('photolo-main-style', get_template_directory_uri().'/css/main.css');
	wp_enqueue_style('bxslider', get_template_directory_uri().'/css/jquery.bxslider.css');
	wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700');
	wp_enqueue_style('icon-fonts', get_template_directory_uri().'/css/fonts.css');
	wp_enqueue_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.min.css');

	wp_enqueue_script( 'photolo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'photolo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array(), '20151215', true );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array(), '20151215', true );
	wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array(), '20151215', true );
	wp_enqueue_script( 'packery', get_template_directory_uri() . '/js/packery.pkgd.min.js', array(), '20151215', true );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array(), '20151215', true );
	wp_enqueue_script( 'photolo-main-js', get_template_directory_uri() . '/js/main.js', array(), '20151215', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'photolo_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';





if ( ! function_exists( 'photolo_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Photolo 1.0
 */
function photolo_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html( 'Posts navigation', 'photolo' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'photolo' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'photolo' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
