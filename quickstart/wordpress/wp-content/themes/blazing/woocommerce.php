<?php
/**
 * The template for displaying woocommerce pages
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blazing
 */

get_header(); ?>
<div class="container-full space woocommerce-contents">
	<div class="container">
		<div class="row">
			<main id="main" class="col-md-12 col-sm-12 col-xs-12 site-main">
				<div id="site-content" class="row site-page">
					<?php if ( have_posts() ) : ?>
	                    <?php woocommerce_content(); ?>
	                <?php endif; ?>
				</div>
				<div class="clearfix"></div>
			</main><!-- #main -->
		</div>
	</div>
</div>
<?php
get_footer();