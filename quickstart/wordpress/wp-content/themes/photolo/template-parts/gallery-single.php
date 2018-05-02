<?php 
global $post;
$layouts = 'grid';
$layouts = esc_attr(get_post_meta($post->ID, 'photolo_gallery_layouts', true));

?>
	<?php
	if (!empty($layouts) && $layouts == 'grid') { ?>
		<div class="gallery-grid ">
			<?php if (is_single() && 'post' == get_post_type()) {
			        the_content();
			         wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			} ?>
		</div>
	<?php 
	} else if (!empty($layouts) && $layouts == 'masonry') { ?>

		<div class="masonry-grid ">
			<?php if (is_single() && 'post' == get_post_type()) {
			        the_content();
			         wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			} ?>
		</div>

	<?php } else if (!empty($layouts) && $layouts == 'packery') { ?>

		<div class="packery-grid ">
			<?php if (is_single() && 'post' == get_post_type()) {
			       the_content();
			        wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			} ?>
		</div>

	<?php } else if (!empty($layouts) && $layouts == 'full') { ?>

		<div class="full-grid ">
			<div class="full-grid-slider ">
			<?php if (is_single() && 'post' == get_post_type()) {
			        the_content();
			} ?>
			</div>
		</div>

	<?php } else { ?>
		<div class="striped-grid ">
			<?php if (is_single() && 'post' == get_post_type()) {
			       the_content();
			        wp_link_pages( array(
		                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'photolo' ),
		                'after'  => '</div>',
		            ) );
			} ?>
		</div>
	<?php }

	?>