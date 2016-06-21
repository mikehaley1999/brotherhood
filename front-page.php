<?php
/**
 * This file adds the Front Page to the Brotherhood Genesis Theme.
 *
 * @author Hummingbird Designs
 * @package Brotherhood Genesis Theme
 * @subpackage Customizations
 */

add_action( 'genesis_meta', 'brotherhood_front_page_genesis_meta' );

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function brotherhood_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-hero' ) || is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) ) {

	//* Enqueue scripts
		
	//* Add front-page body class
		add_filter( 'body_class', 'brotherhood_body_class' );
		function brotherhood_body_class( $classes ) {
   			$classes[] = 'front-page';
  			return $classes;
		}

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add homepage widgets
		add_action( 'genesis_loop', 'brotherhood_front_page_widgets' );

	}

}

//* Add markup for front page widgets
function brotherhood_front_page_widgets() {

	echo '<h2 class="screen-reader-text">' . __( 'Main Content', 'brotherhood' ) . '</h2>';

	genesis_widget_area( 'front-page-hero', array(
		'before' => '<div id="front-page-hero" class="front-page-hero"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="flexible-widgets widget-area' . brotherhood_widget_area_class( 'front-page-1' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );
	
	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="flexible-widgets widget-area' . brotherhood_widget_area_class( 'front-page-3' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="flexible-widgets widget-area' . brotherhood_widget_area_class( 'front-page-4' ) . '"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

genesis();