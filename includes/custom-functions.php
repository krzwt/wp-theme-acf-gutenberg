<?php
/**
* Load the custom functions.
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/* SVG icon function start */
function svg_icon( $wp_icon, $classes="", $width="", $height="" ){
	ob_start();
		$context = stream_context_create(
			array(
				"http" => array(
					"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
				)
			)
		);
		$wp_iconSVG = file_get_contents( $wp_icon , false, $context);
		$dom = new DOMDocument();
		@$dom->loadHTML($wp_iconSVG);
		foreach($dom->getElementsByTagName('svg') as $element) {
			if( !empty( $classes ) ){
				$element->setAttribute('class', $classes );
			}
			if( !empty( $width ) ){
				$element->setAttribute('width', $width );
			}
			if( !empty( $height ) ){
				$element->setAttribute('height', $height );
			}
		}
		$dom->saveHTML();
		$wp_iconSVG = $dom->saveHTML();
		echo $wp_iconSVG;
	return ob_get_clean();
}
/* SVG icon function end */

/**
 * Generate an accessible ACF link with fallback title.
 *
 * @param array  $link        The ACF link array.
 * @param string $link_class  Additional CSS classes for styling.
 * @return string             HTML anchor tag or empty string.
 */
function acf_link($link, $link_class = '')
{
	if (! is_array($link) || empty($link['url'])) {
		return ''; // Return empty string if the link is invalid.
	}

	// Extract link values.
	$link_url    = esc_url($link['url']);
	$link_title  = ! empty($link['title']) ? esc_html($link['title']) : __('Read More', 'text-domain'); // Fallback title.
	$link_target = ! empty($link['target']) ? '_blank' : '_self';
	$rel_attr    = ('_blank' === $link_target) ? 'noopener noreferrer' : 'nofollow';
	$link_class  = esc_attr($link_class ? $link_class : 'btn');

	// Return formatted accessible link.
	return sprintf(
		'<a class="%s" href="%s" target="%s" rel="%s" aria-label="%s">%s</a>',
		$link_class,
		$link_url,
		esc_attr($link_target),
		esc_attr($rel_attr),
		esc_attr($link_title), // `aria-label` improves accessibility.
		$link_title
	);
	/** 
	 * Example Usage 
	 * echo acf_link( $link, 'custom-button' );
	 */
}

/**
 * Optimized function for rendering an ACF image using Image ID.
 *
 * @param int    $image_id   The image attachment ID.
 * @param string $size       Image size ('full', 'medium_large', etc.).
 * @param string $class      Additional CSS classes.
 * @return string            HTML img tag or empty string.
 */
function acf_image($image_id, $size = 'medium_large', $class = '')
{
	if (empty($image_id)) {
		return ''; // Return empty string if image ID is not valid.
	}

	// Get image attributes.
	$image_url  = wp_get_attachment_image_url($image_id, $size);
	$image_alt  = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	$image_alt  = ! empty($image_alt) ? esc_attr($image_alt) : esc_attr(get_the_title()) . ' Image';
	$srcset     = wp_get_attachment_image_srcset($image_id, $size);

	// Return optimized image tag.
	return sprintf(
		'<img src="%s" srcset="%s" alt="%s" class="%s" loading="lazy" decoding="async" width="%s" height="%s">',
		esc_url($image_url),
		esc_attr($srcset),
		$image_alt,
		esc_attr($class),
		esc_attr(wp_get_attachment_metadata($image_id)['width'] ?? ''),
		esc_attr(wp_get_attachment_metadata($image_id)['height'] ?? '')
	);
	/** 
	 * Example Usage
	 * echo acf_image( $image_id, 'full', 'banner-image' );
	 */
}

/* <ACF Image> */
function acf_img( $img, $img_class = '', $loading = 'lazy' ) {
	// Check if the image is valid
	if( $img ):

		// Prepare image attributes
		$img_url = isset($img['url']) ? esc_url( $img['url'] ) : '';
		$img_alt = isset($img['alt']) && !empty($img['alt']) ? esc_attr($img['alt']) : esc_attr($img['title']);
		$img_class = !empty($img_class) ? esc_attr($img_class) : '';
		$img_width = isset($img['width']) && $img['width'] > 1 ? ' width="'. intval($img['width']).'"' : '';
		$img_height = isset($img['height']) && $img['height'] > 1 ? ' height="'. intval($img['height']).'"' : '';
		$loading = !empty($loading) ? ' loading="'.esc_attr($loading).'"' : '';

		// Return the final image HTML
		return '<img class="'.$img_class.'" src="'.$img_url.'" alt="'.$img_alt.'"'. $img_width . $img_height . $loading .'>';
	endif;

	// Return an empty string if no image is provided
	return '';
	// USE
	// echo acf_img($image, 'my-image-class', 'lazy');
}
/* </ACF Image> */

/* <ACF Picture> */
function acf_picture( $images = [], $img_class = '', $loading = 'lazy' ) {
	// Extract desktop and mobile images from the array
	$imgDesktop = isset( $images[0] ) ? $images[0] : null;
	$imgMobile = isset( $images[1] ) ? $images[1] : null;

	if( $imgDesktop ):
		$img_url = $imgDesktop['url'];
		$img_alt = $imgDesktop['alt'] ? $imgDesktop['alt'] : $imgDesktop['title'];
		$img_class = $img_class ? $img_class : '';
		$img_width =  $imgDesktop['width'] != 1 ? ' width="'. $imgDesktop['width'].'"' : '';
		$img_height =  $imgDesktop['height'] != 1 ?  ' height="'.$imgDesktop['height'].'"' : '';
		$loading = $loading ? ' loading="'.esc_attr($loading).'"' : '';

		// Mobile image URL (if provided)
		$imgMobileUrl = $imgMobile ? esc_url( $imgMobile['url'] ) : '';

		// Build the picture tag
		$output = '<picture>';

		// If mobile image exists, set as default for screens below 768px
		if( $imgMobileUrl ) {
			$output .= '<source media="(max-width: 767px)" srcset="'. $imgMobileUrl .'">';
		}

		// Desktop image for screens 768px and above
		$output .= '<source media="(min-width: 768px)" srcset="'. esc_url($img_url) .'">';

		// Fallback img tag for older browsers
		$output .= '<img class="'.$img_class.'" src="'.esc_url( $img_url ).'" alt="'.esc_attr( $img_alt ).'"'. $img_width . $img_height . $loading .'>';

		$output .= '</picture>';

		return $output;
	endif;

	return ''; // Return an empty string if no $imgDesktop is provided
	// Use acf_picture([$imgDesktop, $imgMobile], $img_class, $loading);
}
/* </ACF Picture> */

/* Youtube ID get */
function YouTube_ID($link){
	$arr = parse_url($link);
	if($arr['path'] === "/watch"){
		return str_replace('v=','', preg_replace('#^.*?/([^/]+)$#', '$1', $arr['query']));
	}else{
		return preg_replace('#^.*?/([^/]+)$#', '$1', $arr['path']);
	}
}
/* Vimeo ID get */
function Vimeo_ID($link){
	$varr = parse_url($link);
    return str_replace('video','', preg_replace('#^.*?/([^/]+)$#', '$1', $varr['path']));
}

/**
 * Debug function to print an array/object with optional logging.
 *
 * @param mixed $data  The data to debug.
 * @param bool  $exit  Stop execution after printing (default: false).
 * @param bool  $log   Log to error_log instead of printing (default: false).
 */
function printr($data, $exit = false, $log = false)
{
	if ($log) {
		error_log(print_r($data, true)); // Log to error_log instead of printing.
	} else {
		echo '<pre style="background: #222; color: #0f0; padding: 10px; border-radius: 5px;">';
		print_r($data);
		echo '</pre>';
	}

	if ($exit) {
		exit;
	}
	/**
	 * Example Usage
	 * printr( $my_array ); // Print for debugging.
	 * printr( $my_array, true ); // Print and stop execution.
	 * printr( $my_array, false, true ); // Log to error_log.
	 */
}

function short_string($string, $limit, $display_dot ) {
    // Trim the string to avoid extra spaces
    $string = trim($string);

    // Check if the string is shorter than the limit, return it as is
    if (strlen($string) <= $limit) {
        return $string;
    }

    // Get the substring of the first 50 characters
    $substring = substr($string, 0, $limit);

    // Check if the 50th character is not a space
    if (substr($string, $limit, 1) != ' ') {
        // Move backward to find the last space within the limit
        $substring = substr($substring, 0, strrpos($substring, ' '));
    }
	
	if( $display_dot ) {
		// Append "..." to the substring since the original string is longer than the limit
		return $substring . '...';
	} else {
		return $substring;
	}

}

/**
 * Splits a given statistic string into three parts: prefix, number, and suffix.
 */
function split_statistic($statistic) {
    // Initialize variables for each part
    $prefix = '';    // For any string at the start
    $number = '';    // For the numeric part (with commas and decimals)
    $suffix = '';    // For any string at the end

    // Step 1: Use a regular expression to match the components
    // The regex is designed to match the prefix (non-numeric including spaces), number (with commas/decimals), and suffix (non-numeric including spaces or words like 'B', 'Top', etc.)
    if (preg_match('/^(\s*[^\d,.]*\s*)?([\d,]*\.?\d+)?(\s*[^\d]*[\w+\s]*)?$/', $statistic, $matches)) {
        // $matches[1] -> prefix (if any)
        // $matches[2] -> number (numeric part)
        // $matches[3] -> suffix (if any)

        // Assign the matches to respective variables
        $prefix = isset($matches[1]) ? $matches[1] : ''; // Handle empty prefix
        $number = isset($matches[2]) ? $matches[2] : ''; // Handle empty number
        $suffix = isset($matches[3]) ? $matches[3] : ''; // Handle empty suffix
    }

    // Return the result as an associative array or just individual variables
    return [
        'prefix' => $prefix,
        'number' => $number,
        'suffix' => $suffix
    ];
}