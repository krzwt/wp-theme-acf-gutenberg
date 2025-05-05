<?php

/**
* Load the theme scripts.
*/

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

/**
 * Enqueue scripts and styles.
 */
function mytheme_scripts()
{
    wp_enqueue_style(THEME_PREFIX . '-wp-style', get_stylesheet_uri(), array(), _THEME_VERSION);

    wp_enqueue_script('jquery');

    $manifest_path = get_template_directory() . '/assets/manifest.json';
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest['main.css'])) {
            wp_enqueue_style(THEME_PREFIX . '-style', get_template_directory_uri() . '/assets' . $manifest['main.css'], array(), _THEME_VERSION);
        }

        if (isset($manifest['main.js'])) {
            wp_enqueue_script(THEME_PREFIX . '-scripts', get_template_directory_uri() . '/assets' . $manifest['main.js'], array(), _THEME_VERSION, true);
        }
    }

    // Enqueue the custom AJAX handling script
    wp_enqueue_script(THEME_PREFIX . '-ajax-script', get_template_directory_uri() . '/sources/js/modules/ajax-scripts.js', array(), _THEME_VERSION, true);

    // Localize the script to pass AJAX URL and nonce to JavaScript
    wp_localize_script(
        THEME_PREFIX . '-ajax-script',
        'mytheme_ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'), // AJAX handler URL
            'nonce' => wp_create_nonce('ajax-nonce') // Security nonce
        )
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mytheme_scripts');
