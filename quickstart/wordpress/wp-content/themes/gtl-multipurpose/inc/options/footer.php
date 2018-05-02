<?php 
/**
 * Customizer options
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since        1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
    
    // footer area
    $wp_customize->add_section(
        'gtl_footer',
        array(
            'title'         => __('Footer Setting', 'gtl-multipurpose'),
            'priority'      => 18,
        )
    );

    // footer widget ares
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '4',
            'sanitize_callback' => 'gtl_sanitize_footer_widget',
        )
    );

    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'        => 'radio',
            'label'       => __('Footer widget areas', 'gtl-multipurpose'),
            'section'     => 'gtl_footer',
            'description' => __('No of widgets you want on footer. You can add widgets from Appearance->Widgets.', 'gtl-multipurpose'),
            'choices' => array(
                '1'     => __('One', 'gtl-multipurpose'),
                '2'     => __('Two', 'gtl-multipurpose'),
                '3'     => __('Three', 'gtl-multipurpose'),
                '4'     => __('Four', 'gtl-multipurpose'),
            ),
        )
    );

    // footer copyright text
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => __('Copyright Greenturtlelab. All rights reserved.','gtl-multipurpose'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'footer_copyright',
        array(
            'type'        => 'text',
            'label'       => __('Footer copyright', 'gtl-multipurpose'),
            'section'     => 'gtl_footer',
            'description' => __('Enter copyright text', 'gtl-multipurpose'),
        )
    );


/**
 * Sanitazation 
 */

    // footer widget areas
    function gtl_sanitize_footer_widget( $input ) {
        $valid = array(
            '1'     => __('One', 'gtl-multipurpose'),
            '2'     => __('Two', 'gtl-multipurpose'),
            '3'     => __('Three', 'gtl-multipurpose'),
            '4'     => __('Four', 'gtl-multipurpose')
        );
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }