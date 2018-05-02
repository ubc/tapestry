<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package photolo
 */
$limit = esc_attr(get_theme_mod('photolo_blog_description_archive_section',20));
$layouts = get_theme_mod('photolo_blog_page_layout', 'default');
?>
<?php
	if (!empty($layouts) && $layouts == 'default') { ?>
		<article id="post-<?php the_ID(); ?> " <?php post_class(); ?>>
			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
						photolo_posted_on();
						// photolo_posted_by();
					?>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</header><!-- .entry-header -->

			<div class="fg-gallery-grid">
				<?php if ( has_post_thumbnail() ) : ?>
				    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				        <?php the_post_thumbnail('photolo-grid-small'); ?>
				    </a>
				<?php else:?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				       <img src="<?php echo esc_url(get_template_directory_uri().'/images/default_grid.jpg')?>">
				    </a>
				<?php endif; ?>
			</div> 
			<?php the_category( ', ' ); ?>
			<div class="entry-content">
				<div class="fg-gallery-list-excerpt">
		        <?php echo photolo_word_count(get_the_excerpt(), esc_attr($limit)); ?>
			        <div class="bttn-wrap"><a class="btn morelink" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','photolo'); ?></a></div>
			    </div>  
			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->
	<?php 
	} else if (!empty($layouts) && $layouts == 'grid') { ?>

		<div class="gallery-grid-item">
			<?php if ( has_post_thumbnail() ) : ?>
			     <a class="gallery_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
			        <?php the_post_thumbnail('photolo-grid-small'); ?>
			<?php else:?>
				 <a class="gallery_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
			       <img src="<?php echo esc_url(get_template_directory_uri().'/images/default_grid.jpg')?>">
			<?php endif; ?>
			<div class="gallery_description">
	            <div class="gallery_title">
	                <?php the_title(); ?>
	            </div>
	            <div class="gallery_category">
	                <?php the_category( ', ' ); ?>
	            </div>
	        </div>
		</div>

	<?php } else if (!empty($layouts) && $layouts == 'packery') { ?>

		<div class="gallery-grid-item">
			<?php if ( has_post_thumbnail() ) : ?>
			     <a class="gallery_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
			        <?php the_post_thumbnail('photolo-grid-small'); ?>
			<?php else:?>
				 <a class="gallery_link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
			       <img src="<?php echo esc_url(get_template_directory_uri().'/images/default_grid.jpg')?>">
			<?php endif; ?>
			<div class="gallery_description">
	            <div class="gallery_title">
	                <?php the_title(); ?>
	            </div>
	            <div class="gallery_category">
	                <?php the_category( ', ' ); ?>
	            </div>
	        </div>
		</div>
		
	<?php } else if (!empty($layouts) && $layouts == 'fullscreen') { ?>

		<article id="post-<?php the_ID(); ?> " <?php post_class(); ?>>
			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
						photolo_posted_on();
						// photolo_posted_by();
					?>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</header><!-- .entry-header -->

			<div class="fg-gallery-grid">
				<?php if ( has_post_thumbnail() ) : ?>
				    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				        <?php the_post_thumbnail('full'); ?>
				    </a>
				<?php endif; ?>
			</div> 
			<?php the_category( ', ' ); ?>
			<div class="entry-content">
				<div class="fg-gallery-list-excerpt">
		        <?php echo photolo_word_count(get_the_excerpt(), esc_attr($limit)); ?>
			        <div class="bttn-wrap"><a class="btn morelink" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','photolo'); ?></a></div>
			    </div>  
			</div><!-- .entry-content -->

		</article><!-- #post-<?php the_ID(); ?> -->

	<?php } else { ?>
		
	<?php }

	?>

