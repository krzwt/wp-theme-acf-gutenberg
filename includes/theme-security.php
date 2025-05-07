<?php
/**
 * Restrict REST API access to logged-in users only.
 *
 * Prevents unauthenticated users from accessing the REST API by
 * returning a 403 error when they are not logged in.
 *
 * @param mixed $result Current REST authentication result.
 * @return mixed|WP_Error Modified result or error object.
 */
add_filter( 'rest_authentication_errors', function( $result ) {
	if ( ! is_user_logged_in() ) {
		return new WP_Error(
			'rest_disabled',
			__( 'REST API restricted.', 'textdomain' ),
			array( 'status' => 403 )
		);
	}

	return $result;
} );

/**
 * Restrict access to the `/wp/v2/users` REST API endpoint for non-logged-in users.
 *
 * Removes the users endpoint from the REST API for unauthenticated requests
 * to enhance privacy and security.
 *
 * @param array $endpoints Array of available REST API endpoints.
 * @return array Modified endpoints array.
 */
add_filter( 'rest_endpoints', function( $endpoints ) {
	if ( ! is_user_logged_in() && isset( $endpoints['/wp/v2/users'] ) ) {
		unset( $endpoints['/wp/v2/users'] );
	}

	return $endpoints;
} );

/**
 * Redirect users away from author archive pages.
 *
 * This function checks if the current page is an author archive and, if so,
 * redirects the user to the homepage.
 *
 * @return void
 */
function disable_author_archive() {
	if ( is_author() ) {
		wp_redirect( home_url() );
		exit;
	}
}
add_action( 'template_redirect', 'disable_author_archive' );

?>
