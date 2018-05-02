<!-- Our Blog Start-->
<div class="home-section space section-blog">
	<div class="container">
		<div class="section-heading">
	 	    <h2 class="section-title"><?php echo esc_html(get_theme_mod('blazing_home_blog_heading')); ?></h2>
	 	    <p class="section-description"><?php echo esc_html(get_theme_mod('blazing_home_blog_desc')); ?></p>
		</div>
		<div class="blog-details">
			<div class="owl-carousel blog-carousel">
			<?php 
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array( 'post_type' => 'post', 'paged'=>$paged, 'posts_per_page' => 5,);
				$query = new WP_Query( $args );
				$index = 0;
				while($query->have_posts()){
					$query->the_post();
					set_query_var( 'index', $index );
					get_template_part('template-parts/content','home');
					$index++;
				}
				wp_reset_postdata(); 
			?>
			</div>
		</div>
	</div>
</div>
<!-- Our Blog End -->