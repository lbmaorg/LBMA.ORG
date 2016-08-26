<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Blog Template
 *
   Template Name: In The News Category Template
 *
 * @file           category-12.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2012 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/category-10.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
<div class="viewport-container">
<div id="content" class="col-960">
<?php global $more; $more = 0; ?>
        <div id="content-blog" class="grid col-700">
<?php
    if ( get_query_var('paged') )
	    $paged = get_query_var('paged');
	elseif ( get_query_var('page') ) 
	    $paged = get_query_var('page');
	else 
		$paged = 1;
		query_posts("post_type=post&paged=$paged&cat=12"); 
?>

<h1 class="inthenews_title">In The News</h1>

<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>                                
                <div class="post-entry">
<?php if ( has_post_thumbnail()) : ?>
                        <div class="leftthumbnail"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                    <?php the_post_thumbnail(); ?>
                        </a></div>
                    <?php endif; ?>
                <div class="rightcopy"><h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'responsive'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
<p class="timestamp"><?php the_time('F j, Y') ?></p>
                    <div class="post-content"><?php the_content(__('Read more &#8250;', 'responsive')); ?></div>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>

            <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>
                </div><div class="clear">&nbsp;</div></div><!-- end of .post-entry -->           
            </div><!-- end of #post-<?php the_ID(); ?> -->
            
        <?php endwhile; ?> 
        

<div class="post-count-container">
<?php
//global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>
</div>
	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&larr; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>
        
<?php endif; ?>  
      
        </div><!-- end of #content-blog -->

<?php get_sidebar('right'); ?>
</div>
<?php get_footer(); ?>