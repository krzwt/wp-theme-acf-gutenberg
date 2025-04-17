<?php
/**
* The template for displaying the footer
*/
    echo '<!-- footer part -->
        <footer class="main-footer">
            <div class="container">
            Footer
            </div>
        </footer>
    </div>';
    if ( file_exists( get_template_directory() . '/includes/svg-icons.php' ) ) {
        locate_template( 'includes/svg-icons.php', true, false );
    }
    echo get_field( 'add_code_in_footer', 'options' );
    wp_footer();
echo '</body>
</html>';
