<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTL_Multipurpose
 */

?>
<?php 
$sidebar_bg = esc_attr( get_theme_mod('sidebar_background') );
?>
<div class="cols is-sidebar secondary <?php echo gtl_multipurpose_get_sidebar_id(); if( $sidebar_bg ){ echo ' hassidebar_bg';}?>">
<?php 
dynamic_sidebar( gtl_multipurpose_get_sidebar_id() ); ?>
</div>