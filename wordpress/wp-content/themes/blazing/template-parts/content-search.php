<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blazing
 */

?>
<article  id="post-<?php the_ID(); ?>"  <?php post_class("col-md-6 post-item content-index"); ?>>
	<div class="post-inner">
	    <div class="bolg-slide-photo">
	        <?php if(has_post_thumbnail()): ?>
			<?php the_post_thumbnail('blazing-thumb', array( 'class' => 'img-responsive blog-image' )); ?>
				<div class="blog-image-overlay">
		            <div class="blog-image-btns">
		                <a class="blog-image-btn post-zoom" href="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')); ?>"><i class="fa fa-search-plus"></i></a>
		                <a class="blog-image-btn" href="<?php the_permalink(); ?>"><i class="fa fa-link"></i></a>
		            </div>
		        </div>
			<?php else: ?>
				<img src="<?php echo esc_url(get_template_directory_uri().'/images/blog-paceholder.png'); ?>" class="img-responsive blog-photo">
			<?php endif; ?>
	    </div>
	    <div class="blog-slide-info">
	    	<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta  post-meta">
				<?php blazing_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
	        <div class="blog-details">
	            <?php the_title( '<h2 class="entry-title blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	            <div class="entry-summary blog-description"><?php the_excerpt(); ?></div>
				<div class="blog-readmore">
					<a class="btn btn-blog" href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE', 'blazing'); ?></a>
				</div>
				<div class="clearfix"></div>
	        </div>
	    </div>
	</div>
</article>