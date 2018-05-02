<?php
/**
 * Widget for counter section
 * @package    	GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_counter' ) ):

	/**
	* Counter section
	* @since 1.0.0
	*/
	class GTL_Multipurpose_counter extends WP_Widget{

		function __construct(){

			parent::__construct(
				'gtl-multipurpose-counter', 
				esc_html__( 'GTL Counter', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays counter with title, icon and numbere', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {
			$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
			$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
			$counter 	= ! empty( $instance[ 'counter' ] ) ? $instance[ 'counter' ] : array();

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
			</p>

			<div class="counter-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[0][label]' ) ); ?>" type="text" value="<?php echo isset($counter[0]['label'])?esc_attr($counter[0]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[0][icon]' ) ); ?>" type="text" value="<?php echo isset($counter[0]['icon'])?esc_attr($counter[0]['icon']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>"><?php esc_html_e( 'Number:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[0][number]' ) ); ?>" type="number" value="<?php echo isset($counter[0]['number'])? esc_attr($counter[0]['number']):'';?>">
				</p>
			</div>
			<div class="counter-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[1][label]' ) ); ?>" type="text" value="<?php echo isset($counter[1]['label'])?esc_attr($counter[1]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[1][icon]' ) ); ?>" type="text" value="<?php echo isset($counter[1]['icon'])?esc_attr($counter[1]['icon']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>"><?php esc_html_e( 'Number:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[1][number]' ) ); ?>" type="number" value="<?php echo isset($counter[1]['number'])?esc_attr($counter[1]['number']):'';?>">
				</p>
			</div>
			<div class="counter-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[2][label]' ) ); ?>" type="text" value="<?php echo isset($counter[2]['label'])?esc_attr($counter[2]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[2][icon]' ) ); ?>" type="text" value="<?php echo isset($counter[2]['icon'])?esc_attr($counter[2]['icon']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>"><?php esc_html_e( 'Number:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[2][number]' ) ); ?>" type="number" value="<?php echo isset($counter[2]['number'])?esc_attr($counter[2]['number']):'';?>">
				</p>
			</div>
			<div class="counter-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[3][label]' ) ); ?>" type="text" value="<?php echo isset($counter[3]['label'])?esc_attr($counter[3]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[3][icon]' ) ); ?>" type="text" value="<?php echo isset($counter[3]['icon'])?esc_attr($counter[3]['icon']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>"><?php esc_html_e( 'Number:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'counter_number_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'counter[3][number]' ) ); ?>" type="number" value="<?php echo isset($counter[3]['number'])?esc_attr($counter[3]['number']):'';?>">
				</p>
			</div>



			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance 				= $old_instance;
			$instance['title'] 		= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['subtitle'] 	= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
			$instance['counter'] 	= ( isset( $new_instance['counter'] ) ) ? $this->sanitize_array( $new_instance['counter'] ) : '';
			return $instance;
		}


		function widget( $widget_args, $instance ) {

			$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '<h2>';
	        $after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '</h2>';

			$title 		=  ( isset( $instance['title'] ) ) ? $instance['title'] : '';
			$subtitle 	=  ( isset( $instance['subtitle'] ) ) ? $instance['subtitle'] : '';
			$counter 	=  ( isset( $instance['counter'] ) ) ? $instance['counter'] : '';

			if( isset($widget_args['before_widget'])){

				echo $widget_args['before_widget'];
			}

			?>
			
			<div class="pb-compo compo-counter">

				<?php if( $title || $subtitle ): ?>

					<div class="compo-header">

						<?php 
							 if ( ! empty( $instance['title'] ) ) {
	
				                    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

				                    echo $before_title . esc_html($title) . $after_title;
				              	}
						?>

						<?php if( $subtitle ):?>

							<p><?php echo esc_html($subtitle); ?></p>

						<?php endif;?>

					</div>
					
				<?php endif; ?>

				<div class="compo-body">
					<?php 
					if( is_array( $counter ) ):
						foreach( $counter as $count):
							if( empty( $count['label'] ) ): continue; endif;
						?>

						<div class="milestone-counter">
							<i class="<?php echo esc_attr($count['icon']); ?>"></i>
							<span class="stat-count highlight"><?php echo esc_html($count['number']); ?></span>
							<div class="milestone-details"><?php echo esc_html($count['label']); ?></div>
						</div>

						<?php 
						endforeach;
						endif;
						?>
					</div>


				</div>


				<?php
				if( isset($widget_args['after_widget'])){
					echo $widget_args['after_widget'];
				}
			}

			
	private function sanitize_array( $array ){

		if( is_array( $array ) ){

			for( $i = 0; $i < count( $array ); $i++ ):

				if( isset( $array[$i]['label'] ) )
					$array[$i]['label'] = sanitize_text_field( $array[$i]['label'] );

				if( isset( $array[$i]['icon'] ) )
					$array[$i]['icon'] = sanitize_text_field( $array[$i]['icon'] );

				if( isset( $array[$i]['number'] ) )
					$array[$i]['icon'] = sanitize_text_field( $array[$i]['number'] );

			endfor;
		}
		
		return $array ;

	}

	}

endif;


if( ! function_exists( 'gtl_multipurpose_widget_counter' ) ) :
	
	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_counter() {
		
		register_widget( 'GTL_Multipurpose_counter' );

	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_counter' );