<?php
/*
Template Name: Blog Page
*/
//This Removes the Loop
//If you want to include the static page title and content
//Remove or COmment out this code
//remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Force content-sidebar layout setting
add_filter( 'site_layout', '__genesis_return_content_sidebar_content' );

//* Add Custom Body Class
add_filter( 'body_class', 'brotherhood_blog_body_class' );
function brotherhood_blog_body_class( $classes ) {
	$classes[] = 'blog-page';
	return $classes;
}

//* Add widget area markup
add_action('genesis_after_header', 'brotherhood_blog_hero');
function brotherhood_blog_hero() {
	 genesis_widget_area( 'blog-page-hero', array(
		'before' => '<div class="blog-page-hero widget-area overlay"><div class="wrap">',
		'after'  => '</div></div>', 
	) );
}

add_action( 'genesis_after_content', 'brotherhood_blog_widget_area' );
function brotherhood_blog_widget_area() {

   genesis_widget_area( 'blog-page-1', array(
		'before' => '<div class="blog-page-1 widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );

	genesis_widget_area( 'blog-page-2', array(
		'before' => '<div class="blog-page-2 widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );

	genesis_widget_area( 'blog-page-3', array(
		'before' => '<div class="blog-page-3 widget-area"><div class="wrap">',
		'after'  => '</div></div>', 
	) );
}

genesis();
