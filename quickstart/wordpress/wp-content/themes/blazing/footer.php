<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blazing
 */

?>

	</div><!-- #content -->
	<!-- Footer Start -->
    <footer id="colophon" class="site-footer footer" role="contentinfo">
        <div class="container-fluid footer-widgets">
            <div class="container">
				<div class="row theme-widgets">
					<?php 
						$footer_widget  = array(
							'name' 			=> esc_html__( 'Footer Widget Area', 'blazing' ),
							'id' 			=> 'footer-widget-area',
							'description' 	=> esc_html__( 'footer widget area', 'blazing' ),
							'before_widget' => '<div id="%1$s" class="col-md-3 col-sm-6 widget footer-widget">',
							'after_widget'  => '</div>',
							'before_title'  => '<div class="widget-heading"><h3 class="widget-title">',
							'after_title'   => '</h3></div>',
						);

					   if ( is_active_sidebar( 'footer-widget-area' ) ) {
							 dynamic_sidebar( 'footer-widget-area'); 
						 }else{ 
							the_widget('WP_Widget_Calendar', 'title='.esc_attr__('Calendar', 'blazing'), $footer_widget);
							the_widget('WP_Widget_Categories', null, $footer_widget);
							the_widget('WP_Widget_Pages', null, $footer_widget);
							the_widget('WP_Widget_Archives', null, $footer_widget);
						} 
					?>
				</div>
            </div>
        </div>
        <div class="conatainer-fluid copy-bar">
            <div class="container">
                <div class="col-md-6 col-sm-12 footer-copy">
                    <p>&copy; <?php echo esc_html(date_i18n(__('Y', 'blazing'))).' '; bloginfo( 'name' ); ?> | <?php printf( esc_html__( 'Theme by %1$s', 'blazing' ),  '<a href="'.esc_url('https://www.apollothemes.com').'" rel="designer">ApolloThemes</a>' ); ?></p>
                </div>
                <div class="col-md-6 col-sm-12 footer-right">
                    <?php wp_nav_menu( array( 'theme_location' => 'footer_nav', 'fallback_cb'    => false ) ); ?>
                </div>
            </div>
        </div>
        <a class="back-to-top" href="#" title="<?php esc_html_e('Back To Top', 'blazing') ?>"><i class="fa fa-angle-top"></i></a>
    </footer><!-- #colophon -->
    <!-- Footer End -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
