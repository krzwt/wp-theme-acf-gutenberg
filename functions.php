<?php
/**
* Load the theme.
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * Define contant.
 */
define( 'THEME_PREFIX', 'noblis-wp' );

define( 'DUMMY_IMAGE_URL', get_stylesheet_directory_uri().'/assets/images/thumbnail-image.png' );
define( 'DUMMY_IMAGE_ALT', 'Default Thumbnail Image' );

/**
 * - Register Navigation Name
 * @var array
 */
register_nav_menus( array(
	'main-menu' => __( 'Main Menu', 'noblis-wp' ),
	'footer-menu' =>  __( 'Footer Menu', 'noblis-wp' ),
	'privacy-menu' =>  __( 'Privacy Menu', 'noblis-wp' ),
) );

/**
 * Switch default core markup to output valid HTML5.
 */
add_theme_support( 'html5', [ 'script', 'style' ] );

/**
 * Declare support for title theme feature.
 */
add_theme_support( 'title-tag' );

/**
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

/**
 * Add theme support files.
 */
require get_template_directory() . '/includes/custom-functions.php';
require get_template_directory() . '/includes/custom-action.php';
require get_template_directory() . '/includes/custom-filter.php';
require get_template_directory() . '/includes/theme-scripts.php';
require get_template_directory() . '/includes/acf-block-register.php';