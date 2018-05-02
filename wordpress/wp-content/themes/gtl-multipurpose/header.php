<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTL_Multipurpose
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>


<body <?php body_class( gtl_multipurpose_body_site_layout() ); ?> data-container="<?php echo gtl_multipurpose_site_container();?>">
<?php if(is_home() || is_front_page()): ?>
<div id="preloader">
  <div id="status"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/preloader.gif'); ?> "></div>
</div>
<?php endif;?>

<!--Mobile view ham menu-->
<div class="mobile-menu">
    <span></span>
    <span></span>
    <span></span>
</div>
<!--Ends-->

<div class="body-wrapp <?php echo gtl_multipurpose_header_type();?>">

    <!--Header Component-->
    <header id="siteHeader" class="jr-site-header pd-a-15 <?php  gtl_multipurpose_header_class(); ?>">

        <div class="<?php echo gtl_multipurpose_site_container();?>">
            <div class="row align-flex-item-center full-width">
                <div class="col-md-3">
                    <div class="logo-holder">
                        <?php
                        the_custom_logo();
                        if( display_header_text() ):
                        ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php 
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) : ?>
                                <p class="site-description"><?php echo esc_html($description); ?></p>
                            <?php
                            endif; 
                        endif; 
                        ?>
                    </div>
                </div>
                <div class="col-md-9 text-align-right">
                <?php 

                ?>
                    <nav class="menu-main">
                    <?php 
                                wp_nav_menu( array(
                                    'theme_location' => 'primary-menu',
                                    'menu_id'        => 'primary-menu',
                                    'menu_class'     => 'floted-li clearfix d-i-b',
                                     'walker'        => '',
                                    'fallback_cb'    => 'wp_page_menu',
                                ) );

                    ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

	
