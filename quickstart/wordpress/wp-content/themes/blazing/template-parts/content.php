<?php
/**
 * Template part for displaying posts
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
		                <a class="blog-image-btn" href=""><i class="fa fa-link"></i></a>
		                <a class="blog-image-btn" href=""><i class="fa fa-share"></i></a>
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
			<?php if(is_singular()): ?>
			<div class="blog-single-details">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="entry-content blog-description">
					<?php
						the_content( sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'blazing' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blazing' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
				<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php blazing_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</div>
	    	<?php else: ?>
	        <div class="blog-details">
	            <?php the_title( '<h2 class="entry-title blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	            <div class="entry-summary blog-description"><?php the_excerpt(); ?></div>
				<div class="blog-readmore">
					<a class="btn btn-blog" href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE', 'blazing'); ?></a>
				</div>
				<div class="clearfix"></div>
	        </div>
	    	<?php endif; ?>
	    </div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
