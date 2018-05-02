<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Algori_Blogger
 */

get_header(); ?>

	<div class="offset"></div>
	<div id="primary" class="content-area">
	
		 <div class="dark-wrapper page-title">
			<div class="container inner">
			 
			 <?php
				 if ( have_posts() ) :
					the_archive_title( '<h1>', '</h1>' );
				 endif;
			 ?>
			
			</div>
		  </div>
		  
		 <div class="light-wrapper">
			<div class="container inner">
			  <div class="row">
				<main id="main" class="site-main col-sm-8 content">
					<div class="classic-blog">

					<?php
					if ( have_posts() ) : ?>

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );

						endwhile;

						echo algori_blogger_get_the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>
					
					</div><!-- .classic-blog -->
				</main><!-- #main -->
				
				
				<?php get_sidebar(); ?>
				<!-- /col-sm-4 .sidebar --> 
				
				
			  </div>
			  <!-- /row --> 
			</div>
			<!-- /container --> 
		  </div>
		  <!-- /light-wrapper -->
	
	</div><!-- #primary -->

<?php
get_footer();
