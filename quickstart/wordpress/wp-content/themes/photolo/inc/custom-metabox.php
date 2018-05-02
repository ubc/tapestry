<?php
/**
 * FotoGraphy functions and definitions
 *
 * @package FotoGraphy
 */
 
add_action('add_meta_boxes', 'photolo_layout_box');  
function photolo_layout_box()
{   
    $types = array('post', 'page');
    add_meta_box(
                 'photolo_gallery_single_page', // $id
                 __( 'Gallery Page Layout', 'photolo' ), // $title
                 'photolo_gallery_page_callback', // $callback
                 $types, // $page
                 'normal', // $context
                 'high'); // $priority
    
}

/**
 * Gallery Layout Metabox 
**/
$photolo_gallery_layouts = array(
       
        'grid' => array(
                        'value'     => 'grid',
                        'label'     => __( 'Grid(Default)', 'photolo' ),
                        'thumbnail' => get_template_directory_uri() . '/images/grid.png',
                    ), 
        'masonry' => array(
                        'value' => 'masonry',
                        'label' => __( 'Mesonry Layout', 'photolo' ),
                        'thumbnail' => get_template_directory_uri() . '/images/mesonary.png',
                    ),
       
        'packery' => array(
                        'value'     => 'packery',
                        'label'     => __( 'Packery Layout', 'photolo' ),
                        'thumbnail' => get_template_directory_uri() . '/images/Packery.png',
                    ),
       

        'striped' => array(
                        'value'     => 'striped',
                        'label'     => __( 'Striped Layout', 'photolo' ),
                        'thumbnail' => get_template_directory_uri() . '/images/Striped.png',
                    ) ,

         'full' => array(
                        'value'     => 'full',
                        'label'     => __( 'Full Screen Layout', 'photolo' ),
                        'thumbnail' => get_template_directory_uri() . '/images/full-screen.png',
                    ),
    );
function photolo_gallery_page_callback()
{
    global $post, $photolo_gallery_layouts ;
    wp_nonce_field( basename( __FILE__ ), 'photolo_settings_gallery_nonce' );
?>
    <table class="form-table">
        <tr>
        <td>
        <?php
            $i = 0;  
           foreach ($photolo_gallery_layouts as $field) {  
           $photolo_gallery_metalayouts = get_post_meta( $post->ID, 'photolo_gallery_layouts', true ); 
         ?>            
            <div class="radio-image-wrapper slidercat" id="slider-<?php echo $i; ?>" style="float:left; margin-right:30px;">
            <label class="description">
                <span><img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="" /></span></br>
            <input type="radio" name="photolo_gallery_layouts" value="<?php echo $field['value']; ?>" <?php checked( $field['value'], 
                        $photolo_gallery_metalayouts ); 
                        if(empty($photolo_gallery_metalayouts) && 
                            $field['value']=='grid')
                        { 
                            echo "checked='checked'"; 
                        } ?>/>
                &nbsp;<?php echo $field['label']; ?>
            </label>
            </div>
            <?php 
            $i++;
                } // end foreach 
            ?>
        </td>
        </tr>            
    </table>
<?php
}

/*-------------------Save function for Gallery Setting-------------------------*/

function photolo_save_gallery_settings( $post_id ) { 
    global $photolo_gallery_layouts, $post; 
    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'photolo_settings_gallery_nonce' ] ) || !wp_verify_nonce( $_POST[ 'photolo_settings_gallery_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
        
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }
    
    foreach ($photolo_gallery_layouts as $field) {  
        //Execute this saving function
        $old = get_post_meta( $post_id, 'photolo_gallery_layouts', true); 
        $new = sanitize_text_field($_POST['photolo_gallery_layouts']);
        if ($new && $new != $old) {  
            update_post_meta($post_id, 'photolo_gallery_layouts', $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id,'photolo_gallery_layouts', $old);  
        } 
     } // end foreach    
}
add_action('save_post', 'photolo_save_gallery_settings');





