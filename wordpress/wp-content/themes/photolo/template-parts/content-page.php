<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package photolo
 */
global $post;
$layouts = 'grid';
$layouts = esc_attr(get_post_meta($post->ID, 'photolo_gallery_layouts', true));
$content = $post->post_content;
?>
<?php 
if ( has_shortcode( $content, 'gallery' ) ) {

	if (!empty($layouts) && $layouts == 'grid') { ?>
		<div class="row">
			<div class="gallery-grid ">
				<?php
				        the_content();
				         wp_link_pages( array(
			                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
			                'after'  => '</div>',
			            ) );
				?>
			</div>
		</div>
	<?php 
	} else if (!empty($layouts) && $layouts == 'masonry') { ?>
		<div class="row">
		<div class="masonry-grid ">
			<?php
			        the_content();
			         wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			?>
		</div>
		</div>
	<?php } else if (!empty($layouts) && $layouts == 'packery') { ?>
		<div class="row">
		<div class="packery-grid ">
			<?php 
			       the_content();
			        wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			 ?>
		</div>
		</div>
	<?php } else if (!empty($layouts) && $layouts == 'full') { ?>
	<?php 
	function photolo_scripts_bxslider() {
		wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array(), '20151215', true ); 
	}
	add_action( 'wp_enqueue_scripts', 'photolo_scripts_bxslider' );
	?>
		<div class="row">
		<div class="full-grid ">
			<div class="full-grid-slider ">
			<?php 
			        the_content();
			?>
			</div>
		</div>
		</div>
	<?php } else { ?>
		<div class="row">
		<div class="striped-grid ">
			<?php 
			       the_content();
			        wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			 ?>
		</div>
		</div>
	<?php }
} else { ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( !is_front_page() && !is_home() ) : ?>
		<header class="entry-header">
			<?php  the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
		<?php endif; ?>
		<?php photolo_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Edit <span class="screen-reader-text">%s</span>', 'photolo' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						),
						'<span class="edit-link">',
						'</span>'
					);
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php } ?>
