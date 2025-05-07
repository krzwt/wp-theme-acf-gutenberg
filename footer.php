<?php

/**
 * The template for displaying site footer
 *
 * @package ThemeName
 */

?>
        <footer class="main-footer">
            <h2>Footer goes here...</h2>
        </footer>

    </div>
    <?php
        if ( file_exists( get_template_directory() . '/includes/svg-icons.php' ) ) {
            locate_template( 'includes/svg-icons.php', true, false );
        }
    ?>
    <?php echo get_field( 'add_code_in_footer', 'options' ); ?>
    <?php wp_footer(); ?>

</body>
</html>
