<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Full Content Template
 *
  Template Name:  Ajax Page
 *
 * @file           ajax-page.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2011 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/ajax-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */
?>
<link rel='stylesheet' id='responsive-style-css'  href='/wp-content/themes/responsive/style.css?ver=1.8.4' type='text/css' media='all' />

<style>.form-vertical-list label.error, label.error{color:red;font-weight:normal}</style>
<?php
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    get_header();
    if (!in_array($post->ID, array(72, 374))) {
        echo "<style>#content-full h1.yellow-title {display:none}</style>";
        if (!in_array($post->ID, array(715, 438))) {
        ?>
        <div id="slider_non_ajax">
            <div id="event_header">
                <div id="event_back_button"><a href="/" class="close-btn">X</a></div>
                <div id="event_header_separator"></div>
                <div id="event_heading" class="event-title-details" style="width: 70%"><?php the_title(); ?>
                      </div>
        </div>
        <?php
        }
    }
} else {
    
    ?>
    <div id="event_header">
        <div id="event_back_button"><a href="#" class="close-btn">X</a></div>
        <div id="event_header_separator"></div>
        <div id="event_heading" class="event-title-details" style="width: 70%"><?php the_title(); ?></div>


    </div>
    <?php
}
?>

<div id="content-full" class="grid col-940">

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

            <?php $options = get_option('responsive_theme_options'); ?>
            <?php if ($options['breadcrumb'] == 0): ?>
                <?php //echo responsive_breadcrumb_lists();  ?>
            <?php endif; ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'): ?>
                    <h1 class="post-title yellow-title"><?php the_title(); ?></h1>
            <?php endif; ?>


                <div class="post-entry">
                <?php the_content(__('Read more &#8250;', 'responsive')); ?>
                <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->



                <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div> 
            </div><!-- end of #post-<?php the_ID(); ?> -->

        <?php //comments_template( '', true );  ?>

    <?php endwhile; ?> 
    		
        <?php if ($wp_query->max_num_pages > 1) : ?>
            <div class="navigation">
                <div class="previous"><?php next_posts_link(__('&#8249; Older posts', 'responsive')); ?></div>
                <div class="next"><?php previous_posts_link(__('Newer posts &#8250;', 'responsive')); ?></div>
            </div><!-- end of .navigation -->
        <?php endif; ?>

<?php else : ?>

        

<?php endif; ?>  
            
    <script type='text/javascript' src='http://code.jquery.com/jquery-1.7.2.min.js'></script>

    <script type="text/javascript" src="/wp-content/js/jquery.form.js"></script>
    <script type="text/javascript" src="/wp-content/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/wp-content/js/additional-methods.js"></script>
    <script type="text/javascript" src="/wp-content/js/bbq.js"></script>
    <?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    ?>
    <script type="text/javascript" src="/wp-content/js/jquery-ui-1.8.5.custom.min.js"></script>
<?php
}
?>

    <script type='text/javascript' src='/wp-content/themes/responsive/js/jquery.selectbox-0.2.js?ver=0.2'></script>
    
    <script src="<?php echo home_url() ?>/wp-content/themes/responsive/js/jquery.blockUI.js" type="text/javascript"></script>

    <script type='text/javascript' src='/wp-content/themes/responsive/js/plan_an_event.js'></script>
</div><!-- end of #content-full -->

<?php
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    get_footer();
}
?>
