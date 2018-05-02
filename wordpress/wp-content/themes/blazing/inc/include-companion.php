<?php
/**
 * This file implements custom requirements for the Blazing Companion plugin.
 * It can be used as-is in themes (drop-in).
 *
 * @package Blazing
 */
if (!function_exists('blazing_companion')) {
	if (class_exists('WP_Customize_Section') && !class_exists('Blazing_Companion_Installer_Section')) {
		/**
		 * Recommend the installation of Blazing Companion using a custom section.
		 *
		 * @see WP_Customize_Section
		 */
		class Blazing_Companion_Installer_Section extends WP_Customize_Section {
			/**
			 * Customize section type.
			 *
			 * @access public
			 * @var string
			 */
			public $type = 'blazing_companion_installer';

			public function __construct($manager, $id, $args = array()) {
				parent::__construct($manager, $id, $args);

				add_action('customize_controls_enqueue_scripts', 'Blazing_Companion_Installer_Section::enqueue');
			}

			/**
			 * enqueue styles and scripts
			 *
			 *
			 **/
			public static function enqueue() {
				wp_enqueue_script('plugin-install');
				wp_enqueue_script('updates');
				wp_enqueue_script('blazing-companion-install', get_template_directory_uri() . '/js/plugin-install.js', array('jquery'));
				wp_localize_script('blazing-companion-install', 'blazing_companion_install',
					array(
						'installing' => esc_html__('Installing', 'blazing'),
						'activating' => esc_html__('Activating', 'blazing'),
						'error'      => esc_html__('Error', 'blazing'),
					)
				);
			}
			/**
			 * Render the section.
			 *
			 * @access protected
			 */
			protected function render() {
				// Determine if the plugin is not installed, or just inactive.
				$plugins   = get_plugins();
				$installed = false;
				foreach ($plugins as $plugin) {
					if ('Blazing Companion' === $plugin['Name']) {
						$installed = true;
					}
				}
				$slug = 'blazing-companion';
				// Get the plugin-installation URL.
				$classes            = 'cannot-expand accordion-section control-section control-section-install-companion control-section-themes  control-section-' . $this->type;
				?>
				<li id="accordion-section-<?php echo esc_attr($this->id); ?>" class="<?php echo esc_attr($classes); ?>">
					<?php if (!$installed): ?>
					<?php 
						$plugin_install_url = add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $slug,
							),
							self_admin_url('update.php')
						);
						$plugin_install_url = wp_nonce_url($plugin_install_url, 'install-plugin_blazing-companion');
					 ?>
						<p><?php esc_attr_e('Blazing Companion plugin is required to take advantage of this theme\'s features in the customizer.', 'blazing');?></p>
						<a class="blazing-plugin-install install-now button-secondary button" data-slug="blazing-companion" href="<?php echo esc_url_raw($plugin_install_url); ?>" aria-label="<?php esc_attr_e('Install Blazing Companion Now', 'blazing');?>" data-name="<?php esc_html_e('Blazing Companion', 'blazing'); ?>">
							<?php esc_html_e('Install & Activate', 'blazing');?>
						</a>
					<?php else: ?>
						<?php 
							$plugin_link_suffix = $slug . '/' . $slug . '.php';
							$plugin_activate_link = add_query_arg(
								array(
									'action'        => 'activate',
									'plugin'        => rawurlencode( $plugin_link_suffix ),
									'plugin_status' => 'all',
									'paged'         => '1',
									'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_link_suffix ),
								), network_admin_url( 'plugins.php' )
							);
						?>
						<p><?php esc_attr_e('You have installed Blazing Companion. Activate it to take advantage of this theme\'s features in the customizer.', 'blazing');?></p>
						<a class="blazing-plugin-activate activate-now button-primary button" data-slug="blazing-companion" href="<?php echo esc_url_raw($plugin_activate_link); ?>" aria-label="<?php esc_attr_e('Activate Blazing Companion now', 'blazing');?>" data-name="<?php esc_html_e('Blazing Companion', 'blazing'); ?>">
							<?php esc_html_e('Activate Now', 'blazing');?>
						</a>
					<?php endif;?>
				</li>
				<?php
}
		}
	}
	if (!function_exists('blazing_companion_installer_register')) {
		/**
		 * Registers the section, setting & control for the Blazing Companion installer.
		 *
		 * @param object $wp_customize The main customizer object.
		 */
		function blazing_companion_installer_register($wp_customize) {
			$wp_customize->add_section(new Blazing_Companion_Installer_Section($wp_customize, 'blazing_companion_installer', array(
				'title'      => '',
				'capability' => 'install_plugins',
				'priority'   => 0,
			)));

		}
		add_action('customize_register', 'blazing_companion_installer_register');
	}
}