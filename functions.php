<?php

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'brotherhood', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'brotherhood' ) );

// The proper way to enqueue GSAP script
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer ); 
function theme_gsap_script() {
	wp_enqueue_script( 'gsap-js', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/TweenMax.min.js', array(), false, true );

	wp_enqueue_script('gsap-css', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/plugins/CSSPlugin.min.js', array(), false, true);

	wp_enqueue_script('gsap-ease', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/easing/EasePack.min.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'theme_gsap_script' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Brotherhood Genesis Theme ' );
define( 'CHILD_THEME_URL', 'http://hummingbirdesigns.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );

add_action( 'wp_enqueue_scripts', 'brotherhood_scripts_styles' );
function brotherhood_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700', array(), 1.0 );

    //*font-awesome was custom added
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), 'brotherhood' );

	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), 1.0 );
	
	wp_enqueue_script( 'brotherhood-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.min.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'brotherhood' ),
		'subMenu'  => __( 'Menu', 'brotherhood' ),
	);

	wp_localize_script( 'brotherhood-responsive-menu', 'brotherhoodL10n', $output );

	wp_enqueue_script( 'brotherhood-site-header', get_stylesheet_directory_uri() . '/js/site-header.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script('brotherhood-global-js', get_stylesheet_directory_uri() . '/js/global.js', array(), false, true);
}

add_filter('widget_text', 'do_shortcode');

//* MY CUSTOM ENQUEUE SCRIPTS
add_theme_support('post-thumbnails');

//set_post_thumbnail_size( 'Home Page', 600, 600, true );

//*Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array('header', 'nav', 'subnav', 'main', 'footer-widgets', 'footer'));

//* Rename Menus
add_theme_support( 'genesis-menus', array(
	'primary' => __('Header Top Navigation Menu', 'brotherhood'),
	'secondary' => __('Secondary Navigation Menu', 'brotherhood')));

//Add new image sizes;
add_image_size('home-top', 780, 354, TRUE);
add_image_size('home-middle', 375, 175, TRUE);
add_image_size( 'front-page-featured', 1280, 800, TRUE );
add_image_size( 'hero-image', 1400, 400, TRUE);

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add screen reader class to archive description
add_filter( 'genesis_attr_author-archive-description', 'genesis_attributes_screen_reader_class' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 140,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Remove navigation meta box
add_action( 'genesis_theme_settings_metaboxes', 'brotherhood_remove_genesis_metaboxes' );
function brotherhood_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
}

//* Remove header right widget area
unregister_sidebar( 'header-right' );

//* Reposition primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'brotherhood_secondary_menu_args' );
function brotherhood_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 5;

	return $args;

}

//* Remove skip link for primary navigation
add_filter( 'genesis_skip_links_output', 'brotherhood_skip_links_output' );
function brotherhood_skip_links_output( $links ) {

	if ( isset( $links['genesis-nav-primary'] ) ) {
		unset( $links['genesis-nav-primary'] );
	}

	return $links;

}

//* Remove sidebars
//unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
//genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove layout section from Theme Customizer
add_action( 'customize_register', 'brotherhood_customize_register', 16 );
function brotherhood_customize_register( $wp_customize ) {

	$wp_customize->remove_section( 'genesis_layout' );
}

//*Remove the entry title
remove_action('genesis_entry_header', 'genesis_do_post_title');

//* Modify the entry title text
function brotherhood_title( $title ) {

	if ( genesis_get_custom_field( 'large_title' ) ) {
		$title = '<span class="brotherhood-large-text">' . genesis_get_custom_field( 'large_title' ) . '</span><span class="intro">' . $title . '</span>';
	}

	return $title;
}

//* Add entry title filter to posts and pages
add_action( 'genesis_entry_header', 'brotherhood_add_title_filter', 1 );
function brotherhood_add_title_filter() {

	if ( is_singular() ) {
		add_filter( 'the_title', 'brotherhood_title' );
	}
}

//* Remove post and page title filter after entry header
//add_action( 'genesis_entry_header', 'brotherhood_remove_title_filter', 15 );
//function brotherhood_remove_title_filter() {

//	remove_filter( 'the_title', 'brotherhood_title' );
//}

//* Customize the content limit more markup
add_filter( 'get_the_content_limit', 'brotherhood_content_limit_read_more_markup', 10, 3 );
function brotherhood_content_limit_read_more_markup( $output, $content, $link ) {	
	
	$output = sprintf( '<p>%s &#x02026;</p><p class="more-link-wrap">%s</p>', $content, str_replace( '&#x02026;', '', $link ) );

	return $output;
}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'brotherhood_author_box_gravatar' );
function brotherhood_author_box_gravatar( $size ) {

	return 160;
}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'brotherhood_comments_gravatar' );
function brotherhood_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;
	return $args;
}

//* Remove the entry meta in the entry footer on category pages
add_action( 'genesis_before_entry', 'brotherhood_remove_entry_footer' );
function brotherhood_remove_entry_footer() {

	if ( is_front_page() || is_archive() || is_page_template( 'page_blog.php' ) ) {

		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}
}

//* Setup widget counts
function brotherhood_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}
}

//* Flexible widget classes
function brotherhood_widget_area_class( $id ) {

	$count = brotherhood_count_widgets( $id );

	$class = '';
	
	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {	
		$class .= ' widget-halves';
	}

	return $class;
}

//* Add support for 3-column footer widget
add_theme_support( 'genesis-footer-widgets', 3);

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-hero',
	'name'        => __( 'Front Page Hero', 'brotherhood' ),
	'description' => __( 'This is the Hero section on the front page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'brotherhood' ),
	'description' => __( 'This is the 1st section on the front page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'brotherhood' ),
	'description' => __( 'This is the 2nd section on the front page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'brotherhood' ),
	'description' => __( 'This is the 3rd section on the front page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'brotherhood' ),
	'description' => __( 'This is the 4th section on the front page.', 'brotherhood' ),
) );

genesis_register_sidebar( array(
	'id'          => 'about-page-hero',
	'name'        => __( 'About Page Hero', 'brotherhood' ),
	'description' => __( 'This is the Hero section on the About Page.', 'brotherhood' ),
) );

genesis_register_sidebar( array(
	'id'		  => 'about-page-1',
	'name'		  => __('About Page 1', 'brotherhood'),
	'description' => __('This is the First Widget Area on the About Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'		  => 'about-page-2',
	'name'		  => __('About Page 2', 'brotherhood'),
	'description' => __('This is the Second Widget Area on the About Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'          => 'blog-page-hero',
	'name'        => __( 'Blog Page Hero', 'brotherhood' ),
	'description' => __( 'This is the Hero section on the Blog Page.', 'brotherhood' ),
) );

genesis_register_sidebar( array(
	'id'		  => 'blog-page-1',
	'name'		  => __('Blog Page 1', 'brotherhood'),
	'description' => __('This is the First Widget Area on the Blog Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'		  => 'blog-page-2',
	'name'		  => __('Blog Page 2', 'brotherhood'),
	'description' => __('This is the Second Widget Area on the Blog Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'		  => 'blog-page-3',
	'name'		  => __('Blog Page 3', 'brotherhood'),
	'description' => __('This is the Third Widget Area on the Blog Page', 'brotherhood'),
) );
 
genesis_register_sidebar( array(
	'id'		  => 'our-trips-page-hero',
	'name'		  => __('Our Trips Page Hero', 'brotherhood'),
	'description' => __('This is the Hero Image on the Our Trips Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'		  => 'our-trips-page-1',
	'name'		  => __('Our Trips Page 1', 'brotherhood'),
	'description' => __('This is the First Widget on the Our Trips Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'		  => 'our-trips-page-2',
	'name'		  => __('Our Trips Page 2', 'brotherhood'),
	'description' => __('This is the Second Widget on the Our Trips Page', 'brotherhood'),
) );

genesis_register_sidebar( array(
	'id'          => 'register-page-hero',
	'name'        => __( 'Register Page Hero', 'brotherhood' ),
	'description' => __( 'This is the Hero section on the register page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'register-page-1',
	'name'        => __( 'Register Page 1', 'brotherhood' ),
	'description' => __( 'This is the 1st section on the register page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'register-page-2',
	'name'        => __( 'Register Page 2', 'brotherhood' ),
	'description' => __( 'This is the 2nd section on the register page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'register-page-3',
	'name'        => __( 'Register Page 3', 'brotherhood' ),
	'description' => __( 'This is the 3rd section on the register page.', 'brotherhood' ),
) );
genesis_register_sidebar( array(
	'id'          => 'register-page-4',
	'name'        => __( 'Register Page 4', 'brotherhood' ),
	'description' => __( 'This is the 4th section on the register page.', 'brotherhood' ),
) );

//* Replace the 'W' site-login-logo.png with brotherhood-site-login-logo.png
// change login image
add_action("login_head", "my_login_head");
function my_login_head() {
	echo "
	<style>
	body.login #login h1 a {
		background: url('".get_bloginfo('template_url')."/images/brotherhood-site-login-logo.png') no-repeat scroll center top transparent;width: 240px; padding-bottom: 200px;
	}
	</style>
	";
}

// Enable shortcodes in widgets
add_filter ('widget_text', 'do_shortcode');

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

// Remove Footer
 remove_action('genesis_footer', 'genesis_do_footer');
 remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
 remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

?>