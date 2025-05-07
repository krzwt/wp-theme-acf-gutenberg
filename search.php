<?php
/**
 * The template for displaying search results pages.
 *
 * @package ThemeName
 */

get_header();

$search_text = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';
global $wp_query;
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
?>

<div class="main-content search-result-page">
	<div class="container">
		<div class="breadcrumbs">
			<ul>
				<?php
				if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
				}
				?>
			</ul>
		</div>
	</div>

	<section class="sr-banner">
		<div class="container">
			<div class="search-form-wrap">
				<?php
				$pager = isset( $_REQUEST['pager'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pager'] ) ) : '1';
				?>
				<form method="get" class="search-form" id="filter_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" name="s" value="<?php echo esc_attr( $search_text ); ?>" placeholder="<?php esc_attr_e( 'Search', 'textdomain' ); ?>" />
					<button type="submit" class="icon-search"><?php esc_html_e( 'Search', 'textdomain' ); ?></button>
					<input type="hidden" name="pager" id="pager" value="<?php echo esc_attr( $pager ); ?>">
				</form>
			</div>
		</div>
	</section>

	<section class="sr-block">
		<div class="container">
			<div class="sr-result">
				<?php if ( have_posts() ) : ?>
					<span class="sr-value">
						<?php
						printf(
							esc_html( _n( '%d result for', '%d results for', (int) $wp_query->found_posts, 'textdomain' ) ),
							(int) $wp_query->found_posts
						);
						?>
					</span>
					<div class="sr-term"><?php echo esc_html( $search_text ); ?></div>

					<?php
					while ( have_posts() ) :
						the_post();
						$post_id           = get_the_ID();
						$alt               = '';
						$featured_img_url  = get_the_post_thumbnail_url( $post_id, 'full' );
						if ( ! $featured_img_url ) {
							$attachment_id = get_post_thumbnail_id( $post_id );
							$alt           = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
						}
						$cat_terms_string = '';
						$cat_terms        = get_the_terms( $post_id, 'category' );
						if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
							$cat_terms_string = join( ', ', wp_list_pluck( $cat_terms, 'name' ) );
						}
						$description = get_the_excerpt( $post_id );
						$length      = 230;
						if ( strlen( $description ) > $length ) {
							$description = substr( $description, 0, $length ) . ' ...';
						}
						?>

						<div class="sr-items search-p-<?php echo esc_attr( $post_id ); ?>">
							<div class="row">
								<?php if ( $featured_img_url ) : ?>
									<div class="cell-sm-4 pl-xl-30">
										<figure class="sr-img">
											<img src="<?php echo esc_url( $featured_img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
										</figure>
									</div>
								<?php endif; ?>

								<div class="cell-sm-8 sr-content">
									<div class="sr-desc">
										<?php if ( $cat_terms_string ) : ?>
											<div class="sr-type"><?php echo esc_html( $cat_terms_string ); ?></div>
										<?php endif; ?>

										<h4>
											<a href="<?php the_permalink(); ?>" class="sr-title">
												<?php the_title(); ?>
											</a>
										</h4>

										<?php if ( $description ) : ?>
											<p><?php echo esc_html( $description ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>

					<?php if ( $wp_query->max_num_pages > 1 ) : ?>
						<?php
						$prev_link = get_pagenum_link( $paged - 1 );
						$next_link = get_pagenum_link( $paged + 1 );
						?>
						<div class="pagination d-flex justify-content-center">
							<ul>
								<li>
									<?php if ( $paged == 1 ) : ?>
										<a class="prev disabled" aria-disabled="true"><?php esc_html_e( 'Prev', 'textdomain' ); ?></a>
									<?php else : ?>
										<a href="<?php echo esc_url( $prev_link ); ?>" class="prev"><?php esc_html_e( 'Prev', 'textdomain' ); ?></a>
									<?php endif; ?>
								</li>
								<li><?php echo esc_html( $paged ); ?></li>
								<li><?php esc_html_e( 'of', 'textdomain' ); ?></li>
								<li><?php echo esc_html( $wp_query->max_num_pages ); ?></li>
								<li>
									<?php if ( $wp_query->max_num_pages == $paged ) : ?>
										<a class="next disabled" aria-disabled="true"><?php esc_html_e( 'Next', 'textdomain' ); ?></a>
									<?php else : ?>
										<a href="<?php echo esc_url( $next_link ); ?>" class="next"><?php esc_html_e( 'Next', 'textdomain' ); ?></a>
									<?php endif; ?>
								</li>
							</ul>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<h5>
						<?php
						echo esc_html__( 'No post is available for', 'textdomain' ) . ': ' . esc_html( $search_text );
						?>
					</h5>
				<?php endif; ?>
			</div>
		</div>
	</section>
</div>

<?php get_footer(); ?>
