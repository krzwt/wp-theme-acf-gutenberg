<?php
/**
 * Default page tmeplate.
 */
if (!defined('ABSPATH') || !function_exists('add_filter')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}
get_header();
echo '<main class="main-content">';
	$content = apply_filters('the_content', $post->post_content);
	if( $content ):
		the_content();
	endif;
echo '</main>';
get_footer();