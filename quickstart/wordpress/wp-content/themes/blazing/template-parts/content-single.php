<article  id="post-<?php the_ID(); ?>"  <?php post_class("col-md-12 post-item content-single"); ?>>
	<div class="post-inner">
	    <div class="bolg-slide-photo">
	    	<?php if(has_post_thumbnail()):  ?>
	        <div class="img-thumbnail">
				<?php the_post_thumbnail('full', array( 'class' => 'img-responsive' )); ?>
			</div>
			<?php endif; ?>
	    </div>
	    <div class="blog-slide-info">
	    	<div class="entry-meta  post-meta">
	    		<?php blazing_posted_on(); ?>
	    	</div>
	        <div class="blog-details">
	            <?php the_title( '<h1 class="entry-title  blog-title blog-single-title">', '</h1>' ); ?>
	            <div class="entry-content">
					<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blazing' ),
							'after'  => '</div>',
						) );
					?>
					<div class="clearfix"></div>
				</div><!-- .entry-content -->
				<div class="clearfix"></div>
				<div class="entry-footer">
					<?php blazing_entry_footer(); ?>
				</div>	
	        </div>
	    </div>
	</div>
</article>
<div class="clearfix"></div>