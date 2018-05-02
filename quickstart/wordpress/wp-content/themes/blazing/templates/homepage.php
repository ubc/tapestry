<?php 
/*
* Template Name: Home Page
*/

get_header();
	$home_sections  = json_decode(get_theme_mod('blazing_home_layout', json_encode(array('slider', 'hero', 'newproducts', 'about', 'services', 'blog', 'testimonials', 'brands'))));
	foreach ($home_sections as $key => $section) {
	 	get_template_part('sections-parts/home', $section);
	}
get_footer();
