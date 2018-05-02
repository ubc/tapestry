<?php
/**
 * Widget for list section
 *
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	   1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_list' ) ) :
	
	/**
	 * List section
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_list extends WP_Widget{

		function __construct(){
			parent::__construct(
				'gtl-multipurpose-list', 
				esc_html__( 'GTL List', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays list itemes with FontAwesome icon', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {

			$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
			$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
			$list 		= ! empty( $instance[ 'list' ] ) ? $instance[ 'list' ] : array();

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
			</p>

			<div class="list-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_label_1' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_label_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[0][label]' ) ); ?>" type="text" value="<?php echo isset($list[0]['label'])?esc_attr($list[0]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_1' ) ); ?>"><?php esc_html_e( 'Sub Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[0][sublabel]' ) ); ?>" type="text" value="<?php echo isset($list[0]['sublabel'])?esc_attr($list[0]['sublabel']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_icon_1' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[0][icon]' ) ); ?>" type="text" value="<?php echo isset($list[0]['icon'])?esc_attr($list[0]['icon']):'';?>">
				</p>

			</div>
			<div class="list-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_label_2' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_label_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[1][label]' ) ); ?>" type="text" value="<?php echo isset($list[1]['label'])?esc_attr($list[1]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_2' ) ); ?>"><?php esc_html_e( 'Sub Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[1][sublabel]' ) ); ?>" type="text" value="<?php echo isset($list[1]['sublabel'])?esc_attr($list[1]['sublabel']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_icon_2' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_icon_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[1][icon]' ) ); ?>" type="text" value="<?php echo isset($list[1]['icon'])?esc_attr($list[1]['icon']):'';?>">
				</p>

			</div>
			<div class="list-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_label_3' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_label_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[2][label]' ) ); ?>" type="text" value="<?php echo isset($list[2]['label'])?esc_attr($list[2]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_3' ) ); ?>"><?php esc_html_e( 'Sub Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[2][sublabel]' ) ); ?>" type="text" value="<?php echo isset($list[2]['sublabel'])?esc_attr($list[2]['sublabel']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_icon_3' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_icon_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[2][icon]' ) ); ?>" type="text" value="<?php echo isset($list[2]['icon'])?esc_attr($list[2]['icon']):'';?>">
				</p>

			</div>
			<div class="list-wrap">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_label_4' ) ); ?>"><?php esc_html_e( 'Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_label_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[3][label]' ) ); ?>" type="text" value="<?php echo isset($list[3]['label'])?esc_attr($list[3]['label']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_label_4' ) ); ?>"><?php esc_html_e( 'Sub Label:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_sublabel_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[3][sublabel]' ) ); ?>" type="text" value="<?php echo isset($list[3]['sublabel'])?esc_attr($list[3]['sublabel']):'';?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'list_icon_4' ) ); ?>"><?php  esc_html_e( 'FontAwesome Icon: e.g. fa fa-ambulance', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'list_icon_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list[3][icon]' ) ); ?>" type="text" value="<?php echo isset($list[3]['icon'])?esc_attr($list[3]['icon']):'';?>">
				</p>
			</div>
			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance 				= $old_instance;
			$instance['title'] 		= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['subtitle'] 	= ( isset( $new_instance['subtitle'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
			$instance['list'] 		= ( isset( $new_instance['list'] ) ) ? $this->sanitize_array( $new_instance['list'] ) : '';
			return $instance;
		}


		function widget( $widget_args, $instance ) {

			$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '<h2>';
	        $after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '</h2>';

			$title 		= ( isset( $instance['title'] ) ) ? $instance['title'] : '';
			$subtitle 	= ( isset( $instance['subtitle'] ) ) ? $instance['subtitle'] : '';
			$list 		= ( isset( $instance['list'] ) ) ? $instance['list'] : '';

			if( isset($widget_args['before_widget'])){

				echo $widget_args['before_widget'];
			}

			?>

			<div class="pb-compo compo-list-with-icon">

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
					<ul>
						<?php 
						if( is_array( $list ) ):
							foreach( $list as $li):
								if( empty(  $li['label'] ) ): continue; endif;

								echo '<li>';
								echo '<i class="'.esc_attr( $li['icon'] ).'"></i>';
								echo '<div><h4>'. esc_html( $li['label'] ).'</h4>';
								if( $li['sublabel'] ){
									echo '<p>'.esc_html( $li['sublabel'] ).'</p>';
								}
								echo '</div></li>'; 
							endforeach;
						endif;
							?>
						</ul>
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

				if( isset( $array[$i]['sublabel'] ) )
					$array[$i]['sublabel'] = sanitize_text_field( $array[$i]['sublabel'] );

				if( isset( $array[$i]['icon'] ) )
					$array[$i]['icon'] = sanitize_text_field( $array[$i]['icon'] );

			endfor;
		}
		
		return $array ;

	}

	}
endif;


if( ! function_exists( 'gtl_multipurpose_widget_list' ) ) :
	
	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_list() {

		register_widget( 'GTL_Multipurpose_list' );

	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_list' );