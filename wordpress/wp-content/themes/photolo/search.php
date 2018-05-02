<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package photolo
 */

get_header(); 
$container   = get_theme_mod( 'photolo_container_type' ,'container');
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position' ,'none'); 
?>
<div class="wrapper" id="search-wrapper">
	<div class="<?php //echo esc_attr( $container ); ?>container" id="content" tabindex="-1">
		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php //get_template_part( 'global-templates/left-sidebar-check' ); ?>

				<main id="main" class="site-main ">

				<?php
				if ( have_posts() ) : ?>

					<header class="page-header ">
						<div class="row">
						<h1 class="page-title"><?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'photolo' ), '<span>' . get_search_query() . '</span>' );
						?></h1>
					</div>
					</header><!-- .page-header -->

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					photolo_paging_nav();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->
			
			<!-- Do the right sidebar check -->
			<?php //get_template_part( 'global-templates/right-sidebar-check' ); ?>
		</div>
	</div>
</div>
<?php
get_footer();
