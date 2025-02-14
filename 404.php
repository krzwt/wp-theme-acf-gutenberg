<?php
/**
 * The template for displaying 404 pages (not found)
 *
 */
if (!defined('ABSPATH') || !function_exists('add_filter')) {
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
		<div class="container">';
			echo '<div class="error-wrap text-center">';
				if( $title ){
					echo '<h1>'.$title.'</h1>';
				}else{
					echo'<h1 class="page-title">';
						echo '<span>'. __( 'Oops! That page can&rsquo;t be found.','noblis-wp') .'</span>';
					echo '</h1>';
				}
				if( $description ){
					echo '<div class="description p-large">'.$description.'</div>';
				}else{
					echo '<div class="description">';
						echo '<p>'.__('The Page You Requested Cannot Be Found. The Page You Are Looking For Might Have Been Removed, Had Its Name Changed, Or Is Temporarily Unavailable.','noblis-wp').'</p>';
						echo'</br>';
						echo '<h5>'.__('Please try the following:','noblis-wp').'</h5>';
						echo '<ul>';
							echo '<li>'.__('If you typed the page address in the Address bar, make sure that it is spelled correctly.','noblis-wp').'</li>';
							echo '<li>'.__('Open the ','noblis-wp').'<a href="'.get_home_url().'">'.__('Home Page</a> and look for links to the information you want.','noblis-wp').'</li>';
							echo '<li>'.__('Use the navigation bar on the left or top to find the link you are looking for.','noblis-wp').'</li>
						</ul>';
						echo '<a href="'.get_home_url().'" class="btn mt-15">'.__('Back To Home','noblis-wp').'</a>';
					echo '</div>';
				}
				echo '<form class="error-search-wrap" action="'.home_url( '/' ).'" >';
					echo '<div class="error-search-field">
						<input type="search" name="s" id="header_search_input" placeholder="'.__('Search', 'noblis-wp').'">
						<button class="icon-search" type="submit"></button>
					</div>
				</form>
				<a href="'.home_url( '/' ).'" class="btn">Back to Homepage</a>';
			echo '</div>';
			if( $suggested_heading || $add_suggested_card ) {
				echo '<div class="error-suggested-section gradient-primary">';
					if( $suggested_heading ) echo '<h3 class="h3 text-center">'.$suggested_heading.'</h3>';
					if( $add_suggested_card ) {
						echo '<div class="row error-row">';
							while( have_rows('add_suggested_card', 'options') ) { the_row();
								$icon        = get_sub_field('icon');
								$title       = get_sub_field('title');
								$description = get_sub_field('description');
								$cta         = get_sub_field('cta');

								if( $icon || $title || $description || $cta ) {
									echo '<div class="cell-lg-4 cell-md-6">
										<div class="error-suggest-card">';
											if( $icon || $title ) {
												echo '<div class="error-s-top">';
													if( $icon ) {
														echo '<div class="error-s-icon">';
															echo acf_img( $icon );
														echo '</div>';
													}
													if( $title ) echo '<h4 class="h4	">'.$title.'</h4>';
												echo '</div>';
											}
											if( $description ) echo $description;
											if( $cta ) echo acf_link( $cta, 'btn-link' );
										echo '</div>
									</div>';
								}
							}
						echo '</div>';
					}
				echo '</div>';
			}
		echo '</div>
	</section>
</main>';
get_footer();