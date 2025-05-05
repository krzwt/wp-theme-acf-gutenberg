<?php

/**
 * The template for displaying site header
 *
 * @package mytheme
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes() ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset') ?>" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />
    <!-- <meta name="theme-color" content="#7b0a2e"/> -->
  <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
    <?php echo get_field( 'add_code_in_head', 'options' ); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<?php echo get_field( 'add_code_in_body_tag', 'options' ); ?>
 <div class="wrapper">
        <?php $brand_logo = get_template_directory_uri() . '/assets/images/logo.svg';
        echo ' <header class="main-header">
            <div class="container d-flex justify-content-between align-items-center flex-nowrap">';
        if ($brand_logo) {
            echo'<a href="' . home_url('/') . '" class="brand">
						<img src="' . $brand_logo . '" alt="' . get_bloginfo('name') . '">
					</a>';
        }
                echo '<div class="nav-menu d-flex justify-content-end align-items-center flex-nowrap">';
        if (has_nav_menu('menu-1')) {
            echo'<div class="navigation">
							<nav class="d-flex justify-content-end align-items-center flex-nowrap">';
            wp_nav_menu(array('theme_location' => 'menu-1','container' => 'ul'));
            echo'</nav>
						</div>';
        }
                    echo '<a href="#" class="btn">Button</a>';
        echo'<!-- Hamburger -->
						<a href="javascript:;" class="hamburger" role="button" aria-label="Hamburger"><span></span></a>
					</div>
            </div>
			<!-- Device menu -->
			<div class="mbnav d-md-none">
				<div class="mbnav__backdrop"></div>
				<div class="mbnav__state" data-clickable="true">
					<!--  main responsive menu -->
					<div class="mbnav__inner">';
        if (has_nav_menu('menu-1')) {
            wp_nav_menu(array('theme_location' => 'menu-1','container' => 'ul'));
        }
                    echo'</div>
				</div>
			</div>
        </header>';
