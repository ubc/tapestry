<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package photolo
 */

get_header(); 
$container   = get_theme_mod( 'photolo_container_type' ,'container');
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position' ,'none'); 
$post_id = get_the_ID();
$post_format = get_post_format($post_id);
?>
<?php if ($post_format == 'gallery') : ?>
	<div class="wrapper" id="single-wrapper">
		<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
		    <div class="image-gallery-format row">
		    		<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/gallery', 'single' );


						endwhile; // End of the loop.
						?>

		    </div>
		</div>
	</div>
<?php else : ?>
<div class="wrapper" id="single-wrapper">
	<div class="container" id="content" tabindex="-1">
			<div class="row">
				<!-- Do the left sidebar check and opens the primary div -->
				<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

					<main id="main" class="site-main">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'single' );

							the_post_navigation();
							
							//If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</main><!-- #main -->
				</div><!-- #primary -->

				<!-- Do the right sidebar check -->
				<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
			</div>
	</div>
</div>
<?php endif; ?>
<?php

get_footer();
