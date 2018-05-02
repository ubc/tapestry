<?php
/**
* Page builder support
*
* @package Gtl_Multipurpose
*/

/* Add/Replace default row options */
function Gtl_Multipurpose_row_styles($fields) {

	$fields['padding'] = array(
		'name' => __('Top/Bottom padding', 'gtl-multipurpose'),
		'type' => 'measurement',
		'default'=>'100',
		'priority' => 3,
		'group'	   => 'layout'
		);

	$fields['row_container'] = array(
		'name'        => __('Container', 'gtl-multipurpose'),
		'type' 		  => 'select',
		'group'       => 'layout',
		'options' => array(
			'container-large' => __('Large', 'gtl-multipurpose'),
			'container-medium' => __('Medium', 'gtl-multipurpose'),
			'container-small' => __('Small', 'gtl-multipurpose'),
			'container-fluid' => __('Fullwidth/Fluid', 'gtl-multipurpose'),
			),
		'default'	  => 'medium',
		'description' => __('Container type', 'gtl-multipurpose'),
		'priority'    => 10,
		);	

	$fields['color'] = array(
		'name' => __('Color', 'gtl-multipurpose'),
		'type' => 'color',
		'default'=>'#4f4f4f',
		'description' => __('Color of the row.', 'gtl-multipurpose'),
		'priority' => 5,
		'group'	   => 'design'	
		);

	$fields['background_image'] = array(
		'name' => __('Background Image', 'gtl-multipurpose'),
		'type' => 'image',
		'description' => __('Background image of the row.', 'gtl-multipurpose'),
		'priority' => 6,
		'group'		=> 'design'
		);

	$fields['enable_overlay'] = array(
		'name'        => __('Enable row overlay?', 'gtl-multipurpose'),
		'type'        => 'checkbox',
		'group'       => 'design',
		'priority'    => 8,
		);

	return $fields;

}

add_filter('siteorigin_panels_row_style_fields', 'Gtl_Multipurpose_row_styles');



/* Filter for the styles */

function Gtl_Multipurpose_row_styles_output( $attr, $style ) { 

	$bg = true;
	$padding = false;
	if( isset( $style['padding'] ) ){

		$padding = $style['padding'];
		$paddingInt = (int) $padding;
	}

	if( ! $padding && ! is_numeric( $padding ) &&  $padding !== 0 ){

		$attr['style'] .= 'padding: 100px 0; ';

	}else if( $paddingInt === 0 ) {

		$attr['style'] .= 'padding: 0; ';

	} else{

		$attr['style'] .= 'padding: ' . esc_attr($style['padding']) . ' 0; ';
	}

	if( !empty( $style['row_container'] ) ) {

		$attr['data-container']  = esc_attr($style['row_container']);
	}


	if(!empty($style['color'])) {

		$attr['style'] .= 'color: ' . esc_attr($style['color']) . ';';
		$attr['data-hascolor'] = 'hascolor';
	}

	if( ! empty( $style['background_display'] )  && ! empty( $style['background_image'] ) ){

		$url = wp_get_attachment_image_src( $style['background_image'], 'full' );

		if( $style['background_display'] == 'parallax' || $style['background_display'] == 'parallax-original' ){
			$attr['class'][] = 'parallax-window';

			if( ! empty( $url ) ) {
				$attr['style'] .= 'background-size: cover;';
				$attr['data-parallax']=  'scroll';
				$attr['data-image-src']=  $url[0];
				$bg = false;
			}

		}


	}

	if( $bg ):

		if(!empty( $style['background_image'] )) {
			$url = wp_get_attachment_image_src( $style['background_image'], 'full' );
			if( !empty($url) ) {

				$attr['style'] .= 'background-image: url(' . esc_url($url[0]) . ');';
				$attr['data-hasbg'] = 'hasbg';
				if( $style['background_display'] == 'fixed'  ){

					$attr['style'] .= 'background-size: cover;background-attachment:fixed;background-position:bottom';

				}
			}
		}

		endif;	

		if ( ! empty($style['enable_overlay']) ) {
			$attr['data-overlay'] = 'true';
			$attr['class'][] = 'has-overlay';
		}



		if(empty($attr['style'])){

			unset($attr['style']);
		} 

		return $attr;
	}
	add_filter('siteorigin_panels_row_style_attributes', 'Gtl_Multipurpose_row_styles_output', 10, 2);


/**
* Page builder widget options
*/
function Gtl_Multipurpose_widget_style_fields($fields) {

	$fields['content_alignment'] = array(
		'name'        => __('Content alignment', 'gtl-multipurpose'),
		'type' 		  => 'select',
		'group'       => 'design',
		'options' => array(
			'left' => __('Left', 'gtl-multipurpose'),
			'center' => __('Center', 'gtl-multipurpose'),
			'right' => __('Right', 'gtl-multipurpose'),
			),
		'default'	  => 'left',
		'description' => __('This setting depends on the content, it may or may not work', 'gtl-multipurpose'),
		'priority'    => 10,
		);	
	$fields['title_color'] = array(
		'name'        => __('Widget title color', 'gtl-multipurpose'),
		'type'        => 'color',
		'default'	  => '#443f3f',
		'group'       => 'design',
		'priority'    => 11,
		);	


	return $fields;
}

add_filter( 'siteorigin_panels_widget_style_fields', 'Gtl_Multipurpose_widget_style_fields');



/**
* Remove widget defaults
*/
function Gtl_Multipurpose_remove_default_so_widget_styles( $fields ) {

	unset( $fields['background_display'] );
	unset( $fields['mobile_padding'] );
	return $fields;

}

add_filter('siteorigin_panels_widget_style_fields', 'Gtl_Multipurpose_remove_default_so_widget_styles' );



/**
* Output page builder widget options
*/
function Gtl_Multipurpose_widget_style_attributes( $attributes, $args ) {

	if ( !empty($args['title_color']) ) {

		$attributes['data-title-color'] = esc_attr($args['title_color']);	

	}


	if ( !empty($args['content_alignment']) ) {

		$align = $args['content_alignment'];
		if( $align == 'left'){

			$falign = 'flex-start';

		}else if($align == 'center'){

			$falign = 'center';

		}else if( $align == 'right' ){

			$falign = 'flex-end';
		}

		$attributes['style'] .= 'text-align: ' . esc_attr($args['content_alignment']).';';
		$attributes['class'][] = 'justify-'. esc_attr($args['content_alignment']);
	}	
	return $attributes;
}

add_filter('siteorigin_panels_widget_style_attributes', 'Gtl_Multipurpose_widget_style_attributes', 10, 2);



/**
* Remove row defaults
*/
function Gtl_Multipurpose_remove_default_so_row_styles( $fields ) {

	unset( $fields['background_image_attachment'] );
	unset( $fields['mobile_padding'] );
	unset( $fields['border_color'] );	
	unset( $fields['bottom_margin'] );	
	unset( $fields['gutter'] );	
	unset( $fields['collapse_behaviour'] );
	unset( $fields['row_stretch'] );	
	unset( $fields['collapse_order'] );	
	unset( $fields['cell_alignment'] );	
	return $fields;
}

add_filter('siteorigin_panels_row_style_fields', 'Gtl_Multipurpose_remove_default_so_row_styles' );
add_filter('siteorigin_premium_upgrade_teaser', '__return_false');

