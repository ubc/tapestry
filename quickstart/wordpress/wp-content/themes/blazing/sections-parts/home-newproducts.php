<?php if(blazing_is_wc()): ?>
<!-- Product  Start -->
<div class="home-section space section-newproducts">
	<div class="container">
		<div class="section-heading white-heading">
			<h2 class="section-title"><?php echo esc_html(get_theme_mod('blazing_home_newproducts_heading')); ?></h2>
	 	    <p class="section-description"><?php echo esc_html(get_theme_mod('blazing_home_newproducts_desc')); ?></p>
		</div>
		<div class="newproducts-details woocommerce">
			<div class="newproducts-carasol products owl-carousel">
			<?php
				$product_count = absint(get_theme_mod('blazing_home_newproducts_count', 15));
				$query_args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => $product_count, 'orderby' =>'date','order' => 'DESC' );
				$products = new WP_Query( $query_args );
				while($products->have_posts()){
					$products->the_post();
					wc_get_template_part( 'content-product-home' );
				}
				wp_reset_postdata();
			?>
			</div>
		</div>
	</div>
</div>
<!-- Product End -->
<?php endif; ?>