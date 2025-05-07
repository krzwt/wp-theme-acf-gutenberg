<?php

/**
 * The template for displaying all single posts
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
        if (have_posts()) :
            while (have_posts()) :
                the_post();

                the_content(sprintf(wp_kses(/* translators: %s: Name of current post. Only visible to screen readers */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'textdomain' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ), wp_kses_post(get_the_title())));
            endwhile; // End of the loop.
        endif;
        ?>

  </main><!-- #main -->

<?php
get_footer();
