<?php
/**
* Load the custom scripts and styles.
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/**
 * [action__front_script Function to add script at front side]
 *
 */
function action__front_script() {
    $theme = wp_get_theme();
    $theme_version = $theme->get( 'Version' );

    // Register and enqueue style
    wp_register_style( THEME_PREFIX . '-wp-style', get_template_directory_uri() . '/style.css', array(), $theme_version );
    wp_enqueue_style( THEME_PREFIX . '-wp-style' );
    wp_register_style( THEME_PREFIX . '-style', get_template_directory_uri() . '/assets/css/style.min.css', array(), $theme_version );
    wp_enqueue_style( THEME_PREFIX . '-style' );
    // wp_enqueue_script( THEME_PREFIX . '-player-js', 'https://player.vimeo.com/api/player.js', array('jquery'), '1.0.0', true );
    // wp_enqueue_script( THEME_PREFIX . '-iframe-api-js', 'https://www.youtube.com/iframe_api', array('jquery'), '6.0.2', true );
    if (file_exists(get_stylesheet_directory() . '/assets/js/scripts.js') && is_admin()){
        wp_register_script( THEME_PREFIX . '-scripts-jquery', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), $theme_version, true );
    }else{
        wp_register_script( THEME_PREFIX . '-scripts-jquery', get_template_directory_uri() . '/assets/js/scripts.min.js', array( 'jquery' ), $theme_version, true );
    }
    wp_enqueue_script( THEME_PREFIX . '-scripts-jquery' );

}
add_action( 'wp_enqueue_scripts', 'action__front_script' );