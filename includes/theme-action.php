<?php

/**
 * Load the theme actions.
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

/**
 * Removes unnecessary emoji scripts
 */
function disable_wp_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'disable_wp_emojis');

// Register AJAX actions for logged-in and non-logged-in users
add_action('wp_ajax_mytheme_ajaxsearch_filter', 'mytheme_ajaxsearch_filter');
add_action('wp_ajax_nopriv_mytheme_ajaxsearch_filter', 'mytheme_ajaxsearch_filter');

/**
 * AJAX Callback Function: Fetch and Filter Posts
 */
function mytheme_ajaxsearch_filter()
{
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
        wp_send_json_error('Security check failed!');
    }

    // Sanitize input values
    $postcategory = isset($_POST['postcategory']) ? sanitize_text_field($_POST['postcategory']) : '';
    $paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $posts_per_page = get_option('posts_per_page'); // Retrieve posts per page from WordPress settings

    // Define query arguments
    $ajax_query_args = array(
        'post_type'      => 'post', // Fetch only posts
        'order'          => 'DESC', // Show newest posts first
        'posts_per_page' => $posts_per_page, // Apply posts per page setting
        'paged'          => $paged, // Use pagination
    );

    // Filter posts by category if a category is selected
    if (!empty($postcategory)) {
        $ajax_query_args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $postcategory,
                'operator' => 'IN'
            )
        );
    }

    // Fetch posts using WP_Query
    $loop = new WP_Query($ajax_query_args);
    $loop_output = ''; // Initialize output variable

    // Check if posts exist
    if ($loop->have_posts()) {
        while ($loop->have_posts()) :
            $loop->the_post();
            // Generate post HTML structure
            $loop_output .= '
            <article>
                <h2><a href="' . esc_url(get_the_permalink()) . '">' . esc_html(get_the_title()) . '</a></h2>
                <p>' . esc_html__(get_the_excerpt(), THEME_PREFIX) . '</p>
            </article>';
        endwhile;

        // Generate pagination links
        $loop_output .= "<div class='pagination'>";

        $big = 999999999; // Unlikely integer for pagination replacement
        $pagination = paginate_links(array(
            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'    => '?paged=%#%',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $loop->max_num_pages,
            'mid_size'  => 2,
            'end_size'  => 1,
            'prev_next' => false,
            'type'      => 'array'
        ));

        if (! empty($pagination) && is_array($pagination)) {
            $loop_output .= implode('', $pagination);
        }

        $loop_output .= "</div>";
    } else {
        $loop_output .= '<p>' . esc_html__('No posts found.', THEME_PREFIX) . '</p>';
    }

    // Output the generated content
    echo $loop_output;

    // Reset post data to prevent conflicts
    wp_reset_postdata();

    // Terminate AJAX execution
    wp_die();
}
