<?php

use Vital\VitalMustache;

// Fetch Main Menu
if (has_nav_menu('footer_nav')) {
	$args['footer_menu'] = wp_nav_menu([
		'theme_location'  => 'footer_nav',
		'container'       => 'div',
		'container_class' => 'footer-menu-wrapper',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'      => 'menu footer-menu group',
		'menu_id'         => 'footer-menu',
		'depth'           => 0,
		'echo'            => 0,
	]);
}

// Fetch the Terms Menu
if (has_nav_menu('footer_terms')) {
	$args['footer_terms'] = wp_nav_menu([
		'theme_location'  => 'footer_terms',
		'container'       => 'div',
		'container_class' => 'footer-terms-wrapper',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'      => 'menu footer-terms group',
		'menu_id'         => 'footer-terms',
		'depth'           => 0,
		'echo'            => 0,
	]);
}

$copyright = get_option('options_copyright_text');
if ($copyright) {
	$args['copyright_text'] = str_replace('{year}', gmdate('Y'), $copyright);
}

if (function_exists('cher_profile_urls')) {
	$social_links = cher_profile_urls();
	$args['cher_profile_urls'] = '<ul class="social-links">';
	foreach ($social_links as $id => $link) {
		if ($link) {
			$args['cher_profile_urls'] .= '<li class="item icon icon-' . $id . '" ><a class="link" href=' . $link . ' target="_blank"><span class="screen-reader-text">Mortage-Office ' . $id . ' Page (opens a new window)</span></a></li>';
		}
	}

	$args['cher_profile_urls'] .= '</ul>';
}

// Render mustache template
if (class_exists('Vital\VitalMustache')) {
	VitalMustache::render('template/footer-default', $args);
}
