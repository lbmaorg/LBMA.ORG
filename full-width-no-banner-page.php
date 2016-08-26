<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full Content No Banner Template
 *
Template Name:  Full Width Page (no banner)
 *
 * @file           full-width-no-banner-page.php
 * @package    Responsive
 * @author      Gerard Greenidge
 * @copyright  2003 - 2014 EDUNOW
 * @license     license.txt
 * @version     Release: 1.0
 * @filesource     wp-content/themes/responsive/full-width-page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>
<?php if(array_key_exists("mc_id", $_GET)){ ?>
<div id="content-full" class="grid col-940">
<?php }else{ ?>
<h1 class="title-ribbon-no-banner"><?php the_title(); ?></h1>
<div id="content-full" class="grid col-940 no-banner-content">
<?php }?>

	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-header', get_post_type() ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<div class="post-entry">
<?php if(array_key_exists("mc_id", $_GET)){
}else{ ?>

<? }?>					
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div>
				<!-- end of .post-entry -->

				<?php get_template_part( 'post-data', get_post_type() ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>

</div><!-- end of #content-full -->

<?php get_footer(); ?>