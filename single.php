<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Single Posts Template
 *
 *
 * @file           single.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2012 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

<div class="viewport-container">
<div id="content" class="grid col-700">
        
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        
        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php echo responsive_breadcrumb_lists(); ?>
        <?php endif; ?> 
          
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                
                <div class="post-entry">
                <h1 class="post-title"><?php the_title(); ?></h1>
<p class="timestamp"><?php the_time('F j, Y') ?>, <?php printf(__('%s', 'responsive'), get_the_category_list(', ')); ?></p>
<?php if ( has_post_thumbnail()) : ?>
<div class="wp-caption alignright">
                    <?php the_post_thumbnail(); ?>
<?php
$get_description = get_post(get_post_thumbnail_id())->post_excerpt;
  if(!empty($get_description)){//If description is not empty show the p
  echo '<p class="wp-caption-text">' . get_post(get_post_thumbnail_id())->post_excerpt . '</p>';
  }
?>
</div>
                    <?php endif; ?>
                    <?php the_content(__('Read more &#8250;', 'responsive')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                <div class="post-data">
	<?php the_tags(__('Tagged with:', 'responsive') . ' ', ', ', '<br />'); ?> 
	<?php printf(__('Posted: %s', 'responsive'), get_the_category_list(', ')); ?> 
                </div><!-- end of .post-data --> 
<div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>
                </div><!-- end of .post-entry -->             
            </div><!-- end of #post-<?php the_ID(); ?> -->
        <?php endwhile; ?> 

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&larr; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>  
      
        </div><!-- end of #content -->

<?php get_sidebar('right'); ?>
</div>
<?php get_footer(); ?>