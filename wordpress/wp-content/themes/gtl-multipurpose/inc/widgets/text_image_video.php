<?php
/**
 * Widget for intro section
 *
 * @package    	GTL_Components
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_text_image_video' ) ):

	/**
	 * Intro section
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_text_image_video extends WP_Widget{

		function __construct(){

			parent::__construct(
				'gtl-multipurpose-text-image-video', 
				esc_html__( 'GTL Text, Image and Video', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Accepts raw html with image url and youtube/vimeo video url', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {

			$content 	= ! empty( $instance[ 'content' ] ) ? html_entity_decode ($instance[ 'content' ] ): '';
			$image 		= ! empty( $instance[ 'image' ] ) ? esc_url ($instance[ 'image' ] ): '';
			$video_url 	= ! empty( $instance[ 'video_url' ] ) ? esc_url ($instance[ 'video_url' ] ): '';
			$height    	= ! empty( $instance[ 'height' ] ) ? $instance[ 'height' ] : '';
			$width     	= ! empty( $instance[ 'width' ] ) ? $instance[ 'width' ] : '';
			$cta_label 	= ! empty( $instance[ 'cta_label' ] ) ? $instance[ 'cta_label' ] : '';
			$cta_url 	= ! empty( $instance[ 'cta_url' ] ) ? esc_url($instance[ 'cta_url' ]) : '';

			?>

			<div class="">
				<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Text / Raw HTML:', 'gtl-multipurpose' ); ?></label> 
				<textarea rows="10" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" class="widefat" ><?php echo esc_attr($content); ?></textarea>
			</div>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image URL:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>"><?php esc_html_e( 'Video URL (Youtube/Vimeo):', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" type="text" value="<?php echo esc_attr( $video_url ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Video Width:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Video Height:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>"><?php esc_html_e( 'CTA Label:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_label' ) ); ?>" type="text" value="<?php echo esc_attr( $cta_label ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>"><?php esc_html_e( 'CTA URL:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_url' ) ); ?>" type="text" value="<?php echo esc_url( $cta_url ); ?>">
			</p>
			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance 				= $old_instance;
			$instance['content'] 	= ( isset( $new_instance['content'] ) ) ? sanitize_text_field( htmlentities($new_instance['content'] ) ): '';
			$instance['image'] 		= ( isset( $new_instance['image'] ) ) ? esc_url_raw( $new_instance['image'] ) : '';
			$instance['video'] 		= ( isset( $new_instance['video'] ) ) ? esc_url_raw( $new_instance['video'] ) : '';
			$instance['height'] 	= ( isset( $new_instance['height'] ) ) ? sanitize_text_field( $new_instance['height'] ) : '';
			$instance['width'] 		= ( isset( $new_instance['width'] ) ) ? sanitize_text_field( $new_instance['width'] )  : '';
			$instance['cta_label'] 	= ( isset( $new_instance['cta_label'] ) ) ? sanitize_text_field( $new_instance['cta_label'] ) : '';
			$instance['cta_url'] 	= ( isset( $new_instance['cta_url'] ) ) ? esc_url_raw( $new_instance['cta_url'] ) : '';
			return $instance;
		}


		function widget( $widget_args, $instance ) {

			$content 	= ( isset( $instance['content'] ) ) ? $instance['content'] : '';
			$cta_label 	= ( isset( $instance['cta_label'] ) ) ? $instance['cta_label'] : '';
			$cta_url 	= ( isset( $instance['cta_url'] ) ) ?  $instance['cta_url']  : '';
			$image 		= ( isset( $instance['image'] ) ) ?  $instance['image']  : '';
			$video_url 	= ( isset( $instance['video_url'] ) ) ?  $instance['video_url']  : '';
			$height 	= ( isset( $instance['height'] ) ) ? $instance['height'] : '';
			$width 		= ( isset( $instance['width'] ) ) ? $instance['width'] : '';

			if( isset($widget_args['before_widget'])){

				echo $widget_args['before_widget'];
			}
			?>

			<div class="pb-compo compo-text-image-video">
				<div class="compo-body compo-text-image-video-body">
					<div class="text-image two-col">

						<div class="cols text-part">

							<?php echo  html_entity_decode(  $content );?>

							<?php if( $cta_label): ?>

								<a href="<?php echo esc_url($cta_url);?>" class="custom-btn secondary-btn mg-tp-15"><?php echo esc_html($cta_label);?></a>
							
							<?php endif; ?>

						</div>

						<div class="cols image-part">

							<?php if( $image): ?>

								<img src="<?php echo esc_url($image);?>" >

							<?php endif; ?>

						</div>

					</div>

					<div class="video-part text-center">

						<?php echo wp_oembed_get( esc_url($video_url) , array('banner'=>null, 'width' => esc_attr($width), 'height'=>esc_attr($height)) );?>

					</div>

				</div>
			</div>

			<?php
			if( isset($widget_args['after_widget'])){

				echo $widget_args['after_widget'];
			}
		}
	}
endif;


if( ! function_exists( 'gtl_multipurpose_widget_text_image_video' ) ):

	/**
	* Register and load widget.
	*/
	function gtl_multipurpose_widget_text_image_video() {

		register_widget( 'GTL_Multipurpose_text_image_video' );

	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_text_image_video' );