<?php
/**
 * GTL Multipurpose Theme Customizer
 *
 * @package GTL_Multipurpose
 */

   

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gtl_multipurpose_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

	
	$wp_customize->get_section( 'title_tagline' )->title = __('Site name, tagline and logo', 'gtl-multipurpose');
	$wp_customize->get_section( 'header_image' )->title = __('Add media' , 'gtl-multipurpose');
	$wp_customize->get_section( 'title_tagline' )->priority = '5';
	$wp_customize->get_section( 'title_tagline' )->panel = 'gtl_header_panel';
	$wp_customize->get_section( 'header_image' )->panel = 'gtl_banner_panel';
	$wp_customize->get_section( 'colors' )->title = __('General', 'gtl-multipurpose');
    $wp_customize->get_section( 'colors' )->panel = 'gtl_colors_panel';
    $wp_customize->get_section( 'colors' )->priority = '10';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'gtl_multipurpose_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'gtl_multipurpose_customize_partial_blogdescription',
		) );
	}

	 class GTL_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3>
            <?php echo esc_html( $this->label ); ?>
            </h3>
        <?php
        }
    } 
    require_once trailingslashit( get_template_directory() ) . '/inc/options/layout.php';
    require_once trailingslashit( get_template_directory() ) . '/inc/options/header.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/banner.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/footer.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/fonts.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/blog.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/sidebar.php';
	require_once trailingslashit( get_template_directory() ) . '/inc/options/color.php';

	// Load Upgrade to Pro control.
	 require_once trailingslashit( get_template_directory() ) . '/inc/upgrade-to-pro/control.php';

	// Register custom section types.
	$wp_customize->register_section_type( 'GTL_Multipurpose_Customize_Section_Upsell' );
	// Register sections.
	$wp_customize->add_section(
		new GTL_Multipurpose_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'GTL Multipurpose', 'gtl-multipurpose' ),
				'pro_text' => esc_html__( 'Buy Pro', 'gtl-multipurpose' ),
				'pro_url'  => 'https://greenturtlelab.com/downloads/gtl-multipurpose-pro/',
				'priority'  => 1,
			)
		)
	);

}
add_action( 'customize_register', 'gtl_multipurpose_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function gtl_multipurpose_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function gtl_multipurpose_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function gtl_multipurpose_customize_preview_js() {
	wp_enqueue_script( 'gtl-multipurpose-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'gtl_multipurpose_customize_preview_js' );

/**
 * Customizer control scripts and styles.
 *
 * @since 1.0.7
 */
function gtl_multipurpose_customizer_control_scripts() {

  wp_enqueue_script( 'gtl-multipurpose-customize-controls', get_template_directory_uri() . '/inc/upgrade-to-pro/customize-controls.js', array( 'customize-controls' ) );

  wp_enqueue_style( 'gtl-multipurpose-customize-controls', get_template_directory_uri() . '/inc/upgrade-to-pro/customize-controls.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'gtl_multipurpose_customizer_control_scripts', 0 );
