<?php if (function_exists('blazing_companion')): ?>
    <div class="home-section space section-about">
    <div class="container">
        <div class="row about-details">
            <div class="col-md-6 about-item about-item-1">
                <div class="about-item-inner">
                    <h2 class="section-title"><?php echo esc_html(get_theme_mod('blazing_home_about_heading')); ?></h2>
                    <p class="section-description"><?php echo esc_html(get_theme_mod('blazing_home_about_desc')); ?></p>
                </div>
            </div>
            <div class="col-md-6 about-item about-item-2">
                <div class="about-item-inner">
                    <?php $image = get_theme_mod('blazing_home_about_image'); ?>
                    <?php if(!empty($image)): ?>
                        <img src="<?php echo esc_url($image); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>