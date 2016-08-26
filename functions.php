<?php

/* Add custom functions below */

/* Home Widget 4 */
		
    /* Register sidebar attributes */
    if (function_exists('register_sidebar')) {
    register_sidebar(
    array(
    'name' => 'Home Widget 4',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
	 'id' => 'home-widget-4'
    )
    );
    }
	
/* Home Widget 5 */
		
    /* Register sidebar attributes */
    if (function_exists('register_sidebar')) {
    register_sidebar(
    array(
    'name' => 'Home Widget 5',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
	 'id' => 'home-widget-5'
    )
    );
    }
/* Home Widget 6 */
		
    /* Register sidebar attributes */
    if (function_exists('register_sidebar')) {
    register_sidebar(
    array(
    'name' => 'Home Widget 6',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
	 'id' => 'home-widget-6'
    )
    );
    }

/* Page Banners */
		
    /* Register sidebar attributes */
    if (function_exists('register_sidebar')) {
    register_sidebar(
    array(
    'name' => 'Page Banners',
    'before_widget' => '<div id="%1$s" class="pagebanner widget %2$s">',
    'after_widget' => '</div>',
	'id' => 'page-banner'
    )
    );
    }