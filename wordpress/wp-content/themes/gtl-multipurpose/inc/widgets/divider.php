<?php
/**
 * Widget for divider section
 * @package    	GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_divider' ) ):

	/**
	 * Divider section
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_divider extends WP_Widget{

		function __construct(){

			parent::__construct(
				'gtl-multipurpose-divider', 
				esc_html__( 'GTL Divider', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays section divider with title, subtitle and a cta button', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {

			$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
			$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
			$cta_label 	= ! empty( $instance[ 'cta_label' ] ) ? $instance[ 'cta_label' ] : '';
			$cta_url 	= ! empty( $instance[ 'cta_url' ] ) ? esc_url($instance[ 'cta_url' ]) : '';
			$inline 	= ! empty( $instance[ 'inline' ] ) ? $instance[ 'inline' ] : '';

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>"><?php esc_html_e( 'CTA Label:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_label' ) ); ?>" type="text" value="<?php echo esc_attr( $cta_label ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>"><?php esc_html_e( 'CTA URL:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_url' ) ); ?>" type="text" value="<?php echo esc_url( $cta_url ); ?>">
			</p>
			<p>
				<input type="checkbox" <?php echo $inline?'checked':'';?> value="1" name="<?php echo esc_attr( $this->get_field_name( 'inline' ) ); ?>" class="widefat"> <span><?php esc_html_e('Inline button with title ( Subtitle will be ignored )','gtl-multipurpose')?></span>
			</p>

			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance 				= $old_instance;
			$instance['title'] 		= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['subtitle'] 	= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
			$instance['cta_label'] 	= ( isset( $new_instance['cta_label'] ) ) ? sanitize_text_field( $new_instance['cta_label'] ) : '';
			$instance['cta_url'] 	= ( isset( $new_instance['cta_url'] ) ) ? esc_url_raw( $new_instance['cta_url'] ) : '';
			$instance['inline'] 	= ( isset( $new_instance['inline'] ) ) ? sanitize_text_field( $new_instance['inline'] ) : '';
			return $instance;
		}


		function widget( $widget_args, $instance ) {

			$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '<h2>';
	        $after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '</h2>';

			$title 		= ( isset( $instance['title'] ) ) ? $instance['title'] : '';
			$subtitle 	= ( isset( $instance['subtitle'] ) ) ? $instance['subtitle'] : '';
			$inline 	= ( isset( $instance['inline'] ) ) ? $instance['inline'] : '';
			$cta_label 	= ( isset( $instance['cta_label'] ) ) ? $instance['cta_label'] : '';
			$cta_url 	= ( isset( $instance['cta_url'] ) ) ?  $instance['cta_url']  : '';

			if( isset($widget_args['before_widget'])){

				echo $widget_args['before_widget'];
			}
			?>
			<div class="pb-compo compo-cta">
				<div class="compo-body compo-divider-body <?php if($inline){ echo 'inline-btn';}?>">
					
					<?php if( $inline){?>

						<div class="flex-box">

							<?php if( $title ):?>

								<?php 
									 if ( ! empty( $instance['title'] ) ) {
			
						                    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

						                    echo $before_title . esc_html($title) . $after_title;
						              	}
								?>
								<span><a href="<?php echo esc_url($cta_url);?>" class="custom-btn secondary-btn"><?php echo esc_html($cta_label); ?></a></span>
							
							<?php endif;?>

						</div>

					<?php }else{?>

						<?php if( $title ):?>

								<h2><?php echo $widget_args['before_title'] . esc_html( $title ) . $widget_args['after_title']; ?></h2>

							<?php endif;?>

							<?php if( $subtitle ):?>

								<p><?php echo esc_html($subtitle); ?></p>

							<?php endif;?>

							<?php if( $cta_label): ?>

								<a href="<?php echo esc_url($cta_url); ?>" class="custom-btn secondary-btn"><?php echo esc_html($cta_label); ?></a>
						
						<?php endif; ?>

					<?php } ?>
					
				</div>
			</div>
			<?php
			if( isset($widget_args['after_widget'])){

				echo $widget_args['after_widget'];
			}
		}
	}
endif;


if( ! function_exists( 'gtl_multipurpose_widget_divider' ) ):

	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_divider(){
		
		register_widget( 'GTL_Multipurpose_divider' );
	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_divider' );
