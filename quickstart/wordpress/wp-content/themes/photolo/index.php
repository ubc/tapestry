<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package photolo
 */

get_header(); 
$container   = get_theme_mod( 'photolo_container_type' ,'container');
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position' ,'none'); 
$blog_layout = get_theme_mod('photolo_blog_page_layout', 'default');
// if($sidebar_pos != 'none'): $container = 'container '; endif;
?>
<div class="wrapper" id="wrapper-index">
	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
			<div class="row">
				<!-- Do the left sidebar check and opens the primary div -->
				<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

					<main id="main" class="site-main">
					
					<?php
					if ( have_posts() ) : ?>

						<?php if ( is_home() && ! is_front_page() ) : ?>
							<header>
								<h1 class="page-title"><?php single_post_title(); ?></h1>
							</header>
						<?php endif; ?>

						<div class="<?php echo esc_attr( $blog_layout ); ?>  fg-blog-post">
							<?php

							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content' );

							endwhile;
							?>
						</div>
					
						<?php photolo_paging_nav();?>
						<div class="screen-reader-text">
							<?php posts_nav_link()  ?>
						</div> 
					<?php else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>

					</main><!-- #main -->
				</div><!-- #primary -->

				<!-- Do the right sidebar check -->
				<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
			</div>
	</div>
</div>
<?php
get_footer();
