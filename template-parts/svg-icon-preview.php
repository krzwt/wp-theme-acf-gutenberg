<?php
$upload_svgs_icons = get_field( 'upload_svgs_icons', 'option' );

// Ensure there are rows of data.
if ( $upload_svgs_icons ) {
	echo '<div class="svg-icons-list">';
        echo '<h2>' . esc_html__( 'Site Icons', 'your-textdomain' ) . '</h2>';
        echo '<ul class="icon-grid">';

        // Loop through the rows of data.
        while ( have_rows( 'upload_svgs_icons', 'option' ) ) :
            the_row();

            $svg_unique_id       = get_sub_field( 'svg_unique_id' );
            $svg_unique_id_field = get_sub_field_object( 'svg_unique_id' );

            if ( $svg_unique_id && $svg_unique_id_field ) {
                echo '<li>';
                echo '<svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">';
                echo '<use xlink:href="#' . esc_attr( $svg_unique_id_field['prepend'] . $svg_unique_id ) . '"></use>';
                echo '</svg>';
                echo '</li>';
            }
        endwhile;

        echo '</ul>';
	echo '</div>';
}
?>
