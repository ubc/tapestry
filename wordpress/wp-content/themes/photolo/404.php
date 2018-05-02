<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package photolo
 */

get_header();
$container = get_theme_mod( 'photolo_container_type' ,'container'); 
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position' ,'none'); 
?>
<div class="wrapper" id="error-404-wrapper">
	<div class="<?php // echo esc_attr( $container ); ?>container" tabindex="-1">
		<div class="row">
			<div id="primary" class="content-area col-sm-12">
				<main id="main" class="site-main">

					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( '404', 'photolo' ); ?></h1>
							<h2><?php esc_html_e( 'Page Not Found', 'photolo' ); ?></h2>
						</header><!-- .page-header -->

						<div class="page-content">
							<p><?php esc_html_e( 'Sorry but the page you looking for does not exist', 'photolo' ); ?></p>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Go home', 'photolo' ); ?></a>
						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</div>
<?php
get_footer();