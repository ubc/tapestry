<?php
/**
 * Blazing Theme Customizer
 *
 * @package Blazing
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blazing_customize_register($wp_customize) {

	/*Panels Start*/
	$wp_customize->add_panel('blazing_homepage', array(
		'priority' => 2,
		'title'    => __('Homepage Options', 'blazing'),
	));

	$wp_customize->add_panel('blazing_settings', array(
		'title'    => __('Blazing Settings', 'blazing'),
		'priority' => 3,
	));

	

	/*Panel End*/

	

/* Contact */
	$wp_customize->add_section('blazing_contacts_section', array(
		'title'      => __('Contact Options', 'blazing'),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('blazing_top_email', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'blazing_sanitize_email',
	));

	$wp_customize->add_control('blazing_top_email', array(
		'type'     => 'email',
		'priority' => 200,
		'section'  => 'blazing_contacts_section',
		'label'    => __('Email', 'blazing'),
	));

	$wp_customize->add_setting('blazing_top_phone', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_top_phone', array(
		'type'     => 'text',
		'priority' => 200,
		'section'  => 'blazing_contacts_section',
		'label'    => __('Phone', 'blazing'),
	));
/* Contact */

/*Hero Image*/

	$wp_customize->add_section('blazing_home_hero_section', array(
		'title'    => __('Hero Image', 'blazing'),
		'panel'    => 'blazing_homepage',
		'priority' => 10,
	));

	$wp_customize->add_setting('blazing_home_hero_image', array(
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'blazing_home_hero_image', array(
		'label'       => __('Heading', 'blazing'),
		'priority'    => 0,
		'section'     => 'blazing_home_hero_section',
		'flex_width'  => true,
		'flex_height' => true,
		'width'       => 1920,
		'height'      => 1080,
	)));

	$wp_customize->add_setting('blazing_home_hero_heading', array(
		'default'           => __('Edit this in Customizer', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_hero_heading', array(
		'type'    => 'text',
		'label'   => __('Heading', 'blazing'),
		'section' => 'blazing_home_hero_section',
	));

	$wp_customize->add_setting('blazing_home_hero_subheading', array(
		'default'           => __('Edit this in Customizer', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_hero_subheading', array(
		'type'    => 'text',
		'label'   => __('Sub Heading', 'blazing'),
		'section' => 'blazing_home_hero_section',
	));

	$wp_customize->add_setting('blazing_home_hero_desc', array(
		'default'           => __('Edit Description in Customizer', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_hero_desc', array(
		'type'    => 'text',
		'label'   => __('Description', 'blazing'),
		'section' => 'blazing_home_hero_section',
	));

	$wp_customize->add_setting('blazing_home_hero_btn_text', array(
		'default'           => __('Edit in Customizer', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_hero_btn_text', array(
		'type'    => 'text',
		'label'   => __('Button Text', 'blazing'),
		'section' => 'blazing_home_hero_section',
	));

	$wp_customize->add_setting('blazing_home_hero_btn_link', array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => '#',
	));

	$wp_customize->add_control('blazing_home_hero_btn_link', array(
		'type'    => 'text',
		'label'   => __('Button Link', 'blazing'),
		'section' => 'blazing_home_hero_section',
	));

/*Hero Image*/

/** Recent Posts **/

	$wp_customize->add_section('blazing_home_blog_section', array(
		'title'    => __('Blog', 'blazing'),
		'panel'    => 'blazing_homepage',
		'priority' => 70,
	));

	$wp_customize->add_setting('blazing_home_blog_heading', array(
		'default'           => __('Latest Posts', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_blog_heading', array(
		'type'    => 'text',
		'label'   => __('Heading', 'blazing'),
		'section' => 'blazing_home_blog_section',
	));

	$wp_customize->add_setting('blazing_home_blog_desc', array(
		'default'           => __('Description Latest Posts', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_blog_desc', array(
		'type'    => 'text',
		'label'   => __('Description', 'blazing'),
		'section' => 'blazing_home_blog_section',
	));

	$wp_customize->add_setting('blazing_home_blog_count', array(
		'default'           => 15,
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('blazing_home_blog_count', array(
		'type'    => 'number',
		'section' => 'blazing_home_blog_section',
		'label'   => __('Post Limit', 'blazing'),
	));

/** Recent Posts **/

/** Recent Products **/

	$wp_customize->add_section('blazing_home_newproducts_section', array(
		'title'    => __('Latest Products', 'blazing'),
		'panel'    => 'blazing_homepage',
		'priority' => 30,
	));

	$wp_customize->add_setting('blazing_home_newproducts_heading', array(
		'default'           => __('Latest Products', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_newproducts_heading', array(
		'type'    => 'text',
		'section' => 'blazing_home_newproducts_section',
		'label'   => __('Heading', 'blazing'),
	));

	$wp_customize->add_setting('blazing_home_newproducts_desc', array(
		'default'           => __('Description Latest Product', 'blazing'),
		'sanitize_callback' => 'sanitize_text_field',
	));

	$wp_customize->add_control('blazing_home_newproducts_desc', array(
		'type'    => 'textarea',
		'section' => 'blazing_home_newproducts_section',
		'label'   => __('Description', 'blazing'),
	));

	$wp_customize->add_setting('blazing_home_newproducts_count', array(
		'default'           => 15,
		'sanitize_callback' => 'absint',
	));

	$wp_customize->add_control('blazing_home_newproducts_count', array(
		'type'    => 'number',
		'section' => 'blazing_home_newproducts_section',
		'label'   => __('Product Count', 'blazing'),
	));

/** Recent Products **/

// theme setup info

	$wp_customize->add_section('blazing_setup_info', array(
		'title'      => __('Theme Setup Info', 'blazing'),
		'priority'   => 1,
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_setting('blazing_homepage_setup', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'blazing_sanitize_html',

	));

	$wp_customize->add_control(new Blazing_Info_Text($wp_customize, 'blazing_homepage_setup', array(
		'label'       => __('Home Page Setup', 'blazing'),
		'description' => __('Go To Appearance -> Customize -> Static Front Page -> Front page displays set it to "A static page" -> for Front page select Home. <a class="blazing_go_to_section" href="#accordion-section-static_front_page"> Switch To "A Static Page"</a>', 'blazing'),
		'priority'    => 1,
		'section'     => 'blazing_setup_info',
	)));

	$wp_customize->add_setting('blazing_theme_info_page', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'blazing_sanitize_html',

	));

	$wp_customize->add_control(new Blazing_Info_Text($wp_customize, 'blazing_theme_info_page', array(
		'label'       => __('Blazing Info Page', 'blazing'),
		'description' => sprintf('<a class="button button-default" href="%1$s">%2$s</a>', esc_url(admin_url('themes.php?page=blazing')), esc_html__('See Theme Info Page', 'blazing')),
		'priority'    => 1,
		'section'     => 'blazing_setup_info',
	)));

	$wp_customize->get_setting('blogname')->transport                        = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport                 = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport                = 'postMessage';
	$wp_customize->get_setting('blazing_home_blog_heading')->transport        = 'postMessage';
	$wp_customize->get_setting('blazing_home_blog_desc')->transport           = 'postMessage';
	$wp_customize->get_setting('blazing_home_newproducts_heading')->transport = 'postMessage';
	$wp_customize->get_setting('blazing_home_newproducts_desc')->transport    = 'postMessage';
	$wp_customize->get_setting('blazing_home_hero_image')->transport          = 'postMessage';
	$wp_customize->get_setting('blazing_home_hero_heading')->transport        = 'postMessage';
	$wp_customize->get_setting('blazing_home_hero_subheading')->transport     = 'postMessage';
	$wp_customize->get_setting('blazing_home_hero_desc')->transport           = 'postMessage';
	$wp_customize->get_setting('blazing_home_hero_btn_text')->transport       = 'postMessage';
	$wp_customize->get_setting('blazing_top_email')->transport                = 'postMessage';
	$wp_customize->get_setting('blazing_top_phone')->transport                = 'postMessage';
	

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial('blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'blazing_customize_partial_blogname',
		));
		$wp_customize->selective_refresh->add_partial('blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'blazing_customize_partial_blogdescription',
		));
		$wp_customize->selective_refresh->add_partial('blazing_home_blog_heading', array(
			'selector'        => '.section-blog .section-title',
			'render_callback' => 'blazing_home_blog_heading_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_home_blog_desc', array(
			'selector'        => '.section-blog .section-description',
			'render_callback' => 'blazing_home_blog_desc_partial',
		));
		$wp_customize->selective_refresh->add_partial('blazing_home_newproducts_desc', array(
			'selector'        => '.section-newproducts .section-description',
			'render_callback' => 'blazing_home_newproducts_desc_partial',
		));
		$wp_customize->selective_refresh->add_partial('blazing_home_newproducts_heading', array(
			'selector'        => '.section-newproducts .section-title',
			'render_callback' => 'blazing_home_newproducts_heading_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_home_hero_image', array(
			'selector'        => '.hero-details .hero-image',
			'render_callback' => 'blazing_home_hero_image_partial',
		));
		$wp_customize->selective_refresh->add_partial('blazing_home_hero_heading', array(
			'selector'        => '.hero-captions .hero-title',
			'render_callback' => 'blazing_home_hero_heading_partial',
		));
		$wp_customize->selective_refresh->add_partial('blazing_home_hero_subheading', array(
			'selector'        => '.hero-captions .hero-subtitle',
			'render_callback' => 'blazing_home_hero_subheading_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_home_hero_desc', array(
			'selector'        => '.hero-captions .hero-description',
			'render_callback' => 'blazing_home_hero_desc_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_home_hero_btn_text', array(
			'selector'        => '.hero-buttons .big-button',
			'render_callback' => 'blazing_home_hero_btn_text_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_top_phone', array(
			'selector'        => '.contact-mobile .contact-link',
			'render_callback' => 'blazing_top_phone_partial',
		));

		$wp_customize->selective_refresh->add_partial('blazing_top_email', array(
			'selector'        => '.contact-email  .contact-link',
			'render_callback' => 'blazing_top_email_partial',
		));
		
	}
}
add_action('customize_register', 'blazing_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blazing_customize_partial_blogname() {
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blazing_customize_partial_blogdescription() {
	bloginfo('description');
}

function blazing_home_blog_heading_partial() {
	return esc_html(get_theme_mod('blazing_home_blog_heading'));
}

function blazing_home_blog_desc_partial() {
	return esc_html(get_theme_mod('blazing_home_blog_desc'));
}

function blazing_home_newproducts_desc_partial() {
	return esc_html(get_theme_mod('blazing_home_newproducts_desc'));
}

function blazing_home_newproducts_heading_partial() {
	return esc_html(get_theme_mod('blazing_home_newproducts_heading'));
}

function blazing_home_hero_image_partial() {
	$image_id = get_theme_mod('blazing_home_hero_image');
	if ($image_id) {
		return sprintf('<img class="img-responsive" src="%s">', esc_url(wp_get_attachment_url(absint($image_id))));
	}

}

function blazing_home_hero_heading_partial() {
	return esc_html(get_theme_mod('blazing_home_hero_heading'));
}

function blazing_home_hero_subheading_partial() {
	return esc_html(get_theme_mod('blazing_home_hero_subheading'));
}

function blazing_home_hero_desc_partial() {
	return esc_html(get_theme_mod('blazing_home_hero_desc'));
}

function blazing_home_hero_btn_text_partial() {
	return esc_html(get_theme_mod('blazing_home_hero_btn_text'));
}

function blazing_top_phone_partial() {
	$top_phone = get_theme_mod('blazing_top_phone');
	return sprintf('<a href="callto:%s">%s</a>', esc_attr($top_phone), esc_html($top_phone));
}

function blazing_top_email_partial() {
	$top_email = get_theme_mod('blazing_top_email');
	return sprintf('<a href="mailto:%s">%s</a>', esc_attr($top_email), esc_html($top_email));
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blazing_customize_preview_js() {
	wp_enqueue_script('blazing-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), null, true);
}
add_action('customize_preview_init', 'blazing_customize_preview_js');

if (class_exists('WP_Customize_Control')):
	class Blazing_Info_Text extends WP_Customize_Control {

		public function render_content() {
			?>
		    <span class="customize-control-title">
				<?php echo esc_html($this->label); ?>
			</span>

			<?php if ($this->description) {?>
				<span class="description customize-control-description">
				<?php echo wp_kses_post($this->description); ?>
				</span>
			<?php }
		}

	}

	class Blazing_Upsale_Customize_Control extends WP_Customize_Section {
		public $type = 'apollothemes-upsell';
		public function render() {
			$classes = 'accordion-section control-section-' . $this->type;
			$id      = 'apollothemes-upsell-buttons-section';
			?>
		    <li id="accordion-section-<?php echo esc_attr($this->id); ?>"class="<?php echo esc_attr($classes); ?>">
		        <div class="apollothemes-upsale">
		          	<a href="<?php echo esc_url('https://www.apollothemes.com/product/blazing-pro/'); ?>" target="_blank" class="apollothemes-upsale-bt" id="apollothemes-pro-button"><?php esc_html_e('VIEW PRO VERSION ', 'blazing');?></a>
		        </div>
		    </li>
		    <?php
		}
	}

endif;