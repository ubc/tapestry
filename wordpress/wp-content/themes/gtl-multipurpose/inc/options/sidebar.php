<?php 
/**
 * Customizer options
 * @package     GTL_Multipurpose
 * @link        http://www.greenturtlelab.com/
 * since        1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */ 

// sidebar area
 $wp_customize->add_panel( 'gtl_sidebar_panel', array(
        'priority'       => 11,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Sidebar Setting', 'gtl-multipurpose'),
    ) );



    // post sidebar position
    $wp_customize->add_section(
        'gtl_sidebar_panel',
        array(
            'title'         => __('Post sidebar', 'gtl-multipurpose'),
            'priority'      => 10,
            'panel'         => 'gtl_sidebar_panel', 
        )
    );

    // post archive sidebar position
    $wp_customize->add_setting(
        'post_arhive_sidebar_pos',
        array(
            'default'           => 'right',
            'sanitize_callback' => 'gtl_sanitize_sidebar',
        )
    );

    $wp_customize->add_control(
        'post_arhive_sidebar_pos',
        array(
            'type'        => 'radio',
            'label'       => __('Post archive sidebar position', 'gtl-multipurpose'),
            'section'     => 'gtl_sidebar_panel',
            'description' => __('Select the sidebar position for post index/archive templates', 'gtl-multipurpose'),
            'choices' => array(
                'none'    => __('No sidebar', 'gtl-multipurpose'),
                'right'     => __('Right sidebar', 'gtl-multipurpose'),
                'left'=> __('Left sidebar', 'gtl-multipurpose')
            ),
        )
    );

    // post single sidebar posistion
    $wp_customize->add_setting(
        'post_single_sidebar_type',
        array(
            'default'           => 'right',
            'sanitize_callback' => 'gtl_sanitize_sidebar',
        )
    );

    $wp_customize->add_control(
        'post_single_sidebar_type',
        array(
            'type'        => 'radio',
            'label'       => __('Post single sidebar position', 'gtl-multipurpose'),
            'section'     => 'gtl_sidebar_panel',
            'description' => __('Select the sidebar position for post single templates', 'gtl-multipurpose'),
            'choices' => array(
                'none'    => __('No sidebar', 'gtl-multipurpose'),
                'right'     => __('Right sidebar', 'gtl-multipurpose'),
                'left'=> __('Left sidebar', 'gtl-multipurpose')
            ),
        )
    );

    // post sidebar id
    $wp_customize->add_setting(
        'post_sidebar_id',
        array(
            'default'           => 'sidebar-1',
            'sanitize_callback' => 'gtl_sanitize_sidebar_id',
        )
    );

    $wp_customize->add_control(
        'post_sidebar_id',
        array(
            'type'        => 'radio',
            'label'       => __('Select sidebar', 'gtl-multipurpose'),
            'section'     => 'gtl_sidebar_panel',
            'description' => __('Select sidebar for post archive/single pages. Will ignored if No sidebar is checked above', 'gtl-multipurpose'),
            'choices' => gtl_multipurpose_sidebars(),
        )
    );


    // page sidebar position
    $wp_customize->add_section(
        'gtl_page_sidebar_panel',
        array(
            'title'         => __('Page sidebar', 'gtl-multipurpose'),
            'priority'      => 10,
            'panel'         => 'gtl_sidebar_panel', 
        )
    );

    $wp_customize->add_setting(
        'page_sidebar_pos',
        array(
            'default'           => 'right',
            'sanitize_callback' => 'gtl_sanitize_sidebar',
        )
    );

    $wp_customize->add_control(
        'page_sidebar_pos',
        array(
            'type'        => 'radio',
            'label'       => __('Page sidebar position', 'gtl-multipurpose'),
            'section'     => 'gtl_page_sidebar_panel',
            'description' => __('Select the sidebar position for pages', 'gtl-multipurpose'),
            'choices' => array(
                'none'    => __('No sidebar', 'gtl-multipurpose'),
                'right'     => __('Right sidebar', 'gtl-multipurpose'),
                'left'=> __('Left sidebar', 'gtl-multipurpose')
            ),
        )
    );

    // page sidebar id
    $wp_customize->add_setting(
        'page_sidebar_id',
        array(
            'default'           => 'sidebar-1',
            'sanitize_callback' => 'gtl_sanitize_sidebar_id',
        )
    );
    $wp_customize->add_control(
        'page_sidebar_id',
        array(
            'type'        => 'radio',
            'label'       => __('Select sidebar', 'gtl-multipurpose'),
            'section'     => 'gtl_page_sidebar_panel',
            'description' => __('Select sidebar for pages. Will ignored if No sidebar is checked above', 'gtl-multipurpose'),
            'choices' => gtl_multipurpose_sidebars(),
        )
    );



    // shop sidebar position
    $wp_customize->add_section(
        'gtl_shop_sidebar_panel',
        array(
            'title'         => __('Shop sidebar', 'gtl-multipurpose'),
            'priority'      => 11,
            'panel'         => 'gtl_sidebar_panel', 
        )
    );

    $wp_customize->add_setting(
        'shop_sidebar_pos',
        array(
            'default'           => 'right',
            'sanitize_callback' => 'gtl_sanitize_sidebar',
        )
    );

    $wp_customize->add_control(
        'shop_sidebar_pos',
        array(
            'type'        => 'radio',
            'label'       => __('Shop sidebar position', 'gtl-multipurpose'),
            'section'     => 'gtl_shop_sidebar_panel',
            'description' => __('Select the sidebar position for shop archive/single templates', 'gtl-multipurpose'),
            'choices' => array(
                'none'    => __('No sidebar', 'gtl-multipurpose'),
                'right'     => __('Right sidebar', 'gtl-multipurpose'),
                'left'=> __('Left sidebar', 'gtl-multipurpose')
            ),
        )
    );

    // shop sidebar id
    $wp_customize->add_setting(
        'shop_sidebar_id',
        array(
            'default'           => 'sidebar-1',
            'sanitize_callback' => 'gtl_sanitize_sidebar_id',
        )
    );

    $wp_customize->add_control(
        'shop_sidebar_id',
        array(
            'type'        => 'radio',
            'label'       => __('Select sidebar', 'gtl-multipurpose'),
            'section'     => 'gtl_shop_sidebar_panel',
            'description' => __('Select sidebar for shop archive/single teamplates. Will ignored if No sidebar is checked above', 'gtl-multipurpose'),
            'choices' => gtl_multipurpose_sidebars(),
        )
    );

    /**
    * Sanitazation 
    */

    // sidebar position
    function gtl_sanitize_sidebar( $input ) {
        $valid = array(
                    'none'    => __('No sidebar', 'gtl-multipurpose'),
                    'right'     => __('Right sidebar', 'gtl-multipurpose'),
                    'left'=> __('Left sidebar', 'gtl-multipurpose')
        );
     
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }

    // sidebar id
    function gtl_sanitize_sidebar_id( $input ) {
        $valid = gtl_multipurpose_sidebars();
     
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }

