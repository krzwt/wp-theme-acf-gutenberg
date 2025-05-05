<?php
$upload_svgs_icons = get_field( 'upload_svgs_icons', 'option' );

// Check if there are rows of data in the ACF repeater field.
if ( have_rows( 'upload_svgs_icons', 'option' ) ) :
	?>
	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<?php
		// Loop through the rows of data.
		while ( have_rows( 'upload_svgs_icons', 'option' ) ) :
			the_row();

			// Get the unique ID, SVG image, and remove_fill field.
			$svg_unique_id     = get_sub_field( 'svg_unique_id' );
			$svg_image         = get_sub_field( 'svg_image' );
			$svg_remove_fill   = get_sub_field( 'svg_remove_fill' ); // New field for conditional fill removal.
			$svg_unique_id_obj = get_sub_field_object( 'svg_unique_id' );

			if ( $svg_image && pathinfo( $svg_image['url'], PATHINFO_EXTENSION ) === 'svg' ) {

				// Fetch the SVG content.
				$filedir     = get_attached_file( $svg_image['ID'] );
				$svg_content = file_get_contents( $filedir ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

				// Extract the viewBox from the SVG content.
				$view_box = get_svg_viewbox( $svg_content );

				// Clean the SVG content, pass the $svg_remove_fill condition.
				$cleaned_svg_content = clean_svg_content( $svg_content, $svg_remove_fill );

				// Output the symbol element with the extracted viewBox.
				echo '<symbol id="' . esc_attr( $svg_unique_id_obj['prepend'] . $svg_unique_id ) . '" viewBox="' . esc_attr( $view_box ) . '">';
				echo $cleaned_svg_content; // Already sanitized SVG content.
				echo '</symbol>';
			}
		endwhile;
		?>
	</svg>
<?php endif; ?>

<?php
/**
 * Function to clean the SVG content and remove the <svg> tag, conditionally remove 'fill' attributes.
 *
 * @param string $svg             The raw SVG string.
 * @param bool   $svg_remove_fill Whether to remove fill attributes.
 * @return string Cleaned SVG content.
 */
function clean_svg_content( $svg, $svg_remove_fill ) {
	// Remove the <svg> opening and closing tags.
	$svg = preg_replace( '/<svg[^>]*>|<\/svg>/', '', $svg );

	// Conditionally remove the 'fill' attribute from tags if $svg_remove_fill is true.
	if ( $svg_remove_fill ) {
		$svg = preg_replace( '/fill="[^"]*"/', '', $svg );
	}

	return trim( $svg );
}

/**
 * Function to extract the viewBox attribute from the SVG content.
 *
 * @param string $svg_content The raw SVG content.
 * @return string ViewBox value.
 */
function get_svg_viewbox( $svg_content ) {
	preg_match( '/viewBox="([^"]+)"/', $svg_content, $matches );

	return isset( $matches[1] ) ? $matches[1] : '0 0 24 24';
}
