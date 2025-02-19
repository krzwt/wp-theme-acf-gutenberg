<?php
/**
 * Template Name: Front Page
 */

get_header();
echo '<!-- Main area part -->';
echo '<main class="main-content">';
	echo '<!-- Banner area part -->';
    // echo '<section class="hero-section">';
    // echo '</section>';

	echo '<!-- Content area part -->';
	$content = apply_filters('the_content', $post->post_content);
	if( $content ):
		the_content();
	endif;
echo '</main>';

get_footer();
