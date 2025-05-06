<?php
$upload_svgs_icons = get_field( 'upload_svgs_icons', 'option' );

// Ensure there are rows of data.
if ( $upload_svgs_icons ) {
	echo '<div class="svg-icons-list">';
        echo '<h2>Site Icons</h2>';
        echo '<ul class="icon-grid">';

        // Loop through the rows of data.
        while ( have_rows( 'upload_svgs_icons', 'option' ) ) :
            the_row();

            $svg_unique_id       = get_sub_field( 'svg_unique_id' );
            $svg_unique_id_field = get_sub_field_object( 'svg_unique_id' );

            if ( $svg_unique_id && $svg_unique_id_field ) {
                echo '<li>';
                echo '<strong class="svg-icon-name">' . esc_attr( $svg_unique_id_field['prepend'] . $svg_unique_id ) . ' </strong>';
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
<script>
// Copy SVG code on click
document.querySelectorAll('.svg-icons-list ul li svg').forEach(svgIcon => {
    svgIcon.addEventListener('click', function (event) {
        const svgOuterHTML = svgIcon.outerHTML;

        // Copy the SVG code
        const textarea = document.createElement('textarea');
        textarea.value = svgOuterHTML;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        // Show the copy message near the cursor
        showCopyMessage(event.pageX, event.pageY);
    });
});

function showCopyMessage(x, y) {
    // Create the message dynamically
    const message = document.createElement('div');
    message.textContent = 'Copied!';
    message.style.position = 'absolute';
    message.style.backgroundColor = '#333';
    message.style.color = 'white';
    message.style.padding = '5px 10px';
    message.style.borderRadius = '5px';
    message.style.fontSize = '12px';
    message.style.left = `${x + 10}px`; // Offset by 10px from cursor
    message.style.top = `${y + 10}px`; // Offset by 10px from cursor
    message.style.zIndex = '1000';
    message.style.pointerEvents = 'none'; // Make sure it doesn't interfere with other interactions

    // Add the message to the document
    document.body.appendChild(message);

    // Remove the message after 1.5 seconds
    setTimeout(() => {
        message.remove();
    }, 1500);
}
</script>