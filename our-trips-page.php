<?php
/* 
Template Name: Our Trips Page 
*/

//* Force content-sidebar layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//This Removes the Loop
//If you want to include the static page title and content
//Remove or Comment out this code
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Add Custom Body Class
add_filter( 'body_class', 'brotherhood_our_trips_body_class' );
function brotherhood_our_trips_body_class( $classes ) {
	$classes[] = 'our-trips-page';
	return $classes;
}

//* Add widget area markup
add_action( 'genesis_after_content', 'brotherhood_our_trips_widget_area' );
function brotherhood_our_trips_widget_area() {
 
    genesis_widget_area( 'our-trips-page-hero', array(
		'before' => '<div class="our-trips-page-hero widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );

	genesis_widget_area( 'our-trips-page-1', array(
		'before' => '<div class="our-trips-page-1 widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );

	genesis_widget_area( 'our-trips-page-2', array(
		'before' => '<div class="our-trips-page-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );
    
}

genesis(); 