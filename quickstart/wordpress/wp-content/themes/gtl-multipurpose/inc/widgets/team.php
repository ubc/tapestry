<?php
/**
 * Widget for team
 * @package    	GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since 	    1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! class_exists( 'GTL_Multipurpose_team' ) ): 

	/**
	 * Team section
	 * Retrievs from team custom post type 
	 * @since 1.0.0
	 */
	class GTL_Multipurpose_team extends WP_Widget{
		
		function __construct(){

			parent::__construct(
				'gtl-multipurpose-team', 
				esc_html__( 'GTL Team', 'gtl-multipurpose' ), 
				array( 'description' => esc_html__( 'Displays team carousel', 'gtl-multipurpose' ) , 'panels_groups' => array( 'themewidgets' ) )
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>"><?php esc_html_e( 'No of Team ( Enter -1 to display all ):', 'gtl-multipurpose' ); ?></label> 
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

			<label for="<?php echo esc_attr( $this->get_field_id( 'team_category' ) ); ?>"><?php esc_html_e( 'Team Category:', 'gtl-multipurpose' ); ?></label> 				

		    <select disabled class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'team_category' ) ); ?>">

		    <option value=""><?php esc_html_e( 'Select All' , 'gtl-multipurpose' ); ?></option>		    
		    </select>
			</p>
			<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'no' ) ); ?>"><?php esc_html_e( 'No of Team ( Enter -1 to display all ):', 'gtl-multipurpose' ); ?></label> 

			<input disabled  class="widefat" id="" name="" type="number" value="">

		</p>
		<p>
			<input disabled class="widefat" id=""  name="" type="checkbox" value="1" > <?php esc_html_e( 'Only display featured team' , 'gtl-multipurpose' );?>

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>"><?php esc_html_e( 'Read more text:', 'gtl-multipurpose' ); ?></label>			

			<input disabled class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more' ) ); ?>" type="text" value="<?php echo esc_attr( $read_more ); ?>">

		</p>

		

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_display' ) ); ?>"><?php esc_html_e( 'Content display ( Leave unchecked to display full content ):', 'gtl-multipurpose' ); ?></label> 

			<br/>

			<input disabled class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_display' ) ); ?>" type="checkbox" value="1"  > <?php esc_html_e('Display excerpt' , 'gtl-multipurpose' );?>

		</p>

		

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>"><?php esc_html_e( 'CTA Label:', 'gtl-multipurpose' ); ?></label> 

			<input disabled class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_label' ) ); ?>" type="text" value="">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>"><?php esc_html_e( 'CTA URL:', 'gtl-multipurpose' ); ?></label> 

			<input disabled class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_url' ) ); ?>" type="text" value="">

		</p>



		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'cta_btn' ) ); ?>"><?php esc_html_e( 'CTA Button Type:', 'gtl-multipurpose' ); ?></label> 

			<select disabled class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cta_btn' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cta_btn' ) ); ?>">

				<option value="primary_btn" <?php echo $cta_btn=='primary_btn'?'selected':'';?>><?php esc_html_e( 'Primary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="secondary_btn" <?php echo $cta_btn=='secondary_btn'?'selected':'';?>><?php esc_html_e( 'Secondary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="tertiary_btn" <?php echo $cta_btn=='tertiary_btn'?'selected':'';?>><?php esc_html_e( 'Tertiary Button' , 'gtl-multipurpose' ); ?></option>

				<option value="quaternary_btn" <?php echo $cta_btn=='quaternary_btn'?'selected':'';?>><?php esc_html_e( 'Quaternary Button' , 'gtl-multipurpose' ); ?></option>

			</select>

	   </p>



         <div>

		<div class="row">

		<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'gtl-multipurpose' ); ?></label> 

			<div class="col col-6 va-m">

				<input disabled type="radio" value="t1" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" >

				<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/team-1.png');?>">

			</div>

			<div class="col col-6 va-m">

				<input disabled type="radio" value="t2" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" >

				<img src="<?php echo esc_url(get_template_directory_uri().'/assets/admin/images/team-2.png');?>">

			</div>

		</div>

		<?php
		}


		function update( $new_instance, $old_instance ){

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
			<div class="pb-compo compo-team">

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
					<div class="teamCarousel owl-carousel owl-theme">

						<?php 
						$args  = array( 'post_type' => 'team' , 'posts_per_page' => $no );
						$loop = new WP_Query( $args );
						while( $loop->have_posts()):$loop->the_post();
						?> 
							<div class="item">
								<div class="person-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'gtl-multipurpose-img-585-500')?>')"></div>
								<div class="name">
									<?php the_title();?>
								</div>
								<div class="position"><?php echo get_post_meta( get_the_ID(), 'gtl-team-designation', true ) ;?></div>
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


if( ! function_exists( 'gtl_multipurpose_widget_team' ) ):

	/**
	* Register and load widget.
	*/
	function gtl_multipurpose_widget_team() {

		register_widget( 'GTL_Multipurpose_team' );

	}

endif;
add_action( 'widgets_init', 'gtl_multipurpose_widget_team' );