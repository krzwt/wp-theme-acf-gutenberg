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
    echo get_field( 'add_code_in_footer', 'options' );
    wp_footer();
echo '</body>
</html>';
