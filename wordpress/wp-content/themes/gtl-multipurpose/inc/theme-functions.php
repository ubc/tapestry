<?php
if( ! function_exists( 'gtl_multipurpose_banner_slider' ) ):

	function gtl_multipurpose_banner_slider(){

		$slides = gtl_multipurpose_slider_data();
		?>
		<div class="banner-slider-wrap relative">
			<div class="flexslider top_slider" data-speed="<?php echo gtl_multipurpose_slider_speed();?>" data-animation="<?php echo gtl_multipurpose_slider_animation_speed();?>">
				<ul class="slides">
					<?php 
					foreach( $slides as $slide):
						if( $slide['image']):
							?>
							<li class="slide1" style="background-image: url('<?php echo esc_url($slide['image']); ?>');background-position: center;">
								<div class="<?php echo gtl_multipurpose_site_container();?>  banner-caption">
									<div class="flex_caption1">
										<?php echo apply_filters('gtl_multipurpose_slide_title', $slide['title'], $slide['control'] );?>
										<?php echo apply_filters('gtl_multipurpose_slide_subtitle', $slide['subtitle'] , $slide['control'] );?>						
										<?php 
										$scroll_class= '';
										if( $slide['label'] ):
											if( strpos( $slide['url'] , '#' ) === 0 ){

												$scroll_class = 'do-scrol';
											}
											?>
											<a href="<?php echo esc_url($slide['url']);?>" class="custom-btn secondary-btn <?php echo esc_attr($scroll_class); ?>"><?php echo esc_html( $slide['label'] ); ?></a>
										<?php endif;?>
									</div>
								</div> 
							</li>
						<?php 
						endif;
					endforeach; 
					?>
					</ul>
				</div>
				<?php if( ! esc_attr( get_theme_mod('hide_overlay') ) ):?>
					<div class="banner-overlay"></div>
				<?php endif; ?>
			</div>

		<?php
	}
endif;


if( ! function_exists( 'gtl_multipurpose_banner_image' ) ):

	function gtl_multipurpose_banner_image(){
		?>
		<section id="staticBanner" class="jr-site-static-banner front-page header_height">
			<?php if( esc_attr( get_theme_mod('header_image') ) ){
				the_header_image_tag();
				?>
				<?php }else{?>
				<img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/slider1.jpg');?>">
				<?php } ?>
				<?php if( ! esc_attr( get_theme_mod('hide_overlay') ) ):?>
					<div class="banner-overlay">
					</div>
				<?php endif; ?>
			</section>
			<?php
	} 

endif;



if( ! function_exists( 'gtl_multipurpose_banner_video' ) ):
	function gtl_multipurpose_banner_video(){
?>
		<section id="staticBanner" class="jr-site-static-banner front-page video-banner">
			<?php if( esc_attr ( get_theme_mod('external_header_video') ) ){?>
			<?php 
			echo wp_oembed_get( esc_attr( get_theme_mod('external_header_video') ) , array( 'banner' => 1 ) );
			?>

			<?php }else{?>

			<?php if(get_header_video_url()){?>
			<video controls='false' autoplay muted loop>
				<source src="<?php echo  esc_url(get_header_video_url());?>" type="video/mp4">
					<?php esc_html_e('Your browser does not support the video tag.' , 'gtl-multipurpose')?>
				</video>

				<?php }else{ ?>

				<p class="alert alert-danger">
					<?php esc_html_e('Please upload banner video. Go to: Customize > Banner Setting > Add Media' , 'gtl-multipurpose' );?>
				</p>
				<?php } ?>

				<?php } ?>

				<?php if( ! esc_attr( get_theme_mod('hide_overlay') ) ):?>
					<div class="banner-overlay"></div>
				<?php endif; ?>
			</section>
		<?php
		}

endif;


if( ! function_exists('gtl_multipurpose_slider_data') ):

	function gtl_multipurpose_slider_data(){
		$slide1 	= esc_url( get_theme_mod( 'slider_image_1' ) );
		$title1  	= esc_html( get_theme_mod( 'slider_title_1' ) );
		$subtitle1 	= esc_html( get_theme_mod( 'slider_subtitle_1' ) );
		$label1    	= esc_html( get_theme_mod( 'slider_cta_1_label' )  );
		$url1      	= esc_url( get_theme_mod( 'slider_cta_1_url' ) );

		$slide2 = esc_url( get_theme_mod( 'slider_image_2' ) );
		$title2  = esc_html( get_theme_mod( 'slider_title_2' ) );
		$subtitle2 = esc_html( get_theme_mod( 'slider_subtitle_2' ) );

		$slide3 = esc_url( get_theme_mod( 'slider_image_3' ) );
		$title3  = esc_html( get_theme_mod( 'slider_title_3' ) );
		$subtitle3 = esc_html( get_theme_mod( 'slider_subtitle_3' ) );


		if( ! $title1 && ! $slide1 ){
			$title1 =  __('Welcome to GTL Multipurpose','gtl-multipurpose');
		}
		if( ! $subtitle1 && ! $slide1 ){
			$subtitle1 =  __('Ultimate WordPress theme','gtl-multipurpose');
		}

		if( ! $label1  && ! $slide1 ){
			$label1 = __('Click here','gtl-multipurpose');
		}
		if( ! $url1  && ! $slide1 ){
			$url1 =  '#about';
		}

		if( ! $slide1 ){
			$slide1 = esc_url(get_template_directory_uri().'/assets/images/slider1.jpg');
		}


		if( ! $title2 && ! $slide2 ){
			$title2 = __('Ready to explore great theme?','gtl-multipurpose');
		}
		if( ! $subtitle2  && ! $slide2 ){
			$subtitle2 = __('Feel free to go around','gtl-multipurpose');
		}

		if( ! $slide2 ){
			$slide2 = esc_url(get_template_directory_uri().'/assets/images/slider2.jpg');
		}

		$slider = array(
			array(
				'image' => $slide1,
				'title' => $title1,
				'subtitle' => $subtitle1,
				'label' => $label1,
				'url' => $url1,
				'control' => array( 'title1 captionDelay2 FromTop', 'title2 captionDelay4 FromTop', 'title3 captionDelay6 FromTop','title4 captionDelay7 FromBottom')
				),
			array(
				'image' => $slide2,
				'title' => $title2,
				'subtitle' => $subtitle2,
				'label' => esc_html( get_theme_mod( 'slider_cta_2_label' )  ),
				'url' => esc_url( get_theme_mod( 'slider_cta_2_url' )  ),
				'control' => array( 'title1 captionDelay2 FromTop', 'title2 captionDelay4 FromTop', 'title3 captionDelay6 FromTop','title4 captionDelay7 FromBottom')
				),
			array(
				'image' => $slide3,
				'title' => esc_html( get_theme_mod( 'slider_title_3' ) ),
				'subtitle' => esc_html( get_theme_mod( 'slider_subtitle_3' ) ),
				'label' => esc_html( get_theme_mod( 'slider_cta_3_label' )  ),
				'url' => esc_url( get_theme_mod( 'slider_cta_3_url' )  ),
				'control' => array( 'title1 captionDelay2 FromTop', 'title2 captionDelay4 FromTop', 'title3 captionDelay6 FromTop','title4 captionDelay7 FromBottom')
				)
			);
	return $slider;

}

endif;



if( ! function_exists('gtl_multipurpose_post_single_title') ):

	function gtl_multipurpose_post_single_title(){
		?>
		<div class="flex-box caption">

			<div class="article-wrap onDetails">

				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>

				<?php if( ! esc_attr( get_theme_mod( 'hide_meta_single' ) ) && ( 'post' == get_post_type() ) ):?> 

					<?php gtl_multipurpose_posted_on(); ?>

				<?php endif;?>

				<?php gtl_multipurpose_categories(); ?>

				<?php gtl_multipurpose_comment_count(); ?>



			</div>

		</div>
		<?php
	}

endif;

if( ! function_exists('gtl_multipurpose_dynamic_css') ):
function gtl_multipurpose_dynamic_css(){
	ob_start();
	?>
	<style>
		.header_height{ height:<?php echo gtl_multipurpose_header_height();?>;}
		<?php 
		if( gtl_multipurpose_hide_overlay() ):
		?>
		.slides li:before{ display:none;}
		<?php endif; ?>
		
		body{
			font-family: '<?php echo gtl_multipurpose_body_font_family() ;?>',sans-serif;
			font-size: <?php echo gtl_multipurpose_body_font_size(); ?>;
			color: <?php echo gtl_multipurpose_body_text_color();?>;
		}
		body a{ color:#df3d8c;}
		body a:hover{ color:#4257f2;}
		.site-title a{font-size: <?php echo gtl_multipurpose_site_title_font_size();?>;}
		.site-description{font-size: <?php echo gtl_multipurpose_site_desc_font_size(); ?>;}
		nav.menu-main li a{font-size: <?php echo gtl_multipurpose_main_menu_font_size();?>;}
		h1{font-size: <?php echo gtl_multipurpose_h1_font_size();?>; }
		h2{font-size: <?php echo gtl_multipurpose_h2_font_size();?>; }
		h3{font-size: <?php echo gtl_multipurpose_h3_font_size();?>; }
		h4{font-size: <?php echo gtl_multipurpose_h4_font_size();?>; }
		h5{font-size: <?php echo gtl_multipurpose_h5_font_size();?>; }
		h6{font-size: <?php echo gtl_multipurpose_h6_font_size();?>; }
		header.sticky-header.scrolled,
		.no-banner header.jr-site-header
		{background-color:  <?php echo gtl_multipurpose_header_bg_color();?>!important; }

		h1.site-title{font-size: 32px;margin:0 0 5px 0; }
		nav.menu-main ul>li>a{color:<?php echo gtl_multipurpose_menu_color();?>}
		nav.menu-main ul li a:hover{color:<?php echo gtl_multipurpose_menu_hover_color();?>;}    
		nav.menu-main ul li .sub-menu>li>a{color:<?php echo gtl_multipurpose_sub_menu_color();?>;}
		nav.menu-main ul li .sub-menu{background-color:<?php echo gtl_multipurpose_sub_menu_bg();?>;}

		
		.is-sidebar{
			background-color:  <?php echo gtl_multipurpose_sidebar_bg_color();?>;
			color:  <?php echo gtl_multipurpose_sidebar_color();?>;
		}
		.jr-site-footer{
			background-color:  <?php echo gtl_multipurpose_footer_bg_color();?>;
			color:<?php echo gtl_multipurpose_footer_color();?>;
		}
		.jr-site-footer a{
			color:<?php echo gtl_multipurpose_footer_color();?>;
		}

		.jr-site-footer .copyright-bottom{
			background-color: <?php echo gtl_multipurpose_copyright_bg_color();?>;
			color:<?php echo gtl_multipurpose_copyright_color();?>;
		}


		nav ul li:hover,
		nav ul li.active-page,
		nav ul > li.current-menu-item {
			background-color: #4257f2;
		}

		nav ul li:hover a,
		nav ul li.active-page a,
		nav ul > li.current-menu-item a {
			text-decoration: none;
			color: white;
		}

		.single-post .post-title, h1.page-title{font-size:  <?php echo gtl_multipurpose_single_post_font_size();?>;}

		@media (max-width: 1020px){
			.mobile-menu span {

				background-color: <?php echo gtl_multipurpose_mobile_menu_color();?>;

			}
		}




	</style>
	<?php 
	echo ob_get_clean();
}

endif;
add_action( 'wp_head' , 'gtl_multipurpose_dynamic_css' , 55 );


