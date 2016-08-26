<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Education Calendar/Sidebar Template
 *
   Template Name:  Education Calendar/Sidebar
 *
 * @file           education-sidebar-page.php
 * @package        Responsive
 * @author         Gerard Greenidge
 * @copyright      2003 - 2014 EDUNOW
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-child/calendar-sidebar-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

?>
<?php get_header(); ?>
<?php if(array_key_exists("mc_id", $_GET)){
}else{
echo slider_pro(3, array("width"=>"100%", "height"=>400, "effect_type"=>"swipe"));}?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-544a973e4bf43e61" async="async"></script>
        <div id="content" class="grid col-700" <?php echo $height; ?>>

<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

        <?php $options = get_option('responsive_theme_options'); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="post-entry">
<?php if(array_key_exists("mc_id", $_GET)){
}else{ ?>
                <h1 class="post-title yellow-title" style="top: -32px; border-bottom: 32px solid #c4bc7b; display:block"><?php the_title(); ?></h1>
<?php } ?>
                    <?php the_content(__('Read more &#8250;', 'responsive')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>

</div>
                <?php if($post->ID == 63 || $post->ID == 4): ?>
                    <div class="<?php echo $color ?>-bg-color" style="bottom: 0px;position: absolute;width: 96%;">
                    <div class="col-220 grid-right nav-exhibition" style="padding-top: 0em;">
                        <?php if($count > 4):?>

                            <a href="<?php echo $prev_page?>">◄</a>
                            Page <span><?php echo $current_page;?></span> of <?php echo $total_pages?>
                            <a href="<?php echo $next_page?>">►</a>
                        <?php endif; ?>
                    </div>
                    </div>
                <?php endif; ?>
                <!-- end of .post-entry -->

                <?php if ( comments_open() ) : ?>
                <div class="post-data">
				    <?php the_tags(__('Tagged with:', 'responsive') . ' ', ', ', '<br />'); ?>
                    <?php the_category(__('Posted in %s', 'responsive') . ', '); ?>
                </div><!-- end of .post-data -->
                <?php endif; ?>

            <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>
            </div><!-- end of #post-<?php the_ID(); ?> -->

            <?php //comments_template( '', true ); ?>

        <?php endwhile; ?>

        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&larr; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>

        </div><!-- end of #content -->

<?php get_sidebar('right'); ?>
<?php get_footer(); ?>