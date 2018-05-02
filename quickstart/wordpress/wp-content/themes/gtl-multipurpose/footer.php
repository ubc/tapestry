<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTL_Multipurpose
 */

?>
  
   </div>  

    <!--Footer component-->
    <section id="footer" class="jr-site-footer"><!--Now active fixed footer-->
        <div class="<?php echo gtl_multipurpose_site_container();?>">

                            
                <?php if ( is_active_sidebar( 'gtl-footer-1' ) ) : ?>
                    <?php get_template_part( 'template-parts/footer' , 'sidebar' ); ?>
                <?php endif; ?>

        </div>

        <div class="copyright-bottom">
        <?php echo gtl_multipurpose_copyright_text();?>  
        <span> | </span>     
        <?php  echo sprintf( esc_html__( 'Powered by %s', 'gtl-multipurpose' ), '<a target="_blank" rel="designer" href="https://greenturtlelab.com/">' . esc_html__( 'Greenturtlelab', 'gtl-multipurpose' ) . '</a>' ); ?>     
        </div>
    </section>
    <!--Ends-->
      
<?php wp_footer(); ?>

</body>
</html>



