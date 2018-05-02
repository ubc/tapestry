<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Blazing
 */

get_header(); ?>

<div class="container-full space blog-post-index content-area">
	<div class="container">
		<div class="row">
			<main id="main" class="col-md-9 col-sm-12 col-xs-12 blog-left blog-posts-wrap site-main">
				<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<h1 class="page-title"><?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'blazing' ), '<span>' . get_search_query() . '</span>' );
						?></h1>
					</header><!-- .page-header -->
					<div id="blog-content" class="row blog-gallery blog-posts">
					<?php 
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', 'search' );
						endwhile;
					?>
					</div>
					<div class="clearfix"></div>
					<div class="blog-pagination">
						<?php the_posts_pagination(); ?>
					</div>
				<?php
					else :
						get_template_part( 'template-parts/content', 'none' );
				endif; ?>
			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
