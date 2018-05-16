<?php
/*
  Plugin Name:Upload Max File Size
  Description: increase, upload, limit, up to, 250Mb or more
  Author:Ashutosh Kumar
  Author URI: https://github.com/ashutoshdev
  Plugin URI:https://wordpress.org/plugins/upload-max-file-size/
  Version: 1.2
  License: GPL2
  Text Domain:upload-max-filesize

  Copyright 2013 - 2017 upload-max-filesize(email : looklikeme05@gmail.com)

  Increase Upload Max Filesize is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  Increase Upload Max Filesize is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with  Upload Max File Size; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
// Hook for adding admin menus
add_action('admin_menu', 'upload_max_file_size_add_pages');

// action function for above hook
if ( !function_exists( 'upload_max_file_size_add_pages' ) ) {
function upload_max_file_size_add_pages() {
    // Add a new menu under Settings
    add_menu_page(__('upload_max_file_size', 'upload-max'), __('Upload Max File Size', 'upload-max'), 'manage_options', 'upload_max_file_size', 'upload_max_file_size');
}
}
//plugin dash board page
function upload_max_file_size() {
   

    /**
     * Below are the form 
     * @since 1.0
     */
    ?>
    <form method="post">
        <?php
        settings_fields("header_section");
        do_settings_sections("manage_options"); 
        wp_nonce_field('upload_max_file_size_action', 'upload_max_file_size_field');
        submit_button();
    ?>

        <br/><br/> <br/>(Example: 262144000 bytes ) or (Example: 262144000 )(Only enter the numeric value in bytes)
        <br/>
        <br/>

        1024000 bytes=1MB(calculate the Bytes into Mb Example: 1024000 * n MB= n Bytes)(n= no of value )
        <br/><br/>
        1024000*250MB=262144000 bytes
        <br/><br/>
        (You can Increase Upload file size 250MB or more .So Enter the bytes value how much you want.. )
        <br/><br/><br/>

        <a href="http://www.readyourlessons.com/upload-max-file-size/"> Online Support</a><br/><br/><br/>
        <a href="http://www.webitmart.com/">Contact Us for Website/Mobile Application Development</a>

        <br/><br/><br/>

    </form>

    <?php
    /**
     * form end 
     * @since 1.2
     */
    //submit form start 
    if (!isset($_POST['upload_max_file_size_field']) || !wp_verify_nonce($_POST['upload_max_file_size_field'], 'upload_max_file_size_action')) {
        echo 'Sorry, your nonce did not verify.';
        exit;
    } else {
        $number = sanitize_text_field($_POST['number']);
        update_option('max_file_size', $number);
    }
}
//filter
add_filter('upload_size_limit', 'upload_max_increase_upload');

function upload_max_increase_upload() {
    return get_option('max_file_size');
}
function max_display_options() {
    //section name, display name, callback to print description of section, page to which section is attached.
    add_settings_section("header_section", "Increase Upload Maximum File Size", "max_display_header_options_content", "manage_options");
    add_settings_field("header_logo", "Enter Value In Number", "max_display_logo_form_element", "manage_options", "header_section");
    register_setting("header_section", "number");
}

function max_display_header_options_content() {
    echo "";
}

function max_display_logo_form_element() {
     printf(
            '<input type="text" id="number" name="number" value="%s" />',
            (null!==get_option('max_file_size') ) ? esc_attr( get_option('max_file_size')) : ''
        );
}
add_action("admin_init", "max_display_options");
?>