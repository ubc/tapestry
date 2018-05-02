<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package photolo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */


/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function photolo_enqueue_custom_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/inc/css/custom.css', false, '1.0.17' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'photolo_enqueue_custom_admin_style' );

function photolo_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    global $post;
    $layouts = esc_attr(get_post_meta($post->ID, 'photolo_gallery_layouts', true));
    $classes[] =  $layouts;

	return $classes;
}
add_filter( 'body_class', 'photolo_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function photolo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'photolo_pingback_header' );


/* * *************************Word Count Limit****************************************** */
if ( ! function_exists( 'custom_excerpt_more' ) ) :
    function photolo_custom_excerpt_more( $more ) {
        if (  is_admin() ) {
            return $more;
        }
    	return '&hellip;';
    }
    add_filter( 'excerpt_more', 'photolo_custom_excerpt_more' );
endif;
if ( ! function_exists( 'photolo_word_count' ) ) :
    function photolo_word_count($string, $limit) {
        
        $striped_content = strip_tags($string);
        $striped_content = strip_shortcodes($striped_content);

        $words = explode(' ', $striped_content);
        return implode(' ', array_slice($words, 0, $limit));
    }
endif;

if ( ! function_exists( 'photolo_letter_count' ) ) :
    function photolo_letter_count($content, $limit) {
        $striped_content = strip_tags($content);
        $striped_content = strip_shortcodes($striped_content);
        $limit_content = mb_substr($striped_content, 0, $limit);
        if ($limit_content < $content) {
            $limit_content .= "&hellip;";
        }
        return $limit_content;
    }
endif;

/**
 * Registers an editor stylesheet for the theme.
 */
function photolo_wpdocs_theme_add_editor_styles() {
  add_editor_style( 'css/custom-editor-style.css' );
}
/**
 * Implement the custom metabox feature
 */
require get_template_directory() . '/inc/custom-metabox.php';

