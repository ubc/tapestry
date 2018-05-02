<?php
/**
 * Widget for services
 *
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_services' ) ):

	/**
	 * Services section
	 * Retrievs from services custom post type 
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_services extends WP_Widget{

		function __construct(){

			parent::__construct(
				'gtl-multipurpose-services', 
				esc_html__( 'GTL Services', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays services', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
				);
		}


		function form( $instance ) {

			$title 		= ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
			$subtitle 	= ! empty( $instance[ 'subtitle' ] ) ? $instance[ 'subtitle' ] : '';
			
			$no 		= ! empty( $instance[ 'no' ] ) ? $instance[ 'no' ] : '';

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>"><?php esc_html_e( 'No of services ( Enter -1 to display all ):', 'gtl-multipurpose' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no' ) ); ?>" type="number" value="<?php echo esc_attr( $no ); ?>">
			</p>

			<p class="gtl notice notice-error"> <?php  esc_html_e('Note: Disabled fields work only on theme pro version.' , 'gtl-multipurpose');?></p>

			<p>

				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category:', 'gtl-multipurpose' ); ?></label> 

				<select disabled class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">

					<option value=""><?php esc_html_e( 'Select All' , 'gtl-multipurpose' ); ?></option>

				</select>

			</p>

			<p>

				<label for="<?php echo esc_attr( $this->get_field_id( 'service_category' ) ); ?>"><?php esc_html_e( 'Service Category:', 'gtl-multipurpose' ); ?></label> 				

				<select disabled  class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'service_category' ) ); ?>">

					<option value=""><?php esc_html_e( 'Select All' , 'gtl-multipurpose' ); ?></option>

				</select>

			</p>

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>"><?php esc_html_e( 'No of services ( Enter -1 to display all ):', 'gtl-multipurpose' ); ?></label> 

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no' ) ); ?>" type="number" value="<?php echo esc_attr( $no ); ?>">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'column' ) ); ?>"><?php esc_html_e( 'Column ( 1 - 4 ):', 'gtl-multipurpose' ); ?></label> 

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'column' ) ); ?>" min="1" max="4" name="<?php echo esc_attr( $this->get_field_name( 'column' ) ); ?>" type="number" value="3">

		</p>



		<p>

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'featured' ) ); ?>" type="checkbox" value="1" > <?php echo esc_html_e( 'Only display featured services' , 'gtl-multipurpose' );?>

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>"><?php esc_html_e( 'Read more text:', 'gtl-multipurpose' ); ?></label> 

			<br/><em><?php esc_html_e( 'Only works if either \'single page is enabled\' or \'external/internal link\' is provided' , 'gtl-multipurpose');?></em>

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more' ) ); ?>" type="text" value="Read More">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_display' ) ); ?>"><?php esc_html_e( 'Content display ( Leave unchecked to display full content ):', 'gtl-multipurpose' ); ?></label> 

			<br/>

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_display' ) ); ?>" type="checkbox" value="1"  > <?php esc_html_e('Display excerpt' , 'gtl-multipurpose' );?>

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>"><?php esc_html_e( 'Icon / Featured Image', 'gtl-multipurpose' ); ?></label> 

			<br/>

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumbnail' ) ); ?>" type="checkbox" value="1"  > <?php esc_html_e('Ignore FontAwesome and use featured image' , 'gtl-multipurpose' );?>

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>"><?php esc_html_e( 'CTA Label:', 'gtl-multipurpose' ); ?></label> 

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_label' ) ); ?>" type="text" value="">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>"><?php esc_html_e( 'CTA URL:', 'gtl-multipurpose' ); ?></label> 

			<input disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_url' ) ); ?>" type="text" value="">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_btn' ) ); ?>"><?php esc_html_e( 'CTA Button Type:', 'gtl-multipurpose' ); ?></label> 

			<select disabled  class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_btn' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_btn' ) ); ?>">

				<option value="primary_btn" ><?php esc_html_e( 'Primary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="secondary_btn" ><?php esc_html_e( 'Secondary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="tertiary_btn"><?php esc_html_e( 'Tertiary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="quaternary_btn"><?php esc_html_e( 'Quaternary Button' , 'gtl-multipurpose' ); ?></option>

			</select>

		</p>



		<div>

			<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'gtl-multipurpose' ); ?></label> 

			<p><em><?php esc_html_e('Recomended: layout 1,2 are for icon and layout 3,4 are for thumbnail image','gtl-multipurpose');?></em></p>

			<div class="row">

				<div class="col col-6 va-m">

					<input disabled  type="radio" value="s1" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" <?php echo $layout=='s1'?'checked':'';?>>

					<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/service-1.png');?>">

				</div>

				<div class="col col-6 va-m">

					<input disabled type="radio" value="s2" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" <?php echo $layout=='s2'?'checked':'';?>>

					<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/service-2.png');?>">

				</div>

			</div>



			<div class="row mg-tp-35">

				<div class="col col-6 va-m">

					<input disabled  type="radio" value="s3" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" <?php echo $layout=='s3'?'checked':'';?>>

					<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/service-3.png');?>">

				</div>

				<div class="col col-6 va-m">

					<input disabled  type="radio" value="s4" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" <?php echo $layout=='s4'?'checked':'';?>>

					<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/service-4.png');?>">

				</div>

			</div>

		</div>
			<?php
		}


		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;
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
			<div class="pb-compo compo-service">

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

				<div class="compo-body compo-service-body">
					<?php 
					$args = array( 'post_type' => 'services' , 'posts_per_page' => $no );
					$loop = new WP_Query( $args );
					while( $loop->have_posts()): $loop->the_post();
					?>
						<div class="card-design">
							<?php if(has_post_thumbnail()):?>
								<div class="image-holder">
									<?php 
									the_post_thumbnail('gtl-multipurpose-img-330-200');
									?>
								</div> 
							<?php endif; ?>
							<h4><?php the_title();?></h4>
							<?php 
							the_content();
							?>
							<span class="underline"></span>
						</div>
				<?php endwhile; ?>
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


if( ! function_exists( 'gtl_multipurpose_widget_services' ) ) :

	/**
	 * Register and load widget.
	 */
	function gtl_multipurpose_widget_services() {

	register_widget( 'GTL_Multipurpose_services' );

	}
	
endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_services' );