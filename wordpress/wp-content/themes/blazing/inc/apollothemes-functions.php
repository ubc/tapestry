<?php 
function blazing_get_social_block($ul_class = '') {
    $new_tab  = get_theme_mod('blazing_social_new_tab', true);
    $socials = json_decode(get_theme_mod('blazing_socials'), true);
    $is_all_empty  = true;
    ?>
        <ul class="slinks <?php echo esc_attr($ul_class); ?>">
            <?php if($socials): foreach ($socials as $key => $social):?>
                <?php if(!empty($social['link']) && !empty($social['icon'])): ?>
                <li><a href="<?php echo esc_url($social['link']); ?>"  <?php echo absint($new_tab)?'target="_blank"':''; ?>><i class="fa <?php echo esc_attr($social['icon']); ?>"></i></a></li>
                <?php endif; ?>
            <?php endforeach;  endif; ?>
        </ul>
    <?php
}

function blazing_get_contact_block(){
     $top_phone = get_theme_mod('blazing_top_phone'); if(!empty($top_phone)):?>
    <li class="contact-info-item"><span class="contact-item contact-mobile"><a href="callto:<?php echo esc_attr($top_phone); ?>"><i class="fa fa-headphones"></i><span class="contact-link"><?php echo esc_html($top_phone); ?></span></a></span></li>
    <?php endif; ?>
    <?php $top_email = get_theme_mod('blazing_top_email'); if(!empty($top_email)): ?>
    <li class="contact-info-item"><span class="contact-item contact-email"><a href="mailto:<?php echo esc_attr($top_email); ?>"><i class="fa fa-envelope"></i><span class="contact-link"><?php echo esc_html($top_email); ?></span></a></span></li>
    <?php endif;
}

function blazing_excerpt_more($more) {
    if ( is_admin() ) {
        return $more;
    }    
    return '';
}
add_filter('excerpt_more', 'blazing_excerpt_more');

function blazing_is_wc(){

    if ( class_exists( 'WooCommerce' ) ) {
        return true;
    }else{
        return false;
    }

}

function blazing_comment_form_fields($fields) {

    $fields['author'] = '<div class="form-group col-md-4"><label  for="name">' . __('NAME', 'blazing') . ':</label><input type="text" class="form-control" id="name" name="author" placeholder="' . esc_attr__('Full Name', 'blazing') . '"></div>';
    $fields['email']  = '<div class="form-group col-md-4"><label for="email">' . __('EMAIL', 'blazing') . ':</label><input type="email" class="form-control" id="email" name="email" placeholder="' . esc_attr__('Your Email Address', 'blazing') . '"></div>';
    $fields['url']    = '<div class="form-group col-md-4"><label  for="url">' . __('WEBSITE', 'blazing') . ':</label><input type="text" class="form-control" id="url" name="url" placeholder="' . esc_attr__('Website', 'blazing') . '"></div>';
    return $fields;
}
add_filter('comment_form_fields', 'blazing_comment_form_fields');

function blazing_comment_form_defaults($defaults) {
    $defaults['submit_field']   = '<div class="form-group col-md-4">%1$s %2$s</div>';
    $defaults['comment_field']  = '<div class="form-group col-md-12"><label  for="message">' . __('COMMENT', 'blazing') . ':</label><textarea class="form-control" rows="5" id="comment" name="comment" placeholder="' . esc_attr__('Message', 'blazing') . '"></textarea></div>';
    $defaults['title_reply_to'] = __('Post Your Reply Here To %s', 'blazing');
    $defaults['class_submit']   = 'btn btn-theme';
    $defaults['label_submit']   = __('SUBMIT COMMENT', 'blazing');
    $defaults['title_reply']    = '<h2>' . __('Post Your Comment Here', 'blazing') . '</h2>';
    $defaults['role_form']      = 'form';
    return $defaults;

}
add_filter('comment_form_defaults', 'blazing_comment_form_defaults');

function blazing_comment($comment, $args, $depth) {
    // get theme data.
    global $comment_data;
    // translations.
    $leave_reply = $comment_data['translation_reply_to_coment'] ? $comment_data['translation_reply_to_coment'] : __('Reply', 'blazing');?>
        <div class="col-xs-12 border">
            <div class="col-xs-2">
            <?php echo get_avatar($comment, $size = '80'); ?>
            </div>
            <div class="col-xs-10">
                <h4><?php comment_author();?></h4>
                <h5><?php if (('d M  y') == get_option('date_format')): ?>
                <?php comment_date('F j, Y');?>
                <?php else: ?>
                <?php comment_date();?>
                <?php endif;?>
                <?php esc_html_e('at', 'blazing');?>&nbsp;<?php comment_time('g:i a');?></h5>
                <p><?php comment_text();?></p>
                <?php comment_reply_link(array_merge($args, array('reply_text' => $leave_reply, 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                <?php if ($comment->comment_approved == '0'): ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'blazing');?></em>
                <br/>
                <?php endif;?>
            </div>
        </div>
        <?php
}


function blazing_menu_items ( $items, $args ) {
    $show_menu_cart = absint(get_theme_mod('blazing_show_menu_cart', true));
    
    if ($show_menu_cart && blazing_is_wc() && $args->theme_location == 'primary' ) {
        $items .= sprintf('<li class="menu-item menu-cart-link">%s</li>', blazing_woocommerce_header_cart());
    }
    
    return $items;
}
add_filter( 'wp_nav_menu_items', 'blazing_menu_items', 10, 2 );