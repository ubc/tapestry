<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package photolo
 */
$container   = get_theme_mod( 'photolo_container_type' ,'container');
?>

	</div><!-- #content -->
</div><!-- #page -->
<div class="wrapper" id="wrapper-footer">
	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-sm-12">
					<div class="site-info">
						<?php
							dynamic_sidebar( 'copyright_text' ); 
						?>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div>
<?php wp_footer(); ?>

</body>
</html>
