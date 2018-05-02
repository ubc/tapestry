<?php if (function_exists('blazing_companion')): ?>
<div class="home-section space section-services">
    <div class="container">
        <div class="section-heading white-heading">
            <h2 class="section-title"><?php echo esc_html(get_theme_mod('blazing_home_services_heading')); ?></h2>
            <p class="section-description"><?php echo esc_html(get_theme_mod('blazing_home_services_desc')); ?></p>
        </div>
        <div class="row services-details">
        	<?php $services = json_decode(get_theme_mod('blazing_home_services'), true); ?>
        	<?php if($services): foreach ($services as $key => $service): ?>
            <div class="col-md-4 col-sm-6 service-column">
                <div class="service-column-inner">
                     <div class="service-inner-info">
                        <div class="service-icon">
                            <i class="icon-service fa <?php echo esc_attr($service['icon']); ?>"></i>
                        </div>
                        <div class="service-detail">
                            <h3 class="service-title"><?php echo esc_html($service['heading']); ?></h3>
                            <p class="service-description"><?php echo esc_html($service['description']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>