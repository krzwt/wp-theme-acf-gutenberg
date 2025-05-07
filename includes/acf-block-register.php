<?php

/**
 * Register ACF Blocks
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

/**
 * Register the ACF block and sort blocks alphabetically.
 */

if ( function_exists( 'acf_register_block' ) ) {
	add_action( 'acf/init', 'register_acf_blocks' );
	add_filter( 'block_categories_all', 'add_custom_block_category', 10, 2 );
	add_filter( 'block_editor_settings_all', 'sort_blocks_alphabetically', 10, 2 );
}

/**
 * Add custom block category in second position and sort all categories alphabetically.
 *
 * @param array   $categories List of block categories.
 * @param WP_Post $post       Current post object.
 * @return array Sorted categories with custom category added.
 */
function add_custom_block_category( $categories, $post ) {
	$custom_category = array(
		'slug'  => 'custom-blocks',
		'title' => __( 'Custom Blocks', 'textdomain' ),
	);

	// Insert custom category after the first existing category.
	array_splice( $categories, 1, 0, array( $custom_category ) );

	// Sort categories alphabetically by title.
	usort(
		$categories,
		function ( $a, $b ) {
			return strcmp( $a['title'], $b['title'] );
		}
	);

	return $categories;
}

/**
 * Sort blocks alphabetically within the block inserter.
 *
 * @param array   $editor_settings Editor settings.
 * @param WP_Post $post            Current post object.
 * @return array Modified editor settings.
 */
function sort_blocks_alphabetically( $editor_settings, $post ) {
	if ( isset( $editor_settings['allowedBlockTypes'] ) && is_array( $editor_settings['allowedBlockTypes'] ) ) {
		usort(
			$editor_settings['allowedBlockTypes'],
			function ( $a, $b ) {
				if ( isset( $a['title'], $b['title'] ) ) {
					return strcmp( $a['title'], $b['title'] );
				}
				return 0;
			}
		);
	}

	return $editor_settings;
}

function register_acf_blocks()
{
    $separate_folder = get_template_directory_uri() . '/assets/js/modules/'; // Corrected the typo
    if (function_exists('acf_register_block_type')) {
        $theme = wp_get_theme();
        $theme_version = $theme->get( 'Version' );

        /** Registered Custom Block
         * used on home page
         * displaying custom elements
         */
        acf_register_block_type(array(
            'name'              => 'wysiwyg',
            'title'             => __('WYSIWYG','textdomain'),
            'description'       => __('A dynamically rendered ACF block.','textdomain'),
            'render_callback'   => 'theme_acf_block_render_callback',
            'category'          => 'custom-blocks',
            'icon'              => 'admin-comments',
            'keywords'          => array('wysiwyg', 'text', 'editor'),
            'supports'          => array(
                'align' => true
            ),
            'mode'              => 'edit',
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview', // Ensure the mode is set to preview
                    'data' => array(
                        'preview_image' => get_template_directory_uri() . '/includes/acf-block-preview/wysiwyg.avif',
                    ),
                ),
            ),
            'enqueue_assets' => function() use ( $theme_version, $separate_folder ){ // Used corrected variable
                // wp_enqueue_script( 'wysiwyg',  $separate_folder . 'wysiwyg.js', array('jquery'), $theme_version, true );
            },
        ));
    }
}
add_action('acf/init', 'register_acf_blocks');

/**
 * ACF Block Render Callback function
 */
function theme_acf_block_render_callback($block)
{
    // Get block name without "acf/" prefix
    $block_name = str_replace('acf/', '', $block['name']);

    // Construct template path
    $template_path = get_theme_file_path("/template-parts/blocks/{$block_name}.php");

    // Check if the template exists
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        echo '<p>Template file for "' . esc_html($block_name) . '" not found.</p>';
    }
}
