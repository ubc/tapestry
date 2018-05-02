<form role="search" method="get" class="search-form blazing-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="input-search search-elem" placeholder="<?php esc_attr_e('Search For Item','blazing'); ?>" value="<?php the_search_query(); ?>" name="s" title="<?php esc_attr_e('Search for:','blazing'); ?>">
	<div class="search-cat">
		<?php 
			$swp_cat_dropdown_args = array(
				'taxonomy' 		   => 'product_cat',
				'show_option_all'  => esc_html__( 'All', 'blazing'),
				'name'             => 'product_cat',
				'class'            => 'search-elem search-categorey',
				'value_field'	   => 'slug',
				'selected'         => (isset($_GET['product_cat']) && $_GET['product_cat'])?sanitize_text_field($_GET['product_cat']):false,
			);
			wp_dropdown_categories( $swp_cat_dropdown_args );
		 ?>
		 <label for="product_cat"><i class="fa fa-sort-desc"></i></label>
	</div>
	<button type="submit" class="search-elem btn btn-search"><?php esc_html_e('Search','blazing'); ?></button>
	<input type="hidden" name="post_type" value="product">
</form>