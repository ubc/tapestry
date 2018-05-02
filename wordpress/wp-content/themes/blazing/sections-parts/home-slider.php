<?php if (function_exists('blazing_companion')): ?>
<!-- Slider Start  -->
<div class="slider-section section-slider">
	<div class="home-slider">
		<div class="home-carousel owl-carousel">
			<?php
				$slides = json_decode(get_theme_mod('blazing_home_slider'), true);
				$i = 1;
				if($slides){
					foreach ($slides as $key => $slide) {
						?>
						<div class="slide-item">
							<?php 
								if(isset($slide['image'])):
									$slide_img = $slide['image'];
							 	else:
							 		$slide_img = get_template_directory_uri().'/images/slide'.$i.'.jpg';
								endif; 
							?>
							<img src="<?php echo esc_url($slide_img); ?>" class="img-responsive slide-image"/>
							<div class="overlay"></div>
			               	<div class="carousel-caption slide-about">
			               		<?php if(isset($slide['heading'])): ?>
								<h2 class="slide-title animation animated-item-1"> <?php echo esc_html($slide['heading']); ?> </h2>
								<?php endif; ?>
								<?php if(isset($slide['description'])): ?>
								<div class="slide-desc animation animated-item-2"><?php echo wp_strip_all_tags($slide['description']); ?></div>
								<?php endif; ?>								
								<?php if(!empty($slide['button1_url'])): ?>
								<div class="slide-btns">
									<a href="<?php echo esc_url($slide['button1_url']); ?>" class="btn slide-btn slide-btn-1 animation animated-item-3"> <?php echo esc_html($slide['button1_text']); ?> </a>
									<a href="<?php echo esc_url($slide['button2_url']); ?>" class="btn slide-btn slide-btn-2 animation animated-item-3"> <?php echo esc_html($slide['button2_text']); ?> </a>
		                        </div>
								<?php endif; ?>
							</div>
						</div>
						<?php
						if($i == 4){ $i = 0; }
						$i++;
					}
				}
				?>
		</div>			
	</div>
</div>
<!-- Slider End -->
<?php endif; ?>