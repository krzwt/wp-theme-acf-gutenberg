<?php
/**
 * Template Name: Front Page
 */

get_header();
echo '<main class="main-content">';
echo '<!-- banner area part -->
    <section class="hero-section">';
    echo '</section>';

echo '<!-- content area part -->';
	$content = apply_filters('the_content', $post->post_content);
	if( $content ):
		the_content();
	endif;
echo '</main>';

get_footer();
