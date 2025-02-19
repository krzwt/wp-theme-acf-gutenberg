<?php
/**
* Load the custom functions.
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
/**
 * Upload SVG file permission
 */
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

/**
 * Add excerpt support to pages
 */
add_action('init', 'wp_admin_excerpt_init');

function wp_admin_excerpt_init() {
    add_post_type_support( 'page', 'excerpt' );
}

/**
 * Add quick-collapse feature to ACF Flexible Content fields
 */
add_action('acf/input/admin_head', function() { ?>
    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                var collapseButtonClass = 'collapse-all';

                // Add a clickable link to the label line of flexible content fields
                $('.acf-field-flexible-content > .acf-label')
                    .append('<a class=" button ' + collapseButtonClass + '" style="position: absolute; top: 0; right: 0; cursor: pointer;">Collapse All</a>');

                // Simulate a click on each flexible content item's "collapse" button when clicking the new link
                $('.' + collapseButtonClass).on('click', function() {
                    $('.acf-flexible-content .layout:not(.-collapsed) .acf-fc-layout-controls .-collapse').click();
                });
            });
        })(jQuery);
    </script> <?php
});
add_action('admin_head', 'acf_collapse_css');

function acf_collapse_css() {
echo '<style>
	.acf-field-flexible-content .acf-label {
		padding-bottom: 10px;
	}
	</style>';
}

// Enqueue Gutenberg CSS and JS
add_action('after_setup_theme', 'gutenberg_assets');

function gutenberg_assets() {
    // Support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('gutenberg/style-editor.css');

    // Enqueue Gutenberg JavaScript
    add_action('enqueue_block_editor_assets', 'enqueue_gutenberg_js');
}

function enqueue_gutenberg_js() {
    wp_enqueue_script(
        'gutenberg-custom-js', // Handle
        get_template_directory_uri() . '/gutenberg/script-editor.js', // Path to the script-editor.js file
        array('wp-blocks', 'wp-element', 'wp-editor'), // Dependencies, if any
        filemtime(get_template_directory() . '/gutenberg/script-editor.js'), // Version: Uses file modification time
        true // Enqueue in the footer
    );

    // Enqueue Gutenberg CSS
    wp_enqueue_style(
        'gutenberg-custom-css', // Handle
        get_template_directory_uri() . '/gutenberg/style-editor.css', // Path to the style-editor.css file
        array(), // Dependencies, if any
        filemtime(get_template_directory() . '/gutenberg/style-editor.css') // Version: Uses file modification time
    );
}

// Hook into the ACF validation save post action
add_action('acf/validate_save_post', '_validate_save_post', 5);

function _validate_save_post() {
    // Check if the $_POST array is empty and exit early if true
    if (empty($_POST)) {
        return;
    }

    // Iterate over each item in the $_POST array
    foreach ($_POST as $key => $value) {
        // Check if the key starts with 'acf'
        if (strpos($key, 'acf') === 0) {
            // If the key corresponds to an ACF field and is not empty, validate its values
            if (!empty($_POST[$key])) {
                acf_validate_values($_POST[$key], $key);
            }
        }
    }
}

function modify_category_labels() {
    global $wp_taxonomies;

    // Check if the 'category' taxonomy exists
    if ( isset( $wp_taxonomies['category'] ) ) {
        $wp_taxonomies['category']->labels = (object) array(
            'name'                       => 'Asset Types', // Plural name
            'singular_name'              => 'Asset Type',  // Singular name
            'search_items'               => 'Search Asset Types',
            'all_items'                  => 'All Asset Types',
            'parent_item'                => 'Parent Asset Type',
            'parent_item_colon'          => 'Parent Asset Type:',
            'edit_item'                  => 'Edit Asset Type',
            'update_item'                => 'Update Asset Type',
            'add_new_item'               => 'Add New Asset Type',
            'new_item_name'              => 'New Asset Type Name',
            'menu_name'                  => 'Asset Types',
            'view_item'                  => 'View Asset Type',
            'popular_items'              => 'Popular Asset Types',
            'separate_items_with_commas' => 'Separate asset types with commas',
            'add_or_remove_items'        => 'Add or remove asset types',
            'choose_from_most_used'      => 'Choose from the most used asset types',
            'not_found'                  => 'No asset types found',
            'no_terms'                   => 'No asset types',
            'items_list_navigation'      => 'Asset Types list navigation',
            'items_list'                 => 'Asset Types list',
            'most_used'                  => 'Most Used',
            'back_to_items'              => '← Back to Asset Types',
            'filter_by_item'             => 'Filter by Asset Type', // Prevents the notice
        );
    }
}
add_action( 'init', 'modify_category_labels' );


/** 
 * Admin logo 
*/
function my_login_logo() {
	$admin_logo = get_field ( "brand_logo","option");
	if ( !empty( $admin_logo ) ) {
		echo '<style type="text/css">
			#login h1 a,
			.login h1 a {
				width: 50%;
				background-image: url('.$admin_logo['url'].');
				background-size: contain;
				background-repeat: no-repeat;
				background-position: bottom center;
			}
		</style>';
	}
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/**
 * Admin logo URL
*/
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url( $url ) {
	return site_url();
}

/**
 * Admin logo
*/
function wpb_custom_logo() {
	if ( get_site_icon_url() != '') {
		echo '<style type="text/css">
			#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
				background-image: url(' . get_site_icon_url() . ') !important;
				background-position: 0 0;
				background-size: contain;
				color:rgba(0, 0, 0, 0);
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
add_action('wp_before_admin_bar_render', 'wpb_custom_logo');

/**
 * Admin menu
*/
add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page() {
    add_menu_page( 'Custom Menu Page Title', 'Brand icon', 'manage_options', 'logo_based_menu', '', '', 1);
}

/**
 * Admin menu logo
*/
function admin_logo_style() {
	$dash_logo = get_field ( "brand_logo","option");
	if ( !empty( $dash_logo ) ) {
		echo '<style>
			#toplevel_page_logo_based_menu {
				background: url('.$dash_logo['url'].') no-repeat center/contain;
				margin:10px 0 !important;
                pointer-events:none;
			}
			#toplevel_page_logo_based_menu > a,
            #toplevel_page_logo_based_menu > a > div.wp-menu-image,
            #toplevel_page_logo_based_menu .wp-menu-name {display: none;}
		</style>';
	}
}
add_action('admin_enqueue_scripts', 'admin_logo_style');

// Remove unwanted assets
function remove_unwanted_assets() {
    // Define an array of unwanted script handles
    $scripts_to_remove = array(
        // 'powertip',
        // 'maps-points',
    );

    // Dequeue scripts
    foreach ($scripts_to_remove as $script) {
        wp_dequeue_script($script);
    }

    // Define an array of unwanted style handles
    $styles_to_remove = array(
        // 'powertip',
        // 'maps-points',
    );

    // Dequeue styles
    foreach ($styles_to_remove as $style) {
        wp_dequeue_style($style);
    }
}
// add_action('wp_enqueue_scripts', 'remove_unwanted_assets');