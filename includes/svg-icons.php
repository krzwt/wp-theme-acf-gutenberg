<?php
$upload_svgs_icons = get_field('upload_svgs_icons', 'option');

// Check if there are rows of data in the ACF repeater field
if ( have_rows('upload_svgs_icons', 'option') ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <?php
        // Loop through the rows of data
        while( have_rows('upload_svgs_icons', 'option') ) : the_row();

            // Get the unique ID, SVG image, and remove_fill field
            $svg_unique_id = get_sub_field('svg_unique_id');
            $svg_image = get_sub_field('svg_image');
            $svg_remove_fill = get_sub_field('svg_remove_fill'); // New field for conditional fill removal
            // Get the field object for 'svg_unique_id' (use the actual field name/key, not the value)
            $svg_unique_id_field = get_sub_field_object('svg_unique_id');

            if ($svg_image && pathinfo($svg_image['url'], PATHINFO_EXTENSION) === 'svg') {

                // Fetch the SVG content
                $filedir = get_attached_file( $svg_image['ID'] );
                $svg_content = file_get_contents($filedir);

                // Extract the viewBox from the SVG content
                $viewBox = get_svg_viewBox($svg_content);

                // Clean the SVG content, pass the $svg_remove_fill condition
                $cleaned_svg_content = clean_svg_content($svg_content, $svg_remove_fill);

                // Output the symbol element with the extracted viewBox
                echo '<symbol id="'.$svg_unique_id_field['prepend'].'' . esc_attr($svg_unique_id) . '" viewBox="' . esc_attr($viewBox) . '">';
                echo $cleaned_svg_content; // Output cleaned SVG content
                echo '</symbol>';
            }

        endwhile; ?>
    </svg>
<?php endif; ?>

<?php
// Function to clean the SVG content and remove the <svg> tag, conditionally remove 'fill' attributes
function clean_svg_content($svg, $svg_remove_fill) {
    // Remove the <svg> opening and closing tags
    $svg = preg_replace('/<svg[^>]*>|<\/svg>/', '', $svg);

    // Conditionally remove the 'fill' attribute from <path> tags if $svg_remove_fill is true
    if ($svg_remove_fill) {
        $svg = preg_replace('/fill="[^"]*"/', '', $svg);
    }

    // Return the cleaned SVG content without the <svg> tag
    return trim($svg);
}

// Function to extract the viewBox attribute from the SVG content
function get_svg_viewBox($svg_content) {
    // Use regular expression to extract the viewBox attribute
    preg_match('/viewBox="([^"]+)"/', $svg_content, $matches);

    // Return the viewBox value if found, or a default value of '0 0 24 24'
    return isset($matches[1]) ? $matches[1] : '0 0 24 24';
}
?>
