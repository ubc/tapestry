<?php if (function_exists('blazing_companion')): ?>
<div class="home-section space section-testimonials">
    <div class="container">
        <div class="section-heading">
            <h2 class="section-title"><?php echo esc_html(get_theme_mod('blazing_home_testimonials_heading')); ?></h2>
            <p class="section-description"><?php echo esc_html(get_theme_mod('blazing_home_testimonials_desc')); ?></p>
        </div>
        <div class="testimonials-details">
            <div class="testimonial-carousel owl-carousel">
            	<?php $testimonials = json_decode(get_theme_mod('blazing_home_testimonials'), true); ?>
            	<?php if($testimonials): foreach ($testimonials as $key => $testimonial): ?>
                <div class="testi-slide-item">
                    <div class="testi-slide-info">
                        <div class="testi-description">
                            <p class="testimonial-description"><?php echo esc_html($testimonial['description']) ?></p>
                        </div>
                        <div class="testimonoal-item-about">
                            <div class="testimonial-item-photo">
                                <img  class="img-responsive testimonial-item-image" src="<?php echo esc_url($testimonial['image']); ?>">
                            </div>
                            <h2 class="testi-name"><?php echo esc_html($testimonial['heading']) ?></h2>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
