<?php
/**
 * The template for displaying search results pages
 *
 * @since 1.0.0
 */
get_header();
echo '<main class="main-content">';
	$content = apply_filters('the_content', $post->post_content);
	if( $content ):
		the_content();
	endif;
echo '</main>';
get_footer();
?>