<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GTL_Multipurpose
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-wrap'); ?>>
    <div class="article-wrap">
            <?php if( gtl_multipurpose_feat_image() ):?>
                <div class="article-img-wrap">
                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail('gtl-multipurpose-img-525-350'); ?></a>
                </div>
            <?php endif; ?>

            <?php if( ! esc_attr( get_theme_mod( 'hide_meta_index' ) )  && ( 'post' == get_post_type() ) ):?>                            
                <?php gtl_multipurpose_posted_on(); ?>
            <?php endif;?>

        

        <?php gtl_multipurpose_categories(); ?>  

        <?php gtl_multipurpose_comment_count(); ?>
        <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>

          <?php 
            gtl_multipurpose_post_excerpt();
           ?>

         <?php if( ! esc_attr( get_theme_mod( 'hide_meta_index' ) ) && ( 'post' == get_post_type() ) ):?>                            
               <?php gtl_multipurpose_author();?> 
            <?php endif;?>
              

    </div>
</div>