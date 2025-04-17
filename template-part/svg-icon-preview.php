<?php
$upload_svgs_icons = get_field('upload_svgs_icons', 'option');

// Ensure there are rows of data
if ($upload_svgs_icons) {
    echo '<div class="svg-icons-list">';
        echo '<h2>Site Icons</h2>';
        echo '<ul style="
        display: grid;
        grid-template-columns: repeat(8,auto);
        list-style: none;
        padding-left: 0;">';
        // Loop through the rows of data
        while (have_rows('upload_svgs_icons', 'option')) : the_row();
            $svg_unique_id = get_sub_field('svg_unique_id'); // Get unique ID
            $svg_unique_id_field = get_sub_field_object('svg_unique_id'); // Get field object for prefix/prepend

            // Ensure $svg_unique_id exists
            if ($svg_unique_id && $svg_unique_id_field) {
                echo '<li>';
                echo '<svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentcolor">';
                echo '<use xlink:href="#' . esc_attr($svg_unique_id_field['prepend']) . esc_attr($svg_unique_id) . '"></use>';
                echo '</svg>';
                echo '</li>';
            }

        endwhile;

        echo '</ul>';
    echo '</div>';
}
?>