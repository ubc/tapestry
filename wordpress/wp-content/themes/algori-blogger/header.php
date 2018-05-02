<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Algori_Blogger
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

<body <?php body_class('full-layout'); ?> >
<div id="page" class="site body-wrapper">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'algori-blogger' ); ?></a>

    	
	<header id="masthead" class="site-header yamm navbar basic default">

		<div class="navbar-header">
      		<div class="container">

			    <div class="site-branding basic-wrapper"> 
					<a class="btn responsive-menu pull-right" data-toggle="collapse" data-target=".navbar-collapse">
						<i class='fa fa-bars'></i>
					</a> 
					
					<?php algori_blogger_display_logo();  ?>

				</div><!-- .site-branding -->
				
				<nav id="site-navigation" class="main-navigation collapse navbar-collapse pull-right">
				
					<?php
					if (has_nav_menu('menu-1')) {
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'container' => false,
							'menu_class' => 'nav navbar-nav',
							'walker' => new Algori_Blogger_Walker_Nav_Primary()
						) );
					}
					?>
					
				</nav><!-- #site-navigation -->
				

	  		</div>
		</div><!-- .navbar-header -->
		
	</header><!-- #masthead -->
	
		<?php if ( get_header_image() && is_front_page() ): // Display header image if it exists ?>
		<div class="offset"></div>
		<div class="header-hero">
          
		  <span class="hero-media">
			<?php the_header_image_tag(); ?>
		  </span>
		  
		  <div class="hero-info">
			
			<h1 class="hero-title" ><?php esc_html_e( 'Welcome to ', 'algori-blogger' ); echo bloginfo( 'name' ); ?></h1>
			
			<?php 
			// display site description if defined
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ):?>
			
			<p class="hero-description" >
				<?php /* translators: %s: Site Description */
					printf( esc_html__(' %s', 'algori-blogger'), esc_attr($description) ); 
				?>
			</p>
			<?php else:?>
			<br/><br/>
			<?php endif; ?>
			
			<div class="hero-btn">
			  <a href="#content" class="btn btn-large"><?php esc_html_e( 'Start Here', 'algori-blogger' ); ?></a>
			</div>
		  
		  </div><!-- .hero-info -->
		  
		</div><!-- .header-hero -->
		<?php endif;?>
		
	
	<div id="content" class="site-content">
