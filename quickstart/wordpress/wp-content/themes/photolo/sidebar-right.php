<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package photolo
 */

if ( ! is_active_sidebar( 'right-sidebar' ) ) {
	return;
}

// when both sidebars turned on reduce col size to 3 from 4.
$sidebar_pos = get_theme_mod( 'photolo_sidebar_position','none' );
?>

<?php if ( 'both' === $sidebar_pos ) : ?>
<div class="col-md-3 col-sm-3 widget-area" id="right-sidebar" role="complementary">
	<?php else : ?>
<div class="col-md-4 col-sm-4 widget-area" id="right-sidebar" role="complementary">
	<?php endif; ?>
<?php dynamic_sidebar( 'right-sidebar' ); ?>

</div><!-- #secondary -->
