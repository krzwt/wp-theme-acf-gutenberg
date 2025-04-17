<?php
/**
* Default site header.
*/

if ( !defined( 'ABSPATH' ) || !function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />
    <!-- <meta name="theme-color" content="#7b0a2e"/> -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
	<?php echo get_field( 'add_code_in_head', 'options' ); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
    <?php echo get_field( 'add_code_in_body_tag', 'options' ); ?>
	<?php
	echo '<!-- Start -->
	<div class="wrapper">
		<!-- Device menu -->
        <div class="mbnav d-md-none">
            <div class="mbnav__backdrop"></div>
            <div class="mbnav__state" data-clickable="true">
                <!--  main responsive menu -->
                <div class="mbnav__inner">';
                if ( has_nav_menu( 'main-menu' ) ) {
                    wp_nav_menu(array('theme_location' => 'main-menu','container' => 'ul'));
                }
                echo'</div>
            </div>
        </div>';
        $brand_logo = get_field( 'brand_logo','option' );
        echo'<header class="main-header">
            <div class="container d-flex justify-content-between align-items-center">';
            if($brand_logo){
                echo'<a href="'.home_url( '/' ).'" class="brand">
                    <img src="'.$brand_logo['url'].'" alt="'.get_bloginfo('name').'">
                </a>';
            }
            if ( has_nav_menu( 'main-menu' ) ) {
                echo'<div class="navigation">
                    <nav>';
                        wp_nav_menu(array('theme_location' => 'main-menu','container' => 'ul'));
                    echo'</nav>
                </div>';
            }
            // echo '<div class="header-search">
            //                 <i class="header-search-btn icon-search"></i>
            //                 <div class="h-search-wrap">';
            //                     $search_text = isset( $_GET['s'] ) ?  $_GET['s'] : '';
            //                     echo '<form class="h-search-form-wrap" action="'.home_url( '/' ).'" method="get">
            //                         <div class="h-search-field">
            //                             <input type="search" name="s" placeholder="'.__('Search', 'wpstarter').'">
            //                             <button class="icon-search" type="submit">Search</button>
            //                         </div>
            //                     </form>
            //                 </div>
            //             </div>';
            echo'<!-- Hamburger -->
            <a href="javascript:;" class="hamburger" role="button" aria-label="Hamburger"><span></span></a>
            </div>
        </header>';
