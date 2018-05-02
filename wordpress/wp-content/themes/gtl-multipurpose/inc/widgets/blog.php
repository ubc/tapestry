<?php
/**
 * Widget for recent post block
 * @package    	GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_blog' ) ):

	/*
	 * Blog section
	 * Retrievs from post 
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_blog extends WP_Widget{

			function __construct(){

				parent::__construct(
					'gtl-multipurpose-blog', 
					esc_html__( 'GTL Blog', 'gtl-multipurpose' ), 
					array( 'description' => esc_html__( 'Displays home page blog block', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
					);
			}


			function form( $instance ) {

				$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
				$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'gtl-multipurpose' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
				</p>
				<?php
			}


			function update( $new_instance, $old_instance ) {

				$instance 				= $old_instance;
				$instance['title'] 		= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
				$instance['subtitle'] 	= ( isset( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['subtitle'] ) : '';
				return $instance;

			}


			function widget( $widget_args, $instance ) {

				$before_title = isset( $args['before_title'] ) ? $args['before_title'] : '<h2>';
	            $after_title  = isset( $args['after_title'] ) ? $args['after_title'] : '</h2>';

				$title 	   = isset( $instance['title'] ) ? $instance['title'] : '';
				$subtitle  = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';	

				if( isset($widget_args['before_widget'])){

					echo $widget_args['before_widget'];
				}

				?>
				<div class="pb-compo compo-home-blog">
					
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
						$args = array('post_type' => 'post' , 'posts_per_page' => 5 );
						$loop = new WP_Query( $args );
						while( $loop->have_posts()):$loop->the_post();
						?>
								<div class="article-wrap">

									<?php if(has_post_thumbnail()):?>

										<div class="article-img-wrap">
											<?php the_post_thumbnail( 'gtl-multipurpose-img-585-500' );?>
										</div>

									<?php endif;?>

									<?php gtl_multipurpose_posted_on(); ?>

									<a href="<?php the_permalink();?>" class="article-title-link">
										<?php the_title();?>
									</a>

									<?php gtl_multipurpose_author();?>

								</div>
								
					<?php endwhile;?>
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


if( ! function_exists( 'gtl_multipurpose_widget_blog' ) ):

	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_blog() {

		register_widget( 'GTL_Multipurpose_blog' );
	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_blog' );