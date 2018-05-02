<?php
/**
 * Customizer options
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since        1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
       
    // header area
    $wp_customize->add_panel( 'gtl_header_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header Setting', 'gtl-multipurpose'),
    ) );

    // header type
    $wp_customize->add_section(
        'gtl_header_type',
        array(
            'title'         => __('Header type', 'gtl-multipurpose'),
            'priority'      => 10,
            'panel'         => 'gtl_header_panel', 
        )
    );
    
   // menu style
    $wp_customize->add_section(
        'gtl_menu_type',
        array(
            'title'         => __('Header style', 'gtl-multipurpose'),
            'priority'      => 99,
            'panel'         => 'gtl_header_panel', 
        )
    );
    
    // sticky menu
    $wp_customize->add_setting(
        'menu_type',
        array(
            'default'           => 'sticky-header',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'gtl_sanitize_header_type',
        )
    );

    $wp_customize->add_control(
        'menu_type',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Header type', 'gtl-multipurpose'),
            'description' => __('Works with full width and boxed layout' , 'gtl-multipurpose'),
            'section' => 'gtl_menu_type',
            'choices' => array(
                'sticky-header'   => __('Sticky', 'gtl-multipurpose'),
                'static-header'   => __('Static', 'gtl-multipurpose'),
                'absolute-header' => __('Absolute', 'gtl-multipurpose'),
                'fixed-header'   => __('Fixed', 'gtl-multipurpose'),
            ),
        )
    );

    // menu display type
    $wp_customize->add_setting(
        'menu_display',
        array(
            'default'           => 'menu-inline',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'gtl_sanitize_menu_display',
        )
    );

    $wp_customize->add_control(
        'menu_display',
        array(
            'type'      => 'radio',
            'priority'  => 11,
            'label'     => __('Menu display', 'gtl-multipurpose'),
            'description'=>__('Works with full width and boxed layout' , 'gtl-multipurpose'),
            'section'   => 'gtl_menu_type',
            'choices'   => array(
                'menu-inline'     => __('Inline', 'gtl-multipurpose'),
                'menu-center'   => __('Centered', 'gtl-multipurpose'),
            ),
        )
    );


    /**
     * Sanitazation 
     */

    // menu type
    function gtl_sanitize_header_type( $input ) {
        $valid = array(
                    'sticky-header'     => __('Sticky', 'gtl-multipurpose'),
                    'static-header'     => __('Static', 'gtl-multipurpose'),
                    'absolute-header'   => __('Absolute', 'gtl-multipurpose'),
                    'fixed-header'      => __('Fixed', 'gtl-multipurpose'),
        );
        if ( array_key_exists( $input, $valid ) ) {
            return $input;
        } else {
            return '';
        }
    }

    // menu display type
    function gtl_sanitize_menu_display( $input ) {
        $valid = array(
            'menu-inline'     => __('Inline', 'gtl-multipurpose'),
                    'menu-center'   => __('Centered', 'gtl-multipurpose'),
        );
        if ( array_key_exists( $input, $valid ) ) {
            return $input;
        } else {
            return '';
        }
    }