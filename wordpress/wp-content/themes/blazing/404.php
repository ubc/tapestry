<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Blazing
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main page-404">
			<div class="container">
				<section class="error-404 not-found">
					<div class="page-content">
						<h2 class="code-404"><?php esc_html_e('404', 'blazing') ?></h2>
						<h2 class="title-404"><span class="fa fa-exclamation-circle"></span><?php esc_html_e('ERROR','blazing'); ?></h2>
						<h3><?php esc_html_e('Page cannot be found','blazing'); ?></h3>
						<p><?php esc_html_e('The Page you requested is not be found. This could be spelling error in the url.','blazing'); ?></p>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-theme"><?php esc_html_e('Go back to Home Page','blazing'); ?></a>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
