<?php 
		$widget_areas = esc_attr( get_theme_mod('footer_widget_areas' , 4) );
		if( ! $widget_areas ){
			$widget_areas = 4;
		}
		if ($widget_areas == 3) {
			$cols = 'footerCol col-md-4';
		} elseif ($widget_areas == 4 ) {
			$cols = 'footerCol col-md-3';
		} elseif ($widget_areas == 2) {
			$cols = 'footerCol col-md-6';
		} else {
			$cols = 'footerCol col-md-12';
		}
	?>

	<?php if ( is_active_sidebar( 'gtl-footer-1' ) ) : ?>
				<div class="col <?php echo esc_attr($cols); ?>">
					<?php dynamic_sidebar( 'gtl-footer-1'); ?>
				</div>
	<?php endif; ?>	

	<?php if ( is_active_sidebar( 'gtl-footer-2' ) ) : ?>
				<div class="col <?php echo esc_attr($cols); ?>">
					<?php dynamic_sidebar( 'gtl-footer-2'); ?>
				</div>
	<?php endif; ?>	

	<?php if ( is_active_sidebar( 'gtl-footer-3' ) ) : ?>
				<div class="col <?php echo esc_attr($cols); ?>">
					<?php dynamic_sidebar( 'gtl-footer-3'); ?>
				</div>
	<?php endif; ?>	

	<?php if ( is_active_sidebar( 'gtl-footer-4' ) ) : ?>
				<div class="col <?php echo esc_attr($cols); ?>">
					<?php dynamic_sidebar( 'gtl-footer-4'); ?>
				</div>
	<?php endif; ?>	