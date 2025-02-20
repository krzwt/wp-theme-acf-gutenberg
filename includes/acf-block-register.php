<?php
/**
 * Register the ACF Block and sort blocks alphabetically.
 */
if (function_exists('acf_register_block')) {
    add_action('acf/init', 'block_acf_init');
    add_filter('block_categories_all', 'add_custom_block_category', 10, 2);
    add_filter('block_editor_settings_all', 'sort_blocks_alphabetically', 10, 2);
}

/**
 * Add custom block category in second position.
 */
function add_custom_block_category($categories, $post) {
    // Define the custom category
    $custom_category = array(
        'slug'  => 'custom-blocks',
        'title' => __('Custom Blocks', 'cbiz-wp'),
    );

    // Insert the custom category after the first existing category
    array_splice($categories, 1, 0, array($custom_category));

    // Sort categories alphabetically by title
    usort($categories, function($a, $b) {
        return strcmp($a['title'], $b['title']);
    });

    return $categories;
}

/**
 * Sort blocks alphabetically within the block inserter.
 */
function sort_blocks_alphabetically($editor_settings, $post) {
    // Check if blocks are set
    if (isset($editor_settings['allowedBlockTypes']) && is_array($editor_settings['allowedBlockTypes'])) {
        // Sort blocks alphabetically by their titles
        usort($editor_settings['allowedBlockTypes'], function($a, $b) {
            if (isset($a['title']) && isset($b['title'])) {
                return strcmp($a['title'], $b['title']);
            }
            return 0;
        });
    }

    return $editor_settings;
}

/**
 * Register custom ACF block.
 */
function block_acf_init() {
    $theme = wp_get_theme();
    $theme_version = $theme->get( 'Version' );
    $separate_folder = get_template_directory_uri() . '/assets/js/separate/'; // Corrected the typo
    // Define blocks
    $blocks = array(

        // WYSIWYG
        array(
            'name'              => 'wysiwyg',
            'title'             => __( 'WYSIWYG', 'custom-wp'),
            'render_template'   => get_theme_file_path('/template-part/blocks/wysiwyg.php'),
            'category'          => 'custom-blocks',
            'keywords'          => array('wysiwyg', 'content'),
            'icon'              => 'welcome-add-page',
            'mode'              => 'edit',
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview', // Ensure the mode is set to preview
                ),
            ),
            'enqueue_assets' => function() use ( $theme_version, $separate_folder ){ // Used corrected variable
                // wp_enqueue_script( 'wysiwyg',  $separate_folder . 'wysiwyg.js', array('jquery'), $theme_version, true );
            },
        ),

    );

    // Sort blocks alphabetically by title before registering
    usort($blocks, function($a, $b) {
        return strcmp($a['title'], $b['title']);
    });

    // Register sorted blocks
    foreach ($blocks as $block) {
        acf_register_block($block);
    }
}

?>
