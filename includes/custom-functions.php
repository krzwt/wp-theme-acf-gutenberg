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
/* <ACF Link> */
function acf_link ( $link, $link_class = '' ) {
	if( $link ):
		$link_url = $link['url'];
		$link_title = $link['title'];
		$link_target = $link['target'] ? $link['target'] : '_self';
		$link_class = $link_class ? $link_class : 'btn';
		return '<a class="'.$link_class.'" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.esc_html( $link_title ).'</a>';
	endif;
	// echo acf_link($link);
}
/* </ACF Link> */

/* <ACF Image> */
function acf_img ( $img, $img_class = '', $loading = 'lazy' ) {
	if( $img ):
		$img_url = $img['url'];
		$img_alt = $img['alt'] ? $img['alt'] : $img['title'];
		$img_class = $img_class ? $img_class : '';
		$img_width =  $img['width'] != 1 ? ' width="'. $img['width'].'"' : '';
		$img_height =  $img['height'] != 1 ?  ' height="'.$img['height'].'"' : '';
		$loading = $loading ? ' loading="'.esc_attr($loading).'"' : '';

		return '<img class="'.$img_class.'" src="'.esc_url( $img_url ).'" alt="'.esc_attr( $img_alt ).'"'. $img_width . $img_height . $loading .'>';
	endif;
	// echo acf_img($img, 'custom-class', 'eager'); // Adds eager loading
	// echo acf_img($img, 'custom-class'); // Defaults to lazy loading
}
/* </ACF Image> */

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

// Print code
function printr($code){
	echo '<pre>';
	print_r($code);
	echo '</pre>';
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