<?php
/**
 * The template for displaying search results pages
 *
 * @since 1.0.0
 */
get_header();
$search_text = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
$search_text = strip_tags( trim($search_text) );
global $wp_query;
$pager = (get_query_var('paged')) ? get_query_var('paged') : 1;

echo '<main class="main-content search-result-page">';
    echo '<section class="sr-banner">
        <div class="container">';
            echo '<div class="search-form-wrap">';
                echo '<form method="get" class="search-form" id="filter_form" action="'.esc_url( home_url( '/' ) ).'">
                    <input type="search" value="'.$search_text.'" name="s" placeholder="'.__('Search', 'custom-wp').'" />
                    <button class="icon-search">Search</button>
                </form>';
            echo '</div>
        </div>
    </section>
	<section class="sr-block">
		<div class="container">
			<div class="sr-result">';
				if ( have_posts() ) {
					echo '<div class="sr-topwrap">
						<span class="sr-value">';
							printf( esc_html( _n( '%d Results for', '%d Results for', (int) $wp_query->found_posts, 'custom-wp' ) ),
							(int) $wp_query->found_posts );
						echo '</span>';
						echo '<div class="sr-term h4">'.$search_text.'</div>
					</div>';
					while ( have_posts() ) {
						the_post();
						$post_id = get_the_ID();
						$alt = '';
						$featured_img_url = get_the_post_thumbnail_url( $post_id,'full');
						if( !$featured_img_url ){
							$attachment_id = get_post_thumbnail_id( $post_id );
							$alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
						}
						$cat_terms_string = '';
						$cat_terms = get_the_terms($post_id, 'category');
						if ($cat_terms && !is_wp_error($cat_terms)) {
							$cat_terms_string = join(', ', wp_list_pluck($cat_terms, 'name'));
						}

						$description = get_the_excerpt($post_id);
						$length = 230;
						if (strlen($description) <= $length) {
							$description = $description;
						} else {
							$description = substr($description, 0, $length) . ' ...';
						}

						$date = '';
						$event_display_date  = get_field( 'event_display_date', $post_id  );
						$pd_display_date	 = get_field( 'pd_display_date', $post_id  );
						if( get_post_type() == 'event' && $event_display_date ) {
							$date  = date( 'd F Y', strtotime($event_display_date) );
						} else {
							if( $pd_display_date )
							$date  = date( 'd F Y', strtotime($pd_display_date) );
						}

						echo '<div class="sr-items search-p-'.$post_id.'">
							<div class="row align-items-center">';
								if( $featured_img_url ) {
									echo '<div class="cell-md-4">
										<figure class="sr-img">
											<img src="'.$featured_img_url.'" alt="'.$alt.'">
										</figure>
									</div>';
								}
								echo '<div class="cell-md-8 sr-content">
									<div class="sr-desc">';
										if( $cat_terms_string || $date ) {
											echo '<div class="sr-wrapper">';
												if( $cat_terms_string ) {
													echo '<div class="sr-type">'.$cat_terms_string.'</div>';
													echo '<span class="space"></span>';
												}
												if( $date ) { echo '<div class="sr-date">'.$date.'</div>'; }
											echo '</div>';
										}
										echo '<h4><a href="'.get_permalink( $post_id ).'" target="" class="sr-title">'.get_the_title( $post_id ).'</a></h4>';

										if( $description ) {
											echo '<p>'.$description.'</p>';
										}
									echo '</div>
								</div>
							</div>
						</div>';
					} // End the loop.
					if( $wp_query->max_num_pages > 1 ) {
						echo '<div class="pagination d-flex justify-content-center ajax-page" id="ajax-pagination">';
							if ($pager == 1) {
								echo '<ul class="page-numbers"><li class="prev-nav"><a href="javascript:void(0);" class="prev disabled" disable><i class="icon-pagination-left"></i></a></li></ul>';
							}
							echo paginate_links( array(
								'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
								'total'        => $wp_query->max_num_pages,
								'current'      => max( 1, $pager ),
								'format'       => '?pager=%#%',
								'show_all'     => false,
								'type'         => 'list',
								'end_size'     => 1,
								'mid_size'     => 4,
								'prev_next'    => true,
								'prev_text'    => sprintf( '<i class="icon-pagination-left"></i>','' ),
								'next_text'    => sprintf( '<i class="icon-pagination-right"></i>','' ),
								'add_args'     => false,
								'add_fragment' => '',
							) );
							if ( $wp_query->max_num_pages == $pager ) {
								echo '<ul class="page-numbers"><li class="next-nav"><a href="javascript:void(0);" class="next  disabled " disable><i class="icon-pagination-right"></i></a></li></ul>';
							}
						echo '</div>';
					}
				} else {
					echo '<h5> '.__('No post is available for','custom-wp').': '.$search_text.'</h5>';
				}
			echo '</div>
		</div>
	</section>
</main>';
get_footer();
?>