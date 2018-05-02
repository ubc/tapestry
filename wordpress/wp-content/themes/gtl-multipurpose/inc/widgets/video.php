<?php
/**
 * Widget for video iframe
 * @package    	 GTL_Multipurpose
 * @link         http://www.greenturtlelab.com/
 * since 	     1.0.0
 * Author:       Greenturtlelab
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_video_iframe' ) ):

/**
 * Video iframe section
 * @since 1.0.0
 */

class GTL_Multipurpose_video_iframe extends WP_Widget
{
	function __construct(){

		parent::__construct(
			'gtl-multipurpose-video-iframe', 
			esc_html__( 'GTL Video Iframe', 'gtl-multipurpose' ), 
			array( 'description' => esc_html__( 'Displays video iframe from youtube/vimeo', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
			);
	}


	function form( $instance ) {

		$video_url = ! empty( $instance[ 'video_url' ] ) ? esc_url( $instance[ 'video_url' ] ) : '';
		$height    = ! empty( $instance[ 'height' ] ) ? $instance[ 'height' ] : '300';
		$width     = ! empty( $instance[ 'width' ] ) ? $instance[ 'width' ] : '450';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>"><?php esc_html_e( 'Video URL (Youtube/Vimeo):', 'gtl-multipurpose' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" type="text" value="<?php echo esc_attr( $video_url ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width:', 'gtl-multipurpose' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height:', 'gtl-multipurpose' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>">
		</p>
		<?php
	}


	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['video_url'] = ( isset( $new_instance['video_url'] ) ) ? esc_url_raw( $new_instance['video_url'] ) : '';
		$instance['height'] = ( isset( $new_instance['height'] ) ) ? sanitize_text_field( $new_instance['height'] ) : '';
		$instance['width'] = ( isset( $new_instance['width'] ) ) ? sanitize_text_field( $new_instance['width'] )  : '';
		return $instance;
	}


	function widget( $widget_args, $instance ){

		$video_url 	= ( isset( $instance['video_url'] ) ) ? $instance['video_url'] : '';
		$height 	= ( isset( $instance['height'] ) ) ? $instance['height'] : '300';
		$width 		= ( isset( $instance['width'] ) ) ? $instance['width'] : '450';

		if( isset($widget_args['before_widget'])){

			echo $widget_args['before_widget'];
		}
		?>
		<div class="pb-compo compo-video">

			<?php echo wp_oembed_get( esc_url($video_url) , array('banner'=>null, 'width' => esc_attr($width), 'height'=>esc_attr($height) ) );?>

		</div>

		<?php
		if( isset($widget_args['after_widget'])){

			echo $widget_args['after_widget'];
		}
	}
}
endif;


if( ! function_exists( 'gtl_multipurpose_widget_video_iframe' ) ):

	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_video_iframe() {

		register_widget( 'GTL_Multipurpose_video_iframe' );

	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_video_iframe' );