<?php

/**
 * The template for displaying all pages
 *
 * @package ThemeName
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

get_header();
?>

<main class="main-content">

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	endif;
	?>

</main><!-- main -->


<?php
get_footer();
