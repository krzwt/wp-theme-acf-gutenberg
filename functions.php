<?php

/**
 * ThemeName functions and definitions
 *
 * @package ThemeName
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if (! defined('_THEME_VERSION')) {
    define('_THEME_VERSION', wp_get_theme()->get('Version'));
}

/**
 * Define the default contant that will be used throughout your theme.
 */
define('THEME_PREFIX', 'theme-prefix');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mytheme_setup()
{

    /**
     * Add default posts and comments RSS feed links to head.
     */
    add_theme_support('automatic-feed-links');
/**
     * Let WordPress manage the document title.
     */
    add_theme_support('title-tag');
/**
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');
/**
     * Enable support for wide alignment.
     */
    add_theme_support('align-wide');
/**
     * Enable support for Spacing.
     */
    add_theme_support('custom-spacing');
/**
    * Switch default core markup for search form, comment form, and comments to output valid HTML5.
    */
    add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));
/**
     * This theme uses wp_nav_menu() in one location.
     */
    register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'textdomain' ),
            'menu-2' => esc_html__('Secondary', 'textdomain' ),
        ));
}
add_action('after_setup_theme', 'mytheme_setup');

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/includes/theme-scripts.php';
/**
 * Implement the Custom Action for this theme.
 */
require get_template_directory() . '/includes/theme-action.php';
/**
 * Implement the Custom Filter for this theme.
 */
require get_template_directory() . '/includes/theme-filter.php';
/**
 * Add the Custom functions for this theme.
 */
require get_template_directory() . '/includes/theme-functions.php';
/**
 * Implement security-related functions for this theme.
 */
require get_template_directory() . '/includes/theme-security.php';
/**
 * Register the Custom ACF Block for this theme.
 */
require get_template_directory() . '/includes/acf-block-register.php';
