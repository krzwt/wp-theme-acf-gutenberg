<?php

/**
 * Load the theme filters.
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

add_filter( 'acf/settings/save_json', 'acf_json_save_point' );
add_filter( 'acf/settings/load_json', 'acf_json_load_point' );

/**
 * Save ACF JSON files to custom directory.
 *
 * @param string $path Default save path.
 * @return string Custom path to save JSON.
 */
function acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/includes/acf-json';
}

/**
 * Load ACF JSON files from custom directory.
 *
 * @param array $paths Default load paths.
 * @return array Modified paths to include custom directory.
 */
function acf_json_load_point( $paths ) {
	// Remove default path (optional).
	$paths = array();

	// Add your custom path.
	$paths[] = get_stylesheet_directory() . '/includes/acf-json';

	return $paths;
}

// Gutenberg Disable
// Uncomment the line below to disable the Gutenberg editor for posts
// add_filter('use_block_editor_for_post', '__return_false', 10);

/*-------------------------------------
    Move Yoast SEO Metabox to the Bottom
---------------------------------------*/

/**
 * Change the priority of the Yoast SEO metabox to "low" to move it to the bottom.
 *
 * @return string The priority level for the Yoast SEO metabox.
 */
function yoasttobottom() {
    return 'low'; // Set Yoast metabox priority to 'low' to display it at the bottom.
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom' );


/**
 * Allow additional MIME types for file uploads.
 *
 * Adds support for SVG, JSON, AVIF, and WebP files.
 *
 * @param array $mimes Existing list of allowed MIME types.
 * @return array Modified list of allowed MIME types.
 */
function allow_custom_upload_types( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['json'] = 'application/json';

    return $mimes;
}
add_filter( 'upload_mimes', 'allow_custom_upload_types' );

/**
 * Fix MIME type check for SVG files (bypass "not allowed" error).
 */
function fix_svg_filetype_check($data, $file, $filename, $mimes)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (strtolower($ext) === 'svg') {
        $data['type'] = 'image/svg+xml';
        $data['ext']  = 'svg';
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'fix_svg_filetype_check', 10, 4);

/**
 * Theme support and editor styles setup.
 */
function mytheme_gutenberg_setup() {
    // Enable editor styles support
    add_theme_support( 'editor-styles' );

    // Load the editor stylesheet
    add_editor_style( 'includes/gutenberg/style-editor.css' );
}
add_action( 'after_setup_theme', 'mytheme_gutenberg_setup' );

/**
 * Enqueue custom JS and CSS for the Gutenberg editor.
 */
function mytheme_enqueue_block_editor_assets() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // JS
    wp_enqueue_script(
        'mytheme-gutenberg-js',
        $theme_uri . '/includes/gutenberg/script-editor.js',
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( $theme_dir . '/includes/gutenberg/script-editor.js' ),
        true
    );

    // CSS
    wp_enqueue_style(
        'mytheme-gutenberg-css',
        $theme_uri . '/includes/gutenberg/style-editor.css',
        array(),
        filemtime( $theme_dir . '/includes/gutenberg/style-editor.css' )
    );
}
add_action( 'enqueue_block_editor_assets', 'mytheme_enqueue_block_editor_assets' );

/**
 * Trigger custom validation on ACF save post.
 */
add_action( 'acf/validate_save_post', 'my_custom_acf_validate_all', 5 );

function my_custom_acf_validate_all() {
    if ( empty( $_POST['acf'] ) ) {
        return;
    }

    // Manually validate all ACF values (not usually needed)
    acf_validate_values( $_POST['acf'], 'acf' );
}

/**
 * Rename the default 'category' taxonomy to 'Asset Types'.
 */
function modify_category_labels() {
    global $wp_taxonomies;

    if ( isset( $wp_taxonomies['category'] ) ) {
        $wp_taxonomies['category']->labels = (object) array(
            'name'                       => __( 'Asset Types', THEME_PREFIX ),
            'singular_name'              => __( 'Asset Type', THEME_PREFIX ),
            'search_items'               => __( 'Search Asset Types', THEME_PREFIX ),
            'all_items'                  => __( 'All Asset Types', THEME_PREFIX ),
            'parent_item'                => __( 'Parent Asset Type', THEME_PREFIX ),
            'parent_item_colon'          => __( 'Parent Asset Type:', THEME_PREFIX ),
            'edit_item'                  => __( 'Edit Asset Type', THEME_PREFIX ),
            'update_item'                => __( 'Update Asset Type', THEME_PREFIX ),
            'add_new_item'               => __( 'Add New Asset Type', THEME_PREFIX ),
            'new_item_name'              => __( 'New Asset Type Name', THEME_PREFIX ),
            'menu_name'                  => __( 'Asset Types', THEME_PREFIX ),
            'view_item'                  => __( 'View Asset Type', THEME_PREFIX ),
            'popular_items'              => __( 'Popular Asset Types', THEME_PREFIX ),
            'separate_items_with_commas' => __( 'Separate asset types with commas', THEME_PREFIX ),
            'add_or_remove_items'        => __( 'Add or remove asset types', THEME_PREFIX ),
            'choose_from_most_used'      => __( 'Choose from the most used asset types', THEME_PREFIX ),
            'not_found'                  => __( 'No asset types found', THEME_PREFIX ),
            'no_terms'                   => __( 'No asset types', THEME_PREFIX ),
            'items_list_navigation'      => __( 'Asset Types list navigation', THEME_PREFIX ),
            'items_list'                 => __( 'Asset Types list', THEME_PREFIX ),
            'most_used'                  => __( 'Most Used', THEME_PREFIX ),
            'back_to_items'              => __( '← Back to Asset Types', THEME_PREFIX ),
            'filter_by_item'             => __( 'Filter by Asset Type', THEME_PREFIX ),
        );
    }
}
add_action( 'init', 'modify_category_labels' );

/**
 * Customize login logo.
 */
function my_login_logo() {
	if ( function_exists( 'get_field' ) ) {
		$admin_logo = get_field( 'brand_logo', 'option' );
		if ( ! empty( $admin_logo ) ) {
			echo '<style type="text/css">
				#login h1 a,
				.login h1 a {
					width: 50%;
					background-image: url(' . esc_url( $admin_logo['url'] ) . ');
					background-size: contain;
					background-repeat: no-repeat;
					background-position: bottom center;
				}
			</style>';
		}
	}
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * Set login logo URL to site URL.
 *
 * @param string $url The login header URL.
 * @return string
 */
function custom_loginlogo_url( $url ) {
	return site_url();
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );

/**
 * Replace WordPress logo in admin bar.
 */
function wpb_custom_logo() {
	$icon_url = get_site_icon_url();
	if ( $icon_url ) {
		echo '<style type="text/css">
			#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
				background-image: url(' . esc_url( $icon_url ) . ') !important;
				background-position: 0 0;
				background-size: contain;
				color: rgba(0, 0, 0, 0);
			}
			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
				background-position: 0 0;
			}
			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item {
				pointer-events: none;
			}
			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-sub-wrapper {
				display: none;
			}
		</style>';
	}
}
add_action( 'wp_before_admin_bar_render', 'wpb_custom_logo' );

/**
 * Register a custom top-level admin menu page.
 */
function register_my_custom_menu_page() {
	add_menu_page(
		__( 'Custom Menu Page Title', 'textdomain' ),
		__( 'Brand Icon', 'textdomain' ),
		'manage_options',
		'logo_based_menu',
		'',
		'',
		1
	);
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );

/**
 * Style the custom admin menu with logo.
 */
function admin_logo_style() {
	if ( function_exists( 'get_field' ) ) {
		$dash_logo = get_field( 'footer_logo', 'option' );
		$dash_logo = $dash_logo ? $dash_logo : get_field( 'brand_logo', 'option' );

		if ( ! empty( $dash_logo ) ) {
			echo '<style>
				#toplevel_page_logo_based_menu {
					background: url(' . esc_url( $dash_logo['url'] ) . ') no-repeat center/contain;
					margin: 10px 0 !important;
					pointer-events: none;
					transform: scale(0.9);
				}
				#toplevel_page_logo_based_menu > a,
				#toplevel_page_logo_based_menu > a > div.wp-menu-image,
				#toplevel_page_logo_based_menu .wp-menu-name {
					display: none;
				}
			</style>';
		}
	}
}
add_action( 'admin_enqueue_scripts', 'admin_logo_style' );
