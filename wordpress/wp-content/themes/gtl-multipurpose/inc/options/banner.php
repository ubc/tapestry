<?php 
/**
 * Customizer options
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since        1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
  
  /**
   * Banner type settings 
   */   

    // banner area
        $wp_customize->add_panel( 'gtl_banner_panel', array(
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Banner Setting', 'gtl-multipurpose'),
        ) );

    // banner type
    $wp_customize->add_section(
        'gtl_banner_panel',
        array(
            'title'         => __('Banner type', 'gtl-multipurpose'),
            'priority'      => 10,
            'panel'         => 'gtl_banner_panel', 
        )
    );

    // front page banner type
    $wp_customize->add_setting(
        'front_banner_type',
        array(
            'default'           => 'slider-banner',
            'sanitize_callback' => 'gtl_sanitize_banner_type',
        )
    );

    $wp_customize->add_control(
        'front_banner_type',
        array(
            'type'        => 'radio',
            'label'       => __('Front page banner type', 'gtl-multipurpose'),
            'section'     => 'gtl_banner_panel',
            'description' => __('Select the banner type for your front page', 'gtl-multipurpose'),
            'choices' => array(
                'slider-banner'    => __('Full screen slider', 'gtl-multipurpose'),
                'image-banner'     => __('Image banner', 'gtl-multipurpose'),
                'video-banner'=> __('Video banner', 'gtl-multipurpose'),
                'no-banner'   => __('No banner (only menu)', 'gtl-multipurpose')
            ),
        )
    );

    // inner page banner type
    $wp_customize->add_setting(
        'site_banner_type',
        array(
            'default'           => 'image-banner',
            'sanitize_callback' => 'gtl_sanitize_banner_type',
        )
    );

    $wp_customize->add_control(
        'site_banner_type',
        array(
            'type'        => 'radio',
            'label'       => __('Inner page banner type', 'gtl-multipurpose'),
            'section'     => 'gtl_banner_panel',
            'description' => __('Select the banner type for all inner pages except the front page', 'gtl-multipurpose'),
            'choices' => array(
                'slider-banner'    => __('Full screen slider', 'gtl-multipurpose'),
                'image-banner'     => __('Image banner', 'gtl-multipurpose'),
                'video-banner'=> __('Video banner', 'gtl-multipurpose'),
                'no-banner'   => __('No banner (only menu)', 'gtl-multipurpose')
            ),
        )
    );    


/**
 *Slider settings 
 */

 // slider area
    $wp_customize->add_section(
        'gtl_slider',
        array(
            'title'         => __('Banner slides', 'gtl-multipurpose'),
            'description'   => __('You can add up to 3 images in the slider. You can also add a Call to action button for each slides. If you don\'t need CTA button simply leave label empty.', 'gtl-multipurpose'),
            'priority'      => 11,
            'panel'         => 'gtl_banner_panel',
        )
    );



    // slider Speed
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default' => __('3000','gtl-multipurpose'),
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        'slider_speed',
        array(
            'label' => __( 'Slider speed', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'number',
            'description'   => __('Slider speed in miliseconds. Use 0 to disable', 'gtl-multipurpose'),       
            'priority' => 7
        )
    );

    // animation speed
    $wp_customize->add_setting(
        'animation_speed',
        array(
            'default' => __('1000','gtl-multipurpose'),
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        'animation_speed',
        array(
            'label' => __( 'Animation speed', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'number',
            'description'   => __('Animation speed in miliseconds.', 'gtl-multipurpose'),       
            'priority' => 7
        )
    );
    

    /**
     * slider Images 
     */

  // slide 1
    $wp_customize->add_setting('gtl_slider_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',            
        )
    );

    $wp_customize->add_control( new GTL_Info( $wp_customize, 's1', array(
        'label' => __('First slide', 'gtl-multipurpose'),
        'section' => 'gtl_slider',
        'settings' => 'gtl_slider_options[info]',
        'priority' => 10
        ) )
    ); 

    $wp_customize->add_setting(
        'slider_image_1',
        array(
            'default' => get_template_directory_uri().'/assets/images/slider1.jpg',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_1',
            array(
               'label'          => __( 'Slider image 1', 'gtl-multipurpose' ),
               'type'           => 'image',
               'section'        => 'gtl_slider',
               'settings'       => 'slider_image_1',
               'priority'       => 11,
            )
        )
    );

   
    $wp_customize->add_setting(
        'slider_title_1',
        array(
            'default' => __('Welcome to GTL Multipurpose','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_title_1',
        array(
            'label' => __( 'First slide title', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 12
        )
    );
    
    $wp_customize->add_setting(
        'slider_subtitle_1',
        array(
            'default' => __('Ultimate WordPress theme','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_subtitle_1',
        array(
            'label' => __( 'First slide subtitle', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 13
        )
    );  

    $wp_customize->add_setting(
        'slider_cta_1_label',
        array(
            'default' => __('Click here','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_cta_1_label',
        array(
            'label' => __( 'First slide CTA label', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 13
        )
    ); 

    $wp_customize->add_setting(
        'slider_cta_1_url',
        array(
            'default' => __('#about','gtl-multipurpose'),
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'slider_cta_1_url',
        array(
            'label' => __( 'First slide CTA url', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 13
        )
    ); 

   
    // slide 2
    $wp_customize->add_setting('gtl_slider_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',            
        )
    );

    $wp_customize->add_control( new GTL_Info( $wp_customize, 's2', array(
        'label' => __('Second slide', 'gtl-multipurpose'),
        'section' => 'gtl_slider',
        'settings' => 'gtl_slider_options[info]',
        'priority' => 14
        ) )
    );  

    $wp_customize->add_setting(
        'slider_image_2',
        array(
            'default' => get_template_directory_uri().'/assets/images/slider2.jpg',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_2',
            array(
               'label'          => __( 'Slider image 2', 'gtl-multipurpose' ),
               'type'           => 'image',
               'section'        => 'gtl_slider',
               'settings'       => 'slider_image_2',
               'priority'       => 15,
            )
        )
    );
   
    $wp_customize->add_setting(
        'slider_title_2',
        array(
            'default' => __('Ready to explore great theme?','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_title_2',
        array(
            'label' => __( 'Second slide title', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 16
        )
    );
    
    $wp_customize->add_setting(
        'slider_subtitle_2',
        array(
            'default' => __('Feel free to go around','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_subtitle_2',
        array(
            'label' => __( 'Second slide subtitle', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 17
        )
    );   

   
    $wp_customize->add_setting(
        'slider_cta_2_label',
        array(
            'default' => __('Click here','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_cta_2_label',
        array(
            'label' => __( 'Second slide CTA Label', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 17
        )
    ); 

    $wp_customize->add_setting(
        'slider_cta_2_url',
        array(
            'default' => __('#about','gtl-multipurpose'),
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'slider_cta_2_url',
        array(
            'label' => __( 'Second slide CTA URL', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 17
        )
    ); 

   // slide 3
    $wp_customize->add_setting('gtl_slider_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',            
        )
    );

    $wp_customize->add_control( new GTL_Info( $wp_customize, 's3', array(
        'label' => __('Third slide', 'gtl-multipurpose'),
        'section' => 'gtl_slider',
        'settings' => 'gtl_slider_options[info]',
        'priority' => 18
        ) )
    ); 

    $wp_customize->add_setting(
        'slider_image_3',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_3',
            array(
               'label'          => __( 'Slider image 3', 'gtl-multipurpose' ),
               'type'           => 'image',
               'section'        => 'gtl_slider',
               'settings'       => 'slider_image_3',
               'priority'       => 19,
            )
        )
    );

    $wp_customize->add_setting(
        'slider_title_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_title_3',
        array(
            'label' => __( 'Third slide title', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 20
        )
    );
    
    $wp_customize->add_setting(
        'slider_subtitle_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_subtitle_3',
        array(
            'label' => __( 'Third slide subtitle', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 21
        )
    );            

    $wp_customize->add_setting(
        'slider_cta_3_label',
        array(
            'default' => __('Click here','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'slider_cta_3_label',
        array(
            'label' => __( 'Third slide CTA label', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 22
        )
    ); 

    $wp_customize->add_setting(
        'slider_cta_3_url',
        array(
            'default' => __('#about','gtl-multipurpose'),
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'slider_cta_3_url',
        array(
            'label' => __( 'Third slide CTA URL', 'gtl-multipurpose' ),
            'section' => 'gtl_slider',
            'type' => 'text',
            'priority' => 23
        )
    ); 



/**
 * Header Setting 
 */

    // inner page image banner height
    $wp_customize->add_setting(
        'header_height',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '300',
        )       
    );

    $wp_customize->add_control( 'header_height', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'header_image',
        'label'       => __('Banner image height [default: 300px]', 'gtl-multipurpose'),
        'input_attrs' => array(
            'min'   => 250,
            'max'   => 600,
            'step'  => 5,
        ),
    ) );

    // banner overlay
    $wp_customize->add_setting(
        'hide_overlay',
        array(
            'sanitize_callback' => 'gtl_sanitize_checkbox',
        )       
    );

    $wp_customize->add_control(
        'hide_overlay',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable the overlay?', 'gtl-multipurpose'),
            'section'   => 'header_image',
            'priority'  => 12,
        )
    );   




/**
 *sanitization 
 */
    // banner type
    function gtl_sanitize_banner_type( $input ) {

        $valid = array(
                    'slider-banner'    => __('Full screen slider', 'gtl-multipurpose'),
                    'image-banner'     => __('Image banner', 'gtl-multipurpose'),
                    'video-banner'=> __('Video banner', 'gtl-multipurpose'),
                    'no-banner'   => __('No banner (only menu)', 'gtl-multipurpose')
        );
     
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }



    // checkboxes
    function gtl_sanitize_checkbox( $input ) {
        if ( $input == 1 ) {

            return 1;

        } else {

            return '';
        }
    }



    // menu type
    function gtl_sanitize_menu_type( $input ) {

        $valid = array(
                    'sticky-header'    => __('Sticky', 'gtl-multipurpose'),
                    'image-banner'     => __('Image banner', 'gtl-multipurpose'),
                    'absolute-header'  => __('Absolute', 'gtl-multipurpose'),
                    'fixed-header'     => __('Fixed', 'gtl-multipurpose'),
        );
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }