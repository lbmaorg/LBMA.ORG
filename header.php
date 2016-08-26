<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive 
 * @author         Gerard Greenidge 
 * @copyright      2003 - 2014 EDUNOW
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-child/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
<!doctype html>
<!--[if !IE]>      <html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta name="p:domain_verify" content="ef118741e17e239196df980fea37effb"/>
        <meta charset="<?php bloginfo('charset'); ?>" />
       <meta name="msvalidate.01" content="60B6329CA3FBF40504AF2821C02F0C8F" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <script type="text/javascript">
            /*function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<span class=\"right-arrow\">&rarr;</span><ul class=\"sub-menu\">\n";
        }*/

        </script>
        
        <?php wp_enqueue_style('responsive-style', get_stylesheet_uri(), false, '1.8.4'); ?>
        <?php wp_head(); ?>
        <link href="<?php echo home_url(); ?>/wp-content/themes/responsive-child/tabs.css" rel="stylesheet">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46446241-1', 'lbma.org');
  ga('send', 'pageview');

</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-544a973e4bf43e61" async="async"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<?php if ($post->ID == 743):
    $getoccurrance = $wpdb->get_row( "SELECT * FROM wp_my_calendar_events WHERE occur_id = ".$_GET['mc_id']);    
    $event = $wpdb->get_row( "SELECT * FROM wp_my_calendar WHERE event_id = ".$getoccurrance->occur_event_id);
    if($event->event_image != "")
	{
        $img_src = str_replace('-158x106', '', $event->event_image);
		$img_src_thumb = $event->event_image;
	}else
	{
        $img_src = "/wp-content/uploads/LBMA_front_nolines.jpg";
	$img_src_thumb = "/wp-content/uploads/LBMA_front_nolines.jpg";
    }
	$url = home_url().'/calendar?mc_id='.$_GET['mc_id'];
?>
<title>Event: <?php echo stripcslashes($event->event_title);?> | Long Beach Museum of Art</title>
<meta property="og:title" content="<?php echo stripcslashes($event->event_title); ?> | Long Beach Museum of Art" />
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:image" content="<?php echo $img_src; ?>" />
<script type="text/javascript">
var addthis_share = {
   url: "<?php echo $url; ?>",
   img: "<?php echo $img_src; ?>"
}

</script>
<?php else: ?>
        <title><?php wp_title('&#124;', true, 'right'); ?> | <?php bloginfo('name'); ?></title>
<?php endif; ?> 

    </head>

<body <?php body_class(); ?>>

<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed">

<?php responsive_header(); // before header hook ?>
	<div class="skip-container cf">
		<a class="skip-link screen-reader-text focusable" href="#content"><?php _e( '&darr; Skip to Main Content', 'responsive' ); ?></a>
	</div><!-- .skip-container -->
	<div id="header"><a name="top"></a>
<div class="viewport-container">
		<?php responsive_header_top(); // before header content hook ?>

		<?php responsive_in_header(); // header hook ?>
<div id="logo-menu">
		<?php wp_nav_menu( array(
			'container'       => 'div',
			'container_class' => 'main-nav',
			'fallback_cb'     => 'responsive_fallback_menu',
			'theme_location'  => 'header-menu'
		) ); ?>
		<?php if ( get_header_image() != '' ) : ?>

			<div id="logo">
				<a href="<?php echo home_url( '/' ); ?>"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			</div><!-- end of #logo -->

		<?php endif; // header image was removed ?>

		<?php if ( !get_header_image() ) : ?>
			<div id="logo">
				<span class="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				<span class="site-description"><?php bloginfo( 'description' ); ?></span>
			</div><!-- end of #logo -->

		<?php endif; // header image was removed (again) ?>
</div>
</div>
<div id="social-tools">
<div class="viewport-container">
		<?php if ( has_nav_menu( 'sub-header-menu', 'responsive' ) ) {
			wp_nav_menu( array(
				'container'      => '',
				'menu_class'     => 'sub-header-menu',
				'theme_location' => 'sub-header-menu'
			) );
		} ?>
		<?php get_sidebar( 'top' ); ?>
</div>
</div>
		<?php responsive_header_bottom(); // after header content hook ?>
	</div><!-- end of #header -->
<?php responsive_header_end(); // after header container hook ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
	<div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>