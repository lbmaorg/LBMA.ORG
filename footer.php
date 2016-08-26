<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/responsive/footer.php
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */

/*
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<?php responsive_wrapper_bottom(); // after wrapper content hook ?>
</div><!-- end of #wrapper -->
<?php responsive_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php responsive_container_end(); // after container hook ?>

<div id="footer" class="clearfix">
	<?php responsive_footer_top(); ?>

	<div id="footer-wrapper">

		<?php get_sidebar( 'footer' ); ?>

	</div><!-- end #footer-wrapper -->

	<?php responsive_footer_bottom(); ?>
</div><!-- end #footer -->
<div id="sub-footer-menu" class="viewport-container">
<?php if ( has_nav_menu( 'sub-header-menu', 'responsive' ) ) {
			wp_nav_menu( array(
				'container'      => '',
				'menu_class'     => 'sub-header-menu',
				'theme_location' => 'sub-header-menu'
			) );
		} ?>
</div>
<div id="footer-content">
<div id="footer-content-left" class="col-180"><img src="/assets/footer-spacer.png" /></div>
<div id="footer-content-middle" class="col-580">
<p>&copy;<?php echo date('Y'); ?>. <a href="/">Long Beach Museum of Art</a>. All Rights Reserved<br />
2300 East Ocean Boulevard, Long Beach, CA 90803
<br />(562) 439-2119</p>
<p><a href="#top"><img src="/assets/arrow-back-top.png" alt="Back to Top" title="Back to Top" /></a></p>
</div>
<div id="footer-content-right" class="col-180">
<a href="http://www.aam-us.org/ target="_blank"><img src="/assets/alliance_accredited_fullcolor105px.png" alt="American Alliance of Museums. Accredited Museum." title="American Alliance of Museums. Accredited Museum." class="alignright" /></a>		
</div>
</div><!-- end .col-940 -->

<?php responsive_footer_after(); ?>

<?php wp_footer(); ?>
</body>
</html>