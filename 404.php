<?php

/**
 * The template for displaying 404
 *
 * @package ThemeName
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

get_header();

$title             	 = get_field( 'title', 'options' );
$description         = get_field( 'description', 'options' );
$suggested_heading 	 = get_field( 'suggested_heading', 'options' );
$add_suggested_card  = get_field( 'add_suggested_card', 'options' );

echo '<main class="main-content">
	<section class="error-404">
		<div class="container">
			<div class="error-wrap text-center">';
				if( $title ) {
					echo '<h1>'.$title.'</h1>';
				} else {
					echo'<h1 class="page-title">';
						echo '<span>'. __( 'Oops! That page can&rsquo;t be found.','textdomain' ) .'</span>';
					echo '</h1>';
				}
				if( $description ) {
					echo '<div class="description p-large">'.$description.'</div>';
				} else {
					echo '<div class="description">';
						echo '<p>'.__('The Page You Requested Cannot Be Found. The Page You Are Looking For Might Have Been Removed, Had Its Name Changed, Or Is Temporarily Unavailable.','textdomain' ).'</p>';
						echo'</br>';
						echo '<h5>'.__('Please try the following:','textdomain' ).'</h5>';
						echo '<ul>';
							echo '<li>'.__('If you typed the page address in the Address bar, make sure that it is spelled correctly.','textdomain' ).'</li>';
							echo '<li>'.__('Open the ','textdomain' ).'<a href="'.get_home_url().'">'.__('Home Page</a> and look for links to the information you want.','textdomain' ).'</li>';
							echo '<li>'.__('Use the navigation bar on the left or top to find the link you are looking for.','textdomain' ).'</li>
						</ul>';
						echo '<a href="'.get_home_url().'" class="btn mt-15">'.__( 'Back To Home','textdomain' ).'</a>
					</div>';
				}
			echo '</div>
		</div>
	</section>
</main>';
get_footer();
