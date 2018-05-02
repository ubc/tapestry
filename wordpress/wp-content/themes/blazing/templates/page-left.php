<?php
/**
 * Template Name: Left Sidebar
 *
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blazing
 */
get_header();
?>
<div class="container-full space blog-post-index content-area">
    <div class="container">
        <div class="row">
            <main id="main" class="col-md-9 col-sm-12 col-xs-12 blog-right site-main pull-right">
                    <div id="blog-content" class="row apt-singuler single-page">
                        <?php
                            while ( have_posts() ) : the_post();

                                get_template_part( 'template-parts/content', 'page' );

                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) :
                                    comments_template();
                                endif;

                            endwhile; // End of the loop.
                            ?>
                    </div>
                    <div class="clearfix"></div>
            </main><!-- #main -->
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php
get_footer();