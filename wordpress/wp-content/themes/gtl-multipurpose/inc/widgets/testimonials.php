<?php
/**
 * Widget for testimonials
 * @package    	 GTL_Multipurpose
 * @link         http://www.greenturtlelab.com/
 * since 	     1.0.0
 * Author:       Greenturtlelab
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_testimonials' ) ):

	/**
	 * Testimonials section
	 * Retrievs from testimonials custom post type 
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_testimonials extends WP_Widget{

		function __construct(){

			parent::__construct(
				'gtl-multipurpose-testimonials', 
				esc_html__( 'GTL Testimonials', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays testimonials carousel', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {

			$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
			$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
			$no 		= ! empty( $instance[ 'no' ] ) ? $instance[ 'no' ] : '';

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>"><?php esc_html_e( 'No of Team ( Enter -1 to display all ):', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no' ) ); ?>" type="number" value="<?php echo esc_attr( $no ); ?>">
			</p>
			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance 				= $old_instance;
			$instance['title'] 		= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
			$instance['subtitle'] 	= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
			$instance['no'] 		= ( isset( $new_instance['no'] ) ) ? sanitize_text_field( $new_instance['no'] ) : '';
			return $instance;
		}


		function widget( $widget_args, $instance ) {

			$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '<h2>';
	        $after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '</h2>';

			$title 		= ( isset( $instance['title'] ) ) ? $instance['title'] : '';
			$subtitle 	= ( isset( $instance['subtitle'] ) ) ? $instance['subtitle'] : '';	
			$no 		= ( isset( $instance['no'] ) ) ? $instance['no'] : '-1';

			if( isset($widget_args['before_widget'])){

				echo $widget_args['before_widget'];
			}
			?>
			<div class="pb-compo compo-testimonial">
				
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
					<div class="testimonial-slider owl-carousel owl-theme">
						<?php
						$args = array( 'post_type' => 'testimonials' , 'posts_per_page' => $no);
						$loop = new WP_Query( $args );
						while( $loop->have_posts()):$loop->the_post();
								$name =  get_post_meta( get_the_ID() , 'gtl-client-name' , true ) ;
						?>  
								<div class="item">
									<div class="people-img">
										<?php 
										if( has_post_thumbnail() ){
											the_post_thumbnail( 'thumbnail' );
										}else{
											echo '<img src="'.esc_url(get_template_directory_uri().'/assets/images/user-default.jpg').'" height="100" width="100" alt="">';
										}
										?>
									</div>
									<div class="people-word">
										<?php the_content();?>
										<div class="people-meta">
											<span class="name"><?php echo $name?$name:the_title();?></span>
										</div>
									</div>
								</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>

		<?php
		if( isset($widget_args['after_widget'])){

			echo $widget_args['after_widget'];
		}
		wp_reset_postdata();
	}
}
endif;


if( ! function_exists( 'gtl_multipurpose_widget_testimonials' ) ):

	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_testimonials() {

		register_widget( 'GTL_Multipurpose_testimonials' );

	}
	
endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_testimonials' );