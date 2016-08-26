<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Full Content Template
 *
   Template Name:  Full Width Page (no sidebar)
 *
 * @file           full-width-page.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2011 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/full-width-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
<?php if(array_key_exists("mc_id", $_GET)){
}else{ ?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Banners') ) { ?>
<?php } ?>

<?php }?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-544a973e4bf43e61" async="async"></script>
<div class="viewport-container">
        <div id="content-full" class="grid col-940 calendar-sidebar-content">
<?php
if($post->ID == 103)
{
    $event = $wpdb->get_row( "SELECT * FROM ".my_calendar_table()." WHERE event_id = ".$_GET['mc_id']);
    if($event->event_image != "")
	{
        $img_src = str_replace('-158x106', '', $event->event_image);
		$img_src_thumb = $event->event_image;
	}else
	{
        $img_src = "/wp-content/themes/responsive/images/placeholder-full.png";
		$img_src_thumb = "/wp-content/themes/responsive/images/placeholder-156x108.png";
    }
    $nextEventId = $wpdb->get_var( "SELECT event_id FROM ".my_calendar_table()." WHERE event_category = ".$event->event_category." AND event_begin > '".$event->event_begin."' order by event_begin ASC limit 1");
    $prevEventId = $wpdb->get_var( "SELECT event_id FROM ".my_calendar_table()." WHERE event_category = ".$event->event_category." AND event_begin < '".$event->event_begin."' order by event_begin DESC limit 1");
    if(strtotime($event->event_end) < strtotime(date('Y-m-d')))
        $close_url = $_SERVER["HTTP_REFERER"];
    else
        $close_url = home_url()."/".(($event->event_category == 1)?"education-and-events/":"exhibition");
    
    $url = home_url().'/show-event-detail?mc_id='.$event->event_id;
?>
<style>
.center
{
margin:auto;
width:70%;
text-align: justify;
}
</style>

            <div id="event_details">
                <div id="event_header">
                    <div id="event_back_button"><a href="<?php echo $close_url;?>">X</a></div>
                    <div id="event_header_separator">&nbsp;</div>
                    <div id="event_heading" class="event-title-details">
                        <?php echo stripslashes($event->event_title) ?>

| <?php echo date('F j, Y',  strtotime($event->event_begin)) ?> <?php if($event->event_category == 3):?> - <?php echo date('F j, Y',  strtotime($event->event_end)) ?> <?php endif;?>
                    </div>

                    <div id="event_next_previous">
                        <?php if($prevEventId != ""):?>
                            <a href="/show-event-detail?mc_id=<?php echo $prevEventId;?>"><span>&#9668;</span></a>
                        <?php endif;?>
                        <?php if($nextEventId != ""):?>
                            <a href="/show-event-detail?mc_id=<?php echo $nextEventId?>"><span>&#9658;</span></a>
                        <?php endif;?>
                     </div>

                </div>
                <div id="event_content" class="center">
                    <div id="event_image" class="event-detail-pic"><center><img src="<?php echo $img_src?>" /></center></div>
                    <div id="event_description" style="margin-top: 1em"><?php echo stripslashes($event->event_desc)?></div>
                </div>
                <div id="event_footer" class="center" style="margin-top: 1em">
                    
                    <style type="text/css" media="screen">
  #custom-tweet-button a {
    display: block;
    padding: 2px 5px 2px 20px;
    background: url('/wp-content/themes/responsive/images/share-tumblr-icon.png') 1px center no-repeat;
    border: 1px solid #ccc;
  }
</style>
                    <div id="event_actions">                        
                        <?php if($event->event_category == 3):?>
                            <span class="share-icon"><a href="#shareevent" class="fancybox active">Share Exhibition</a></span>

                        <?php endif;?>
                        <?php if($event->event_category == 1):?>
                            <span class="share-icon"><a href="#shareevent" class="fancybox active">Share Event</a></span>

                        <?php endif;?>
                    </div>
                </div>
            </div>
        <div id="content_container" style="display: none">
            <div id="shareevent" style="max-width:500px;">
            	<div class="close-btn-box"><a href="javascript:jQuery.fancybox.close();"><strong>X</strong></a></div>
                <div class="col-300 grid" ><img src="<?php echo $img_src_thumb ?>" id="share_image"/></div>
                <div class="col-620 grid button-style">
                    <div id="share_title" style="display:none"><?php echo stripcslashes($event->event_title) .' | '.date('F j, Y',  strtotime($event->event_begin))?></div>
                    <h5 style="margin-top:0em;margin-bottom: 0em;"><?php echo substr(stripcslashes($event->event_title),0,20) ?> ... | <?php echo date('F j, Y',  strtotime($event->event_begin)) ?></h5>
                    <p id="share_desc" style="height: 48px;margin-top: 0.5em;overflow: hidden;margin-bottom: .5em; line-height: 1.3;">
                    <?php echo substr(stripslashes($event->event_desc),0,150); ?>...
                </p><input type="text" value="<?php echo $url?>" id="copy_url" readonly /><img src="/wp-content/themes/responsive/images/copy-url-btn.png" id="copy_btn" />
                </div>
                <div class="clr"></div>
                <h3>Share with your friends</h3>
                <div class="social-icon-list">
                    <span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(home_url().$_SERVER['REQUEST_URI'])?>"><img src="/wp-content/themes/responsive/images/share-facebook-icon.png" class="share-icon" /></a></span>
				 <span><a href="https://twitter.com/share?text=<?php echo urlencode(stripslashes($event->event_title).' | '. date('F j, Y',  strtotime($event->event_begin)).' Long Beach Museum of Art')?>&via=LBMAOrg&url=<?php echo urlencode(getTinyUrl(home_url().$_SERVER['REQUEST_URI']))?>" target="_blank" id="twitter"><img src="/wp-content/themes/responsive/images/share-tumblr-icon.png" class="share-icon" /></a></span>
				 <span><a href="#"><img src="/wp-content/themes/responsive/images/share-email-icon.png" class="share-icon fancybox" onclick="javascript:showDialog()"/></a></span>
                <?php //if(function_exists('social_ring_show')){ social_ring_show();} ?>
                </div>
            </div>
            <div id="buyadmission" style="max-width:500px;">
            	<div class="close-btn-box"><a href="javascript:jQuery.fancybox.close();"><strong>X</strong></a></div>
                <div class="col-300 grid" ><img src="<?php echo $event->event_image ?>" id="share_image"/></div>
                <div class="col-620 grid button-style">
                    <h5 style="margin-top:0em;margin-bottom: 0em;"><?php echo stripcslashes($event->event_title) ?> | <?php echo date('F j, Y',  strtotime($event->event_begin)) ?></h5>
                    <p style="height: 55px;margin-top: 0.5em;overflow: hidden;margin-bottom: -0.5em; "><?php echo substr(stripslashes($event->event_desc),0,150); ?>...</p>
                     <h3>GENERAL ADMISSION</h3>
                <div class="social-icon-list">
                    &dollar;7 / &dollar;6 Students/Seniors (over age 62)<br />
                        Current I.D required<br />
                        Members and Children under 12 Free<br />
                </div>
                </div>
                <div class="clr"></div>
               
            </div>
        </div>
            
            <?php }else{ ?>
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        
        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php //echo responsive_breadcrumb_lists(); ?>
        <?php endif; ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if($post->ID != 103): ?>
                            <?php if($post->ID == 880){$style = " style='border-bottom: 32px solid #693300;top: 252px !important;z-index: 2;'";}elseif($post->ID == 76 || $post->ID == 72 || $post->ID == 374 || $post->ID == 1881 || $post->ID == 1326 ){$style = " style='top: -32px;'";}
elseif ($post->ID == 1754 || $post->ID == 1752 || $post->ID == 1756 || $post->ID == 2182 ){$style = "style='top: -32px; border-bottom: 32px solid #c4bc7b;'";}
else{$style="";}?>
			<?php endif; ?>
                <div class="post-entry">
<h1 class="title-ribbon"><?php the_title(); ?></h1>
                    <?php the_content(__('Read more &#8250;', 'responsive')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->
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
      
        </div><!-- end of #content-full -->
<?php } ?>
</div>
<?php get_footer(); ?>