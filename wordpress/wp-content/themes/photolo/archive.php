<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package photolo
 */

get_header(); 
$container   = get_theme_mod( 'photolo_container_type' ,'container');
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position' ,'none'); 
$blog_layout = get_theme_mod('photolo_blog_page_layout', 'grid');

?>
<div class="wrapper" id="archive-wrapper">
	<div class="<?php echo esc_attr( $container ); ?>" >

			<!-- Do the left sidebar check and opens the primary div -->
			<?php //get_template_part( 'global-templates/left-sidebar-check' ); ?>

				<main id="main" class="site-main">

				<?php
				if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><!-- .page-header -->
					<div class="<?php echo esc_attr( $blog_layout ); ?> fg-blog-post">
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content' );

					endwhile; ?>
					</div>
				<?php photolo_paging_nav();?>
						
				<?php else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

				</main><!-- #main -->
			
			<!-- Do the right sidebar check -->
			<?php //get_template_part( 'global-templates/right-sidebar-check' ); ?>
		</div>
	</div>
</div>
<?php
get_footer();
